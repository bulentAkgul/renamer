<?php

namespace Bakgul\Renamer\Contracts;

use Bakgul\FileHistory\Services\LogServices\ForUndoingLogService;
use Bakgul\Renamer\Tasks\BuildConsoleOutput;
use Illuminate\Support\Facades\File;

abstract class Renamer extends ExecutorService
{
    protected array $keys = [
        'src' => 'renamings',
        'loop' => 'renamings',
        'log' => 'renamings',
    ];

    public function handle(array $props): array
    {
        $this->props = $props;

        array_map(fn ($x) => $this->rename($x), $this->props[$this->keys['loop']]);

        return $this->props;
    }

    protected function rename(array $paths)
    {
        File::move($paths['from'], $paths['to']);

        $this->setChangeLog($paths['from'], $paths['to']);

        $this->displayLog();

        $this->setLog();
    }

    protected function displayLog()
    {
        $builder = new BuildConsoleOutput($this->getLog(), 'rename');

        $this->props['command']['instance']->line(
            implode("\n", [
                '',
                ...$builder->outputTitle($this->titleKey()),
                ...$builder->outputCompare(),
                ''
            ])
        );
    }

    private function titleKey(): string
    {
        return $this->isFolder() ? 'folder' : 'file';
    }

    private function setLog()
    {
        ForUndoingLogService::set($this->getLog(), $this->isFolder(), false);
    }
}
