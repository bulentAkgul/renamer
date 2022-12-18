<?php

namespace Bakgul\Renamer\Services;

use Bakgul\Renamer\Services\PropSetterServices\BasicsSetterService;
use Bakgul\Renamer\Services\PropSetterServices\FileContentSetterService;
use Bakgul\Renamer\Services\PropSetterServices\OwnedNamespaceSetterService;
use Bakgul\Renamer\Services\PropSetterServices\PathSetterService;
use Bakgul\Renamer\Services\PropSetterServices\RenameSetterService;
use Bakgul\Renamer\Services\PropSetterServices\UsingNamespaceSetterService;
use Illuminate\Console\Command;

class PropSetterService
{
    const PIPELINE = [
        BasicsSetterService::class,
        RenameSetterService::class,
        OwnedNamespaceSetterService::class,
        UsingNamespaceSetterService::class,
        FileContentSetterService::class,
        PathSetterService::class,
    ];

    public function set(Command $command): array
    {
        return array_reduce(
            self::PIPELINE,
            fn ($props, $class) => $props + (new $class($props, $command))(),
            $this->initProps($command)
        );
    }

    public function initProps(Command $command): array
    {
        return [
            'command' => [
                'instance' => $command,
                'arguments' => $command->arguments(),
                'options' => $command->options(),
            ]
        ];
    }
}
