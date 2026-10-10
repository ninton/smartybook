<?php

declare(strict_types=1);

use SmartyBook\chapter5_6\src\MyList;
use SmartyBook\chapter5_6\src\MyListRepository;

/**
 * ファイルが存在しない場合のテストはスキップします
 */

test('read 保存済みファイル', function () {
    // Arrange
    /**
     * @note _write/mylist/1.txt はコミット済みのファイルで、25件のアイテムが必ず存在します
     */
    $path = dirname(__DIR__, 2) . '/_write/mylist/1.txt';
    $repository = new MyListRepository(25);

    $expected = new MyList(
        '大先生のおすすめ',
        'Smartyの達人',
        [
            ['ASIN' => '4774127833', 'comment' => '★★★　大先生に原稿のチェックをしてもらっている。'],
            ['ASIN' => '4774127205', 'comment' => '★★★　ラッテやお菓子を用意して、大先生のご機嫌をとるのだ。'],
            ['ASIN' => '4774122653', 'comment' => '★★★　何回も原稿を読んでいるので、もしかしたらSmartyの達人になっているかも？'],
            ['ASIN' => '', 'comment' => ''],
            ['ASIN' => '', 'comment' => ''],
            ['ASIN' => '', 'comment' => ''],
            ['ASIN' => '', 'comment' => ''],
            ['ASIN' => '', 'comment' => ''],
            ['ASIN' => '', 'comment' => ''],
            ['ASIN' => '', 'comment' => ''],
            ['ASIN' => '', 'comment' => ''],
            ['ASIN' => '', 'comment' => ''],
            ['ASIN' => '', 'comment' => ''],
            ['ASIN' => '', 'comment' => ''],
            ['ASIN' => '', 'comment' => ''],
            ['ASIN' => '', 'comment' => ''],
            ['ASIN' => '', 'comment' => ''],
            ['ASIN' => '', 'comment' => ''],
            ['ASIN' => '', 'comment' => ''],
            ['ASIN' => '', 'comment' => ''],
            ['ASIN' => '', 'comment' => ''],
            ['ASIN' => '', 'comment' => ''],
            ['ASIN' => '', 'comment' => ''],
            ['ASIN' => '', 'comment' => ''],
            ['ASIN' => '', 'comment' => ''],
        ],
    );

    // Action
    $actual = $repository->read($path);

    // Assert
    expect($actual)->toEqual($expected);
});

// FIXME: リポジトリで切り詰めをするよりも、入力層でバリデーションとエラー表示、VO生成時にも件数チェックしたい
test('read max_items で2件に切り詰めます', function () {
    /**
     * @note _write/mylist/1.txt はコミット済みのファイルで、25件のアイテムが必ず存在します
     */
    $path = dirname(__DIR__, 2) . '/_write/mylist/1.txt';
    $repository = new MyListRepository(2);

    $expected = new MyList(
        '大先生のおすすめ',
        'Smartyの達人',
        [
            ['ASIN' => '4774127833', 'comment' => '★★★　大先生に原稿のチェックをしてもらっている。'],
            ['ASIN' => '4774127205', 'comment' => '★★★　ラッテやお菓子を用意して、大先生のご機嫌をとるのだ。'],
        ],
    );

    // Action
    $actual = $repository->read($path);

    // Assert
    expect($actual)->toEqual($expected);
});

test('read 空ファイル → デフォルトの MyList', function () {
    // Arrange
    $temporaryDirectory = sys_get_temp_dir() . '/my-list-repository-' . bin2hex(random_bytes(8));
    mkdir($temporaryDirectory);
    $directory = $temporaryDirectory . DIRECTORY_SEPARATOR;
    $filePath = $directory . '1.txt';
    touch($filePath);

    try {
        $repository = new MyListRepository(25);

        // Action
        $actual = $repository->read($filePath);

        // Assert
        expect($actual)->toEqual(new MyList());
    } finally {
        if (file_exists($filePath)) {
            unlink($filePath);
        }
        rmdir($temporaryDirectory);
    }
});

test('write した内容と read した内容が一致する', function () {
    // Arrange
    $temporaryDirectory = sys_get_temp_dir() . '/my-list-repository-' . bin2hex(random_bytes(8));
    mkdir($temporaryDirectory);
    $directory = $temporaryDirectory . DIRECTORY_SEPARATOR;
    $filePath = $directory . '1.txt';
    $myList = new MyList('favorites', 'reader', [
        ['ASIN' => 'A1', 'comment' => 'first item'],
    ]);

    try {
        $repository = new MyListRepository(25);

        // Action
        $repository->write($filePath, $myList);

        // Assert
        $actual = $repository->read($filePath);
        expect($actual)->toEqual($myList);
    } finally {
        if (file_exists($filePath)) {
            unlink($filePath);
        }
        rmdir($temporaryDirectory);
    }
});
