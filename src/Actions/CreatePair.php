<?php

namespace Bakgul\Renamer\Actions;

use Bakgul\Kernel\Helpers\Arry;

class CreatePair
{
    public static function _(callable $callback): array
    {
        return Arry::assocMap(['from' => 0, 'to' => 0], $callback);
    }
}
