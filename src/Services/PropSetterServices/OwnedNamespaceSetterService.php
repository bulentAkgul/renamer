<?php

namespace Bakgul\Renamer\Services\PropSetterServices;

use Bakgul\Kernel\Helpers\Folder;
use Bakgul\Renamer\Contracts\NamespaceSetter;

class OwnedNamespaceSetterService extends NamespaceSetter
{
    public function __construct(protected array $props)
    {
    }

    public function __invoke(): array
    {
        return ['owned_ns' => $this->set()];
    }

    private function set(): array
    {
        return $this->isFolder() ? $this->generate() : [];
    }

    private function isFolder()
    {
        return $this->props['basics']['is_folder'];
    }

    private function generate(): array
    {
        $namespaces = [];

        foreach ($this->props['renamings'] as $paths) {
            foreach (Folder::files($paths['from']) as $path) {
                $namespaces[] = $this->getNamespaces($path);
            }
        }

        return $namespaces;
    }
}
