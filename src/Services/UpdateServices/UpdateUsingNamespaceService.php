<?php

namespace Bakgul\Renamer\Services\UpdateServices;

use Bakgul\Renamer\Contracts\Updater;

class UpdateUsingNamespaceService extends Updater
{
    protected array $keys = [
        'src' => 'using_ns',
        'loop' => 'paths',
        'log' => 'using_ns',
    ];
}
