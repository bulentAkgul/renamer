<?php

namespace Bakgul\Renamer\Services\PropSetterServices;

use Bakgul\Kernel\Helpers\Settings;

class BasicsSetterService
{
    public function __construct(private array $props)
    {
    }

    public function __invoke(): array
    {
        return ['basics' => $this->set()];
    }

    private function set(): array
    {
        return [
            'from' => $f = $this->from(),
            'to' => $this->to($f),
            'is_folder' => $this->isFolder($f),
            'folders' => $this->getFolders()
        ];
    }

    private function from()
    {
        return $this->side('from', $this->fallback('from'));
    }

    private function to($from)
    {
        return $this->side('to', $this->fallback('to', $from));
    }

    private function fallback(string $key, array $src = null)
    {
        return $key == 'from' ? ($this->props['command']['options']['folder'] ? '' : null) : $src['ext'];
    }

    private function side($side, $fallback)
    {
        return [
            'name' => $n = $this->name($side),
            'ext' => $e = $this->ext($side, $fallback),
            'arg' => $this->arg([$n, $e])
        ];
    }

    private function name($key)
    {
        return explode('.', $this->props['command']['arguments'][$key])[0];
    }

    private function ext($key, $fallback)
    {
        return explode('.', $this->props['command']['arguments'][$key])[1] ?? $fallback ?? 'php';
    }

    private function arg($parts)
    {
        return implode('.', array_filter($parts));
    }

    private function isFolder($from): bool
    {
        return $this->props['command']['options']['folder'] ?: !$from['ext'];
    }

    private function getFolders()
    {
        return Settings::get('renameables.folders', $this->folderKey());
    }

    private function folderKey(): string
    {
        return config('app.env') == 'testing' ? 'testing' : 'default';
    }
}
