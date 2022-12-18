<?php

namespace Bakgul\Renamer\Services;

use Bakgul\Renamer\Contracts\Modifier;
use Bakgul\Renamer\Contracts\Renamer;

class RenameService extends Modifier
{
    public function __invoke(Renamer $service, array $props): array
    {
        return $service->handle($props);
    }
}
