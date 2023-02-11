<?php

namespace Bakgul\Renamer\Tests\PackageTests;

use Bakgul\Kernel\Helpers\Arr;
use Bakgul\Kernel\Helpers\Folder;
use Bakgul\Kernel\Helpers\Str;
use Bakgul\Renamer\Tests\TestCase;

class RenameTest extends TestCase
{

    private function oldItems(): array
    {
        return Arr::assocMap(
            $keys = Folder::files(base_path('app/Renamings')),
            fn ($k, $v) => file($v),
            $keys
        );
    }

    private function assertEmptynessI(callable $callback): void
    {
        $this->assertEmpty(Folder::files(base_path('app/Renamings'), $callback));
    }

    private function assertMissings($missing): void
    {
        foreach (Folder::files(base_path('app/Renamings')) as $file) {
            $this->assertTrue(Str::containsNone(
                file_get_contents($file),
                $missing
            ), $file);
        }
    }

    private function assertLines($oldItems, $from, $to, $missing, $options): void
    {
        foreach ($oldItems as $old => $content) {
            $new = str_replace($from, $to, $old);

            $this->assertFileExists($new);

            foreach ($content as $i => $line) {
                if (Str::containsSome($line, $missing)) {
                    $newContent = file($new);
                    $this->assertTrue(
                        Str::containsNone($newContent[$i], $missing)
                    );
                    $this->assertTrue(
                        Str::containsSome($newContent[$i], $options)
                    );
                }
            }
        }
    }
    /** @test */
    public function it_will_rename_folders_and_change_all_content_that_uses_old_name(): void
    {
        $oldItems = $this->oldItems();

        $from = 'Subfolder';
        $to = 'NewSubfolder';

        $this->artisan("rename {$from} {$to} -f");

        $this->assertEmptynessI(
            fn ($x) => str_contains($x, "/{$from}/")
        );

        $missing = ["\\{$from}\\", "\\{$from};"];

        $this->assertMissings($missing);
        $this->assertLines($oldItems, $from, $to, $missing, ["\\{$to}\\", "\\{$to};"]);
    }

    /** @test */
    public function it_will_rename_files_and_change_all_content_that_uses_old_name(): void
    {
        $oldItems = $this->oldItems();

        $from = 'RandomG';
        $to = 'RandomZ';

        $this->artisan("rename {$from} {$to}");

        $this->assertEmptynessI(
            fn ($x) => str_replace('.php', '', Str::getTail($x)) == $from
        );

        $this->assertMissings($from);
        $this->assertLines($oldItems, $from, $to, $from, $to);
    }
}
