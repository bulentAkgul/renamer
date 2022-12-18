<?php

namespace Bakgul\Renamer\Commands;

use Bakgul\FileHistory\Concerns\HasHistory;
use Bakgul\Kernel\Concerns\HasPreparation;
use Bakgul\Kernel\Concerns\HasRequest;
use Bakgul\Kernel\Helpers\Settings;
use Bakgul\Renamer\Services\PropSetterService;
use Bakgul\Renamer\Services\RenameService;
use Bakgul\Renamer\Services\RenameServices\RenameFileService;
use Bakgul\Renamer\Services\RenameServices\RenameFolderService;
use Bakgul\Renamer\Services\UpdateService;
use Bakgul\Renamer\Services\UpdateServices\UpdateFileContentService;
use Bakgul\Renamer\Services\UpdateServices\UpdateOwnedNamespaceService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;

class RenameCommand extends Command
{
    use HasHistory, HasPreparation, HasRequest;

    protected $signature = 'rename {from} {to} {--f|folder}';
    protected $description = '';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        ray()->clearAll();
        if (env('APP_ENV') != 'testing') {
            Settings::set('renameables.warnings.is_not_a_test', false);

            Artisan::call('delete-logs');

            $path = base_path('_test_repo/app/Renamings');

            File::deleteDirectory($path);
            File::copyDirectory(__DIR__ . '/../../files/Renamings', $path);
        }


        if ($this->isTerminated()) return;

        $this->logFile();

        $this->setProps();

        $this->update();

        $this->rename();

        Artisan::call('undo-log');
        Artisan::call('redo-log');
    }

    private function isTerminated(): bool
    {
        return $this->isRisky() ? $this->isStopped() : false;
    }

    private function isRisky()
    {
        return env('APP_ENV') != 'testing'
            && Settings::get('renameables', 'warn_me_in_console');
    }

    private function isStopped()
    {
        return $this->confirm($this->message()) == false;
    }

    private function message()
    {
        return implode("\n ", [
            'This command will change your files.',
            'Do you want to proceed?'
        ]);
    }

    private function setProps()
    {
        $this->props = (new PropSetterService)->set($this);
    }

    private function update()
    {
        $this->props = (new UpdateService)($this->setUpdater(), $this->props);
    }

    private function setUpdater()
    {
        return $this->props['basics']['is_folder']
            ? new UpdateOwnedNamespaceService
            : new UpdateFileContentService;
    }

    private function rename()
    {
        (new RenameService)($this->setRenamer(), $this->props);
    }

    private function setRenamer()
    {
        return $this->props['basics']['is_folder']
            ? new RenameFolderService
            : new RenameFileService;
    }
}