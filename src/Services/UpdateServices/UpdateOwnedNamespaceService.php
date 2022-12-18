<?php

namespace Bakgul\Renamer\Services\UpdateServices;

use Bakgul\Renamer\Contracts\Updater;

class UpdateOwnedNamespaceService extends Updater
{
    protected array $keys = [
        'src' => null,
        'loop' => 'owned_ns',
        'log' => 'owned_ns',
    ];

    public function update(array|string $data): void
    {
        $content = file($data['file']);

        foreach ($content as $i => &$line) {
            if ($this->isIrrelevant($line, $data)) continue;

            $line = $this->updateLine($line, $i, $data);
        }

        $this->write($data['file'], $content, true);
    }

    private function isIrrelevant(string $line, array $data)
    {
        return !str_contains($line, "namespace {$data['from']}");
    }
}
