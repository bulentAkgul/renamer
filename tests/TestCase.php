<?php

namespace Bakgul\Renamer\Tests;

use Bakgul\Kernel\Tests\TestCase as BaseTestCase;
use Bakgul\Kernel\Tests\TestTasks\SetupTest;
use Illuminate\Support\Facades\File;

abstract class TestCase extends BaseTestCase
{
    public function setUp(): void
    {
        parent::setUp();

        $this->setupApp();

        $this->copyDummyFiles();
    }

    public function tearDown(): void
    {
        parent::tearDown();
    }

    protected function setupApp(): void
    {
        (new SetupTest)();

        if (!file_exists(base_path('app'))) mkdir(base_path('app'));
    }

    protected function copyDummyFiles()
    {
        File::copyDirectory(
            __DIR__ . '/../files/Renamings',
            base_path('app/Renamings')
        );
    }
}
