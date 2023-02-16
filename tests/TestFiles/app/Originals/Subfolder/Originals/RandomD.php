<?php

namespace App\Renamings\Originals\Subfolder\Originals;

use App\Renamings\Originals\Subfolder\MostOriginals\RandomE;
use App\Renamings\Originals\Subfolder\MostOriginals\RandomG;
use App\Renamings\Traits\Randomize;

class RandomD
{
    use Randomize;

    public function random()
    {
        $this->randomize();

        (new \App\Renamings\Originals\Subfolder\Originals\RandomA)->random();
        (new RandomC)->random();

        RandomE::_();
        RandomG::_();
    }
}
