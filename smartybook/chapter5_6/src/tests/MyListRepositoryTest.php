<?php

declare(strict_types=1);

use SmartyBook\chapter5_6\src\MyList;
use SmartyBook\chapter5_6\src\MyListRepository;

test('read restores the contents of the saved my list', function () {
    $directory = dirname(__DIR__, 2) . '/_write/mylist/';
    $fixturePath = $directory . '1.txt';
    $expected = unserialize((string) file_get_contents($fixturePath));
    $repository = new MyListRepository(25, $directory);

    expect($repository->read())->toEqual($expected);
});

test('write saves the serialized my list', function () {
    $temporaryDirectory = sys_get_temp_dir() . '/my-list-repository-' . bin2hex(random_bytes(8));
    mkdir($temporaryDirectory);
    $directory = $temporaryDirectory . DIRECTORY_SEPARATOR;
    $filePath = $directory . '1.txt';
    $myList = new MyList('favorites', 'reader', [
        ['ASIN' => 'A1', 'comment' => 'first item'],
    ]);

    try {
        $repository = new MyListRepository(25, $directory);
        $repository->write($myList);

        expect(file_get_contents($filePath))->toBe(serialize($myList));
    } finally {
        if (file_exists($filePath)) {
            unlink($filePath);
        }
        rmdir($temporaryDirectory);
    }
});
