<?php

namespace Bakgul\Renamer\Contracts;

use Bakgul\Renamer\Actions\CreatePair;

abstract class NamespaceSetter
{
    protected function getNamespaces($path)
    {
        foreach (file($path) as $line) {
            if ($this->isNamespace($line)) return $this->setNamespaces($line, $path);
        }
    }

    protected function isNamespace($line)
    {
        return str_contains($line, 'namespace ');
    }

    protected function setNamespaces($line, $path)
    {
        return [
            'file' => $path,
            ...CreatePair::_(fn ($k) => $this->setNamespace($line, $k))
        ];
    }

    public function setNamespace(string $line, string $key): string
    {
        return implode('\\', array_map(
            fn ($x) => $this->setFolder($x, $key),
            explode('\\', $this->isolateNamespace($line))
        ));
    }

    protected function isolateNamespace(string $line)
    {
        return str_replace(';', '', trim(explode('namespace', $line)[1]));
    }

    protected function setFolder(string $folder, string $key): string
    {
        return $this->isRenameable($folder, $key) ? $this->props['basics']['to']['arg'] : $folder;
    }

    protected function isRenameable(string $folder, string $key): bool
    {
        return $key == 'to' && $folder == $this->props['basics']['from']['arg'];
    }

    abstract public function __invoke(): array;
}
