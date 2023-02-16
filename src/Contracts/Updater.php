<?php

namespace Bakgul\Renamer\Contracts;

use Bakgul\FileContent\Tasks\WriteToFile;

abstract class Updater extends ExecutorService
{
    public function handle(array $props): array
    {
        $this->props = $props;

        array_map(fn ($x) => $this->update($x), $this->props[$this->keys['loop']]);

        return $this->props;
    }

    public function update(array|string $data): void
    {
        $content = file($data);
        $isMutated = false;

        foreach ($content as $i => &$line) {
            foreach ($this->props[$this->keys['src']] as $change) {
                if ($this->isIrrelevant($line, $change)) continue;

                $line = $this->updateLine($line, $i, [...$change, 'file' => $data]);

                $isMutated = true;
            }
        }

        $this->write($data, $content, $isMutated);
    }

    private function isIrrelevant(string $line, array $change): bool
    {
        return !str_contains($line, $change['from']);
    }

    protected function updateLine(string $line, int $index, array $data): string
    {
        $newLine = str_replace($data['from'], $data['to'], $line);

        $this->setChangeLog($line, $newLine, $data['file'], $index);

        $this->displayLog();

        return $newLine;
    }

    protected function write(string $path, array $content, bool $isMutated)
    {
        if ($isMutated) WriteToFile::_(implode('', $content), $path);
    }
}
