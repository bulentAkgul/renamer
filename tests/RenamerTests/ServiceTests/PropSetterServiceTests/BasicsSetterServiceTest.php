<?php

namespace Bakgul\Renamer\Tests\RenamerTests\ServiceTests\PropSetterServiceTests;

use Bakgul\Renamer\Services\PropSetterServices\BasicsSetterService;
use Bakgul\Renamer\Tests\TestCase;

class BasicsSetterServiceTest extends TestCase
{
    private function service($args, $opts)
    {
        return (new BasicsSetterService($args, $opts))();
    }

    /** @test */
    public function basics_of_props_will_be_generated_as_expected()
    {
        $this->assertEquals(
            [
                'is_folder' => true,
                'from' => ['name' => 'Originals', 'ext' => '', 'arg' => 'Originals'],
                'to' => ['name' => 'NewOriginals', 'ext' => '', 'arg' => 'NewOriginals'],
            ],
            $this->service(['from' => 'Originals', 'to' => 'NewOriginals'], ['folder' => true])
        );

        $this->assertEquals(
            [
                'is_folder' => false,
                'from' => ['name' => 'Randomize', 'ext' => 'php', 'arg' => 'Randomize.php'],
                'to' => ['name' => 'Randomizer', 'ext' => 'php', 'arg' => 'Randomizer.php'],
            ],
            $this->service(['from' => 'Randomize', 'to' => 'Randomizer'], ['folder' => null])
        );

        $this->assertEquals(
            [
                'is_folder' => false,
                'from' => ['name' => 'Randomize', 'ext' => 'js', 'arg' => 'Randomize.js'],
                'to' => ['name' => 'Randomizer', 'ext' => 'php', 'arg' => 'Randomizer.php'],
            ],
            $this->service(['from' => 'Randomize.js', 'to' => 'Randomizer.php'], ['folder' => null])
        );

        $this->assertEquals(
            [
                'is_folder' => false,
                'from' => ['name' => 'Randomize', 'ext' => 'js', 'arg' => 'Randomize.js'],
                'to' => ['name' => 'Randomizer', 'ext' => 'js', 'arg' => 'Randomizer.js'],
            ],
            $this->service(['from' => 'Randomize.js', 'to' => 'Randomizer'], ['folder' => null])
        );
    }
}
