<?php

namespace Bakgul\Renamer\Services\PropSetterServices;

use Bakgul\Kernel\Helpers\Arr;
use Bakgul\Kernel\Helpers\Settings;

class FileContentSetterService
{
    private array $baseCases = [];

    public function __construct(private array $props)
    {
    }

    public function __invoke(): array
    {
        return ['content' => $this->set()];
    }

    private function set(): array
    {
        if ($this->isFolder()) return [];

        return Arr::map(
            Settings::get('renameables.content_checkers'),
            fn ($pattern) => $this->setContent($pattern)
        );
    }

    private function isFolder(): bool
    {
        return $this->props['basics']['is_folder'];
    }

    private function setContent(string $pattern)
    {
        return Arr::assocMap(['from' => 0, 'to' => 0], fn ($k) => $this->replace($pattern, $k));
    }

    private function replace(string $pattern, string $key)
    {
        return str_replace('{x}', $this->props['basics'][$key]['name'], $pattern);
    }
}
