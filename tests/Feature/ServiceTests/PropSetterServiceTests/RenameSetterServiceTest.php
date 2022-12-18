<?php

namespace Bakgul\Renamer\Tests\Feature\ServiceTests\PropSetterServiceTests;

use Bakgul\Renamer\Services\PropSetterServices\RenameSetterService;
use Bakgul\Renamer\Tests\TestCase;

class RenameSetterServiceTest extends TestCase
{
    private function service($props)
    {
        return (new RenameSetterService($props))();
    }

    /** @test */
    public function renameable_paths_will_be_generated_as_expected()
    {
        $base = ['', 'var', 'www', 'html', '_test_repo', 'app', 'Renamings'];

        $this->assertEquals(
            [
                [
                    'from' => implode(DIRECTORY_SEPARATOR, [...$base, 'Originals', 'Subfolder', 'Originals']),
                    'to' => implode(DIRECTORY_SEPARATOR, [...$base, 'Originals', 'Subfolder', 'NewOriginals']),
                ],
                [
                    'from' => implode(DIRECTORY_SEPARATOR, [...$base, 'Traits', 'Originals']),
                    'to' => implode(DIRECTORY_SEPARATOR, [...$base, 'Traits', 'NewOriginals']),
                ],
                [
                    'from' => implode(DIRECTORY_SEPARATOR, [...$base, 'Originals']),
                    'to' => implode(DIRECTORY_SEPARATOR, [...$base, 'NewOriginals']),
                ],
            ],
            $this->service([
                'from' => ['name' => 'Originals', 'ext' => '', 'arg' => 'Originals'],
                'to' => ['name' => 'NewOriginals', 'ext' => '', 'arg' => 'NewOriginals']
            ])
        );

        $this->assertEquals(
            [
                [
                    'from' => implode(DIRECTORY_SEPARATOR, [...$base, 'MoreOriginals', 'Randomize.php']),
                    'to' => implode(DIRECTORY_SEPARATOR, [...$base, 'MoreOriginals', 'Randomizer.php']),
                ],
                [
                    'from' => implode(DIRECTORY_SEPARATOR, [...$base, 'Traits', 'Randomize.php']),
                    'to' => implode(DIRECTORY_SEPARATOR, [...$base, 'Traits', 'Randomizer.php']),
                ],
            ],
            $this->service([
                'from' => ['name' => 'Randomize', 'ext' => 'php', 'arg' => 'Randomize.php'],
                'to' => ['name' => 'Randomizer', 'ext' => 'php', 'arg' => 'Randomizer.php']
            ]),
        );

        $this->assertEquals(
            [
                [
                    'from' => implode(DIRECTORY_SEPARATOR, [...$base, 'Originals', 'Subfolder', 'MostOriginals', 'RandomE.php']),
                    'to' => implode(DIRECTORY_SEPARATOR, [...$base, 'Originals', 'Subfolder', 'MostOriginals', 'NewRandomE.php']),
                ]
            ],
            $this->service([
                'from' => ['name' => 'RandomE', 'ext' => 'php', 'arg' => 'RandomE.php'],
                'to' => ['name' => 'NewRandomE', 'ext' => 'php', 'arg' => 'NewRandomE.php']
            ]),
        );
    }
}
