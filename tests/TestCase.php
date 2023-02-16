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

        $this->copyTestFiles();
    }

    public function tearDown(): void
    {
        parent::tearDown();
    }

    protected function setupApp(): void
    {
        (new SetupTest)();
    }

    protected function copyTestFiles()
    {
        File::copyDirectory(
            __DIR__ . '/TestFiles/app',
            base_path('app/Renamings')
        );

        File::copyDirectory(
            __DIR__ . '/TestFiles/src',
            base_path('packages/testings/testing/src')
        );
    }
}
