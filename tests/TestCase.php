<?php

namespace Bakgul\Renamer\Tests;

use Bakgul\Kernel\Helpers\Str;
use Bakgul\Kernel\Tests\TestCase as BaseTestCase;
use Illuminate\Support\Facades\File;

abstract class TestCase extends BaseTestCase
{
    public function setUp(): void
    {
        parent::setUp();

        $this->copyDummyFiles();
    }

    public function tearDown(): void
    {
        parent::tearDown();
    }

    protected function copyDummyFiles()
    {
        File::copyDirectory(
            __DIR__ . '/../files/Renamings',
            base_path('app/Renamings')
        );
    }
}
