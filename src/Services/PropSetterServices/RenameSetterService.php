<?php

namespace Bakgul\Renamer\Services\PropSetterServices;

use Bakgul\LaravelHelpers\Helpers\Arr;
use Bakgul\LaravelHelpers\Helpers\Folder;
use Bakgul\LaravelHelpers\Helpers\Str;
use Bakgul\Renamer\Contracts\PropSetter;

class RenameSetterService implements PropSetter
{
    public function __construct(private array $props)
    {
    }

    public function __invoke(): array
    {
        return ['renamings' => $this->set()];
    }

    private function set(): array
    {
        $from = $this->from();

        $this->getConfirmation($from);

        $to = $this->to($from);

        return $this->combine($from, $to);
    }

    private function getConfirmation(array $from)
    {
        if ($this->isProceedable($from)) return;

        $this->props['command']['instance']->info($this->message($from, 'info'));

        $response = $this->props['command']['instance']->confirm($this->message($from, 'question'));

        if ($response == false) throw new \Exception('Command has been terminated.');
    }

    private function isProceedable(array $from)
    {
        return count($from) < 2
            || $this->props['basics']['is_folder']
            || !config('renamer.warnings.renames_multiple_files');
    }

    private function from()
    {
        return $this->setRenamings($this->getRenamings());
    }

    private function getRenamings()
    {
        return array_reduce(
            $this->props['basics']['folders'],
            fn ($p, $c) => [...$p, ...$this->findRenamings($c)],
            []
        );
    }

    private function setRenamings($renamings)
    {
        return Arr::order(
            $this->modifyRenamings($renamings),
            callback: $this->sort()
        );
    }

    private function modifyRenamings($renamings)
    {
        $arg = DIRECTORY_SEPARATOR . $this->props['basics']['from']['arg'];

        return Arr::order(Arr::unique(array_map(
            fn ($x) => implode($arg, Arr::delete(explode($arg, $x))) . $arg,
            $renamings
        )));
    }

    private function findRenamings($folder)
    {
        return Folder::files(base_path($folder), $this->findPaths());
    }

    private function findPaths()
    {
        return fn ($x) => $this->isPathMatched($x, DIRECTORY_SEPARATOR);
    }

    private function isPathMatched($path, $glue)
    {
        return str_contains($path, "{$glue}{$this->props['basics']['from']['arg']}{$glue}")
            || str_contains($path, "{$glue}{$this->props['basics']['from']['arg']}");
    }

    private function sort()
    {
        return fn ($a, $b) => $this->count($b) <=> $this->count($a);
    }

    private function count($str)
    {
        return count(explode(DIRECTORY_SEPARATOR, $str));
    }

    private function message($from, $type)
    {
        return [
            'info' => implode("\n ", [
                count($from) . ' files in the same name have been found, and all will be renamed.',
                ...array_map(fn ($x) => '<fg=red;options=bold>' . str_replace(base_path(), '......', $x) . '</>', $from),
            ]),
            'question' => 'Do you want to proceed?'
        ][$type];
    }

    private function to(array $paths): array
    {
        return array_map(fn ($x) => $this->rename($x), $paths);
    }

    private function rename(string $path): string
    {
        return Str::dropTail($path) . DIRECTORY_SEPARATOR . $this->props['basics']['to']['arg'];
    }

    private function combine(array $from, array $to): array
    {
        $paths = [];

        foreach ($from as $i => $path) {
            $paths[] = ['from' => $path, 'to' => $to[$i]];
        }

        return $paths;
    }
}
