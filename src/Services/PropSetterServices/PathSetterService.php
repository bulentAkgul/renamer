<?php

namespace Bakgul\Renamer\Services\PropSetterServices;

use Bakgul\LaravelHelpers\Helpers\Folder;

class PathSetterService
{
    public function __construct(private array $props)
    {
    }

    public function __invoke(): array
    {
        return ['paths' => $this->set()];
    }

    private function set(): array
    {
        $paths = [];

        foreach ($this->props['basics']['folders'] as $folder) {
            $paths = [...$paths, ...Folder::files(base_path($folder))];
        }

        return $paths;
    }
}
