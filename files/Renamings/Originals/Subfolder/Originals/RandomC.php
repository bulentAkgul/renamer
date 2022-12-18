<?php

namespace App\Renamings\Originals\Subfolder\Originals;

use App\Renamings\Originals\Subfolder\MostOriginals\RandomG;
use App\Renamings\Originals\Subfolder\MostOriginals\RandomH;
use App\Renamings\Traits\Randomize;

class RandomC
{
    use Randomize;

    public function random()
    {
        $this->randomize();

        (new RandomA)->random();

        RandomH::_();
        RandomG::_();
    }
}
