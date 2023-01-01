<?php

namespace Bakgul\Renamer\Services\PropSetterServices;

use Bakgul\Kernel\Helpers\Settings;
use Bakgul\Kernel\Helpers\Str;
use Bakgul\Renamer\Contracts\NamespaceSetter;
use Bakgul\Kernel\Helpers\Arr;

class UsingNamespaceSetterService extends NamespaceSetter
{
    public function __construct(protected array $props)
    {
    }

    public function __invoke(): array
    {
        return ['using_ns' => $this->set()];
    }

    private function set(): array
    {
        return $this->generateVariations($this->convert() ?: $this->generate());
    }

    private function convert(): array
    {
        $namespaces = [];

        foreach ($this->props['owned_ns'] as $namespace) {
            $namespaces[] = [
                'file' => $namespace['file'],
                'from' => $this->convertNamespace($namespace, 'from'),
                'to' => $this->convertNamespace($namespace, 'to'),
            ];
        }

        return $namespaces;
    }

    private function convertNamespace(array $namespaces, string $key): string
    {
        return "{$namespaces[$key]}\\{$this->getName($namespaces['file'])}";
    }

    private function getName(string $file): string
    {
        return Str::getTail(explode('.', $file)[0]);
    }

    private function generate(): array
    {
        $namespaces = [];

        foreach ($this->props['renamings'] as $paths) {
            $namespaces[] = $this->appendName($this->getNamespaces($paths['from']));
        }

        return $namespaces;
    }

    private function appendName(array $namespace)
    {
        foreach (['from', 'to'] as $key) {
            $namespace[$key] .= "\\{$this->props['basics'][$key]['name']}";
        }

        return $namespace;
    }

    private function generateVariations(array $namespaces): array
    {
        return array_reduce(
            $this->getCheckers(),
            fn ($p, $c) => [...$p, ...$this->applyCheckerTo($namespaces, $c)],
            []
        );
    }

    private function getCheckers(): array
    {
        return array_map(fn ($x) => "{$x[0]}{$x[1]}", $this->extendCheckers());
    }

    private function extendCheckers()
    {
        return Arr::crossJoin([' ', ' \\'], Settings::get('renameables.namespace_checkers'));
    }

    private function applyCheckerTo($namespaces, $checker): array
    {
        foreach ($namespaces as &$namespace) {
            $namespace['from'] = str_replace('{x}', $namespace['from'], $checker);
            $namespace['to'] = str_replace('{x}', $namespace['to'], $checker);
        }

        return $namespaces;
    }
}
