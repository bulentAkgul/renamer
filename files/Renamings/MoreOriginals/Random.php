<?php

namespace App\Renamings\MoreOriginals;

use App\Renamings\Traits\Randomize;

class Random
{
    use Randomize;

    public function random()
    {
        $this->randomize();
    }
}
