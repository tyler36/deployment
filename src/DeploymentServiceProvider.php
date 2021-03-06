<?php

namespace Tyler36\Deployment;

use Illuminate\Support\ServiceProvider;
use Tyler36\Deployment\Commands\Environment;
use Tyler36\Deployment\Commands\Setup;

class DeploymentServiceProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot()
    {
        // CONFIG
        $this->publishes([__DIR__.'/Config/deployment.php' => config_path('deployment.php')]);

        // Import commands
        if ($this->app->runningInConsole()) {
            $this->commands([
                Environment::class,
                Setup::class,
            ]);
        }
    }
}
