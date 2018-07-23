<?php

namespace Tyler36\Deployment;

use Illuminate\Support\ServiceProvider;

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
        $this->publishes([__DIR__.'/Confirmation.php' => app_path('Confirmation.php')]);

        // Import commands
        if ($this->app->runningInConsole()) {
            $this->commands([
                Environment::class,
                Setup::class,
            ]);
        }
    }
}
