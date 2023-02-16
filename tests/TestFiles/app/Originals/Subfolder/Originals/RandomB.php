<?php

namespace App\Renamings\Originals\Subfolder\Originals;

use App\Renamings\Originals\Subfolder\MostOriginals\RandomG;
use App\Renamings\Traits\Randomize;

class RandomB
{
    use Randomize;

    public function random()
    {
        $this->randomize();

        (new RandomA)->random();

        RandomG::_();
    }
}
