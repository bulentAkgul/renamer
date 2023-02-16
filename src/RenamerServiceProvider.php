<?php

namespace Bakgul\Renamer;

use Illuminate\Support\ServiceProvider;

class RenamerServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->commands([
            \Bakgul\Renamer\Commands\RenameCommand::class,
        ]);

        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../config/config.php' => config_path('renamer.php'),
            ], 'config');
        }
    }

    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/config.php', 'renamer');
    }
}
