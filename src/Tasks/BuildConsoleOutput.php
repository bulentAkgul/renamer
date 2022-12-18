<?php

namespace Bakgul\Renamer\Tasks;

class BuildConsoleOutput
{
    public function __construct(private array $log, private string $key)
    {
    }

    private array $colors = [
        'update' => ['gray', 'magenta'],
        'rename' => ['gray', 'blue']
    ];

    public function handle()
    {
        return implode("\n", [
            '',
            ...$this->outputTitle('content'),
            ...$this->outputFile(),
            ...$this->outputCompare(),
            '',
        ]);
    }

    public function outputTitle(string $key, int $length = 19): array
    {
        return [
            "{$this->headStyle(true)}{$this->whiteSpace($length)}</>",
            "{$this->headStyle(true)}{$this->title($key)}</>",
            "{$this->headStyle(true)}{$this->whiteSpace($length)}</>",
        ];
    }

    public function outputFile()
    {
        return [
            "{$this->headStyle()}   file:   </> {$this->logPath('file')}",
            "{$this->headStyle()}   line:   </> {$this->log['line']}",
        ];
    }

    public function outputCompare()
    {
        return [
            "{$this->headStyle()}   from:   </> {$this->logPath('from')}",
            "{$this->headStyle()}   to:     </> {$this->logPath('to')}",
        ];
    }

    private function headStyle(bool $isTitle = false)
    {
        return "<fg=white;bg={$this->color($isTitle)};options=bold>";
    }

    private function color($isTitle = false): string
    {
        return $this->colors[$this->key][$isTitle];
    }

    private function title(string $key = ''): string
    {
        return match ($key) {
            'folder' => '  Folder renamed   ',
            'file' =>   '  File renamed     ',
            default =>  '  Content updated  ',
        };
    }

    private function whiteSpace(int $length): string
    {
        return str_repeat(' ', $length);
    }

    private function logPath(string $key): string
    {
        return str_replace(base_path(), '..', $this->log[$key]);
    }
}
