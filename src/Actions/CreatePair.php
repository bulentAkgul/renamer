<?php

namespace Bakgul\Renamer\Actions;

use Bakgul\LaravelHelpers\Helpers\Arr;

class CreatePair
{
    public static function _(callable $callback): array
    {
        return Arr::mapAssoc(['from' => 0, 'to' => 0], $callback);
    }
}
