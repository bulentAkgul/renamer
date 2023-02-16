<?php

return [
    'warnings' => [
        'is_not_a_test' => false,
        'renames_multiple_files' => false,
    ],
    'folders' => [
        'testing' => ['app', 'packages', 'tests'],
        'default' => ['app', 'database', 'package', 'packages', 'tests']
    ],
    'extensions' => ['php', 'css', 'sass', 'scss', 'ts', 'js'],
    'content_checkers' => [
        'class {x}',
        'enum {x}',
        'extends {x}',
        'implements {x}',
        'interface {x}',
        'trait {x}',
        'new {x}',
        'new \{x}',
        'use {x}',
        '{x}(',
        '{x})->',
        '{x}::',
        '{x} as '
    ],
    'namespace_checkers' => [
        '{x};',
        '{x},',
        '{x}(',
        '{x})',
        '{x};',
        '{x}::',
        '{x} as '
    ]
];
