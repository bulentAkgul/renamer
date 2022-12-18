<?php

namespace Bakgul\Renamer\Tests\Feature\ServiceTests;

use Bakgul\Renamer\Services\PropSetterService;
use Bakgul\Renamer\Tests\TestCase;

class PropSetterServiceTest extends TestCase
{
    /** @test */
    public function props_will_be_generated_as_expected()
    {
        (new PropSetterService)->set([
            'args' => ['from' => 'Traits', 'to' => 'Concerns'],
            'opts' => ['folder' => true]
        ]);
    }
}
