<?php

namespace Tyler36\Deployment\Commands;

use Illuminate\Console\Command;

/**
 * Class Setup
 */
class Setup extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'deploy:setup';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Post deploy setup.';

    /**
     * Commands to be run
     *
     * @var array
     */
    protected $list;

    protected $progress;

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->info(trans('admin.deploy.prepare'));

        $commands = $this->getCommands();

        $this->progress = $this->output->createProgressBar($commands->count());

        $commands->each(function ($item) {
            $this->progress->advance();
            $this->initCommand($item);
        });
    }

    /**
     * Get array of commands to run for deployment
     *
     * @return array
     */
    public function getCommands()
    {
        return collect(config('deployment.commands', []));
    }

    /**
     * Find command string and execute
     *
     * @param [type] $command
     *
     * @return void
     */
    public function initCommand($command)
    {
        if (!$command) {
            return;
        }

        return (method_exists($this, $command))
            ? $this->executeCommand($this->{$command}())
            : $this->executeCommand($command);
    }

    /**
     * Update composer
     *
     * @return void
     */
    public function updateComposer()
    {
        if (file_exists('composer.phar')) {
            return 'php composer.phar install';
        }

        return 'composer install';
    }

    /**
     * Generate spaces to align output correctly
     *
     * @return void
     */
    public function getSpacingOffset()
    {
        return str_repeat(' ', 43);
    }

    /**
     * Utility function to run exec()
     *
     * @param mixed $command
     *
     * @return mixed
     */
    private function executeCommand($command)
    {
        $this->info("   Running command: ${command} ... ");

        exec($command, $output, $return);

        // Display any output or error
        if (!empty($output)) {
            foreach ($output as $line) {
                if (false !== $return) {
                    $this->info($this->getSpacingOffset().$line);

                    continue;
                }

                $this->error($line);
            }
        }
    }
}
