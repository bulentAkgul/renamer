<?php

namespace App\Renamings\Originals;

use App\Renamings\Originals\Subfolder\MostOriginals\RandomF;
use App\Renamings\Traits\Randomize;

class RandomA
{
    use Randomize;

    public function random()
    {
        $this->randomize();

        RandomF::_();
    }
}
