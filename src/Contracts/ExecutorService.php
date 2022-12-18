<?php

namespace Bakgul\Renamer\Contracts;

use Bakgul\Renamer\Tasks\BuildConsoleOutput;

abstract class ExecutorService
{
    protected function setChangeLog(string $from, string $to, string $path = '', int $index = 0)
    {
        $this->props['changeLog'][$this->keys['log']][] = [
            'file' => $path,
            'line' => $index + 1,
            'from' => trim($from),
            'to' => trim($to)
        ];
    }

    protected function displayLog()
    {
        $this->props['command']['instance']->line(
            (new BuildConsoleOutput($this->getLog(), 'update'))->handle()
        );
    }

    protected function getLog(): array
    {
        return array_reverse($this->props['changeLog'][$this->keys['log']])[0];
    }

    protected function isFolder(): bool
    {
        return $this->props['basics']['is_folder'];
    }
}
