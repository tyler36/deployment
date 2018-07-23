<?php

namespace Tyler36\Deployment;

use Illuminate\Console\Command;

class Environment extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'deploy:env';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Swap .env file with desired environment';

    protected $names;

    protected $defaultEnv;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();

        $this->current        = '.env';
        $this->backup         = 'old';
        $this->defaultEnv     = config('deployment.default', 'test');
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        // Get new environment
        $this->envs = $this->getAvailableEnvironments();
        $requested  = $this->choice('Select an environment?', $this->envs, $this->defaultEnv);

        // Create backup if 'previous' was NOT selected
        if ('previous' !== $requested) {
            $this->backupCurrent();
        }

        // Replace file
        $this->replaceCurrent($requested);
    }

    /**
     * @param null|mixed $types
     *
     * @return mixed
     */
    public function getAvailableEnvironments($types = null)
    {
        $types = $types ?: config('deployment.envs');

        return collect($types)
            ->map(function ($item) {
                $filename = "{$this->current}.${item}";

                return file_exists($filename) ? $filename : null;
            })
            ->filter()
            ->toArray();
    }

    /**
     * Backup current environment
     *
     * @return void
     */
    public function backupCurrent()
    {
        $this->info('Backing up current environment ...');

        return copy($this->current, implode('', [$this->current, '.', $this->backup]));
    }

    /**
     * Override current ENV with desired
     *
     * @param mixed $requested
     *
     * @return void
     */
    public function replaceCurrent($requested)
    {
        $this->info('Updating setting');

        copy($this->envs[$requested] ?? $this->defaultEnv, $this->current);
    }
}
