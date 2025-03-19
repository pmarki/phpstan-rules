<?php

$array = [
    'key1' => 'value1',
    'key2' => 'value2',
    'key1' => 'duplicate',
];

$array = [
    1 => 'value1',
    2 => 'value2',
    2 => 'value3',
];

$array = [
    'key1' => 'value1',
    'key2' => 'value2',
    'key3' => [
        'key1' => 'value1',
        'key2' => 'value2',
    ]
];

$array = [
    'key1' => 'value1',
    'key2' => 'value2',
    'key3' => [
        'nested-key1' => 'value1',
        'nested-key2' => 'value2',
        'nested-key2' => 'duplicated',
    ]
];

$array = [
    'value1',
    'value2',
    'value1',
];
