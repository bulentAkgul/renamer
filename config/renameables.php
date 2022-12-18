<?php

return [
    'warnings' => [
        'is_not_a_test' => true,
        'renames_multiple_files' => false,
    ],
    'folders' => [
        'testing' => ['app', 'tests'],
        'default' => ['_test_repo']
    ],
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
