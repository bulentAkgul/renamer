<?php

namespace Bakgul\Renamer\Actions;

use Bakgul\Kernel\Helpers\Arr;

class CreatePair
{
    public static function _(callable $callback): array
    {
        return Arr::assocMap(['from' => 0, 'to' => 0], $callback);
    }
}
