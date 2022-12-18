<?php

namespace Bakgul\Renamer\Services\UpdateServices;

use Bakgul\Renamer\Contracts\Updater;

class UpdateFileContentService extends Updater
{
    protected array $keys = [
        'src' => 'content',
        'loop' => 'paths',
        'log' => 'content',
    ];
}
