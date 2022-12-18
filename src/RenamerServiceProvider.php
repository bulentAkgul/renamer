<?php

namespace Bakgul\Renamer;

use Bakgul\Kernel\Concerns\HasConfig;
use Illuminate\Support\ServiceProvider;

class RenamerServiceProvider extends ServiceProvider
{
    use HasConfig;

    public function boot()
    {
        $this->commands([
            \Bakgul\Renamer\Commands\RenameCommand::class,
        ]);
    }

    public function register()
    {
        $this->registerConfigs(__DIR__ . DIRECTORY_SEPARATOR . '..');
    }
}
