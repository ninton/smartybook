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
    $directory = dirname(__DIR__, 2) . '/_write/mylist/';
    $repository = new MyListRepository(25, $directory);

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
    $actual = $repository->read();

    // Assert
    expect($actual)->toEqual($expected);
});

// FIXME: リポジトリで切り詰めをするよりも、max_items によって取得件数が制限されることを確認するテスト
test('read max_items で2件に切り詰めます', function () {
    /**
     * @note _write/mylist/1.txt はコミット済みのファイルで、25件のアイテムが必ず存在します
     */
    $directory = dirname(__DIR__, 2) . '/_write/mylist/';
    $repository = new MyListRepository(2, $directory);

    $expected = new MyList(
        '大先生のおすすめ',
        'Smartyの達人',
        [
            ['ASIN' => '4774127833', 'comment' => '★★★　大先生に原稿のチェックをしてもらっている。'],
            ['ASIN' => '4774127205', 'comment' => '★★★　ラッテやお菓子を用意して、大先生のご機嫌をとるのだ。'],
        ],
    );

    // Action
    $actual = $repository->read();

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
        $repository = new MyListRepository(25, $directory);

        // Action
        $actual = $repository->read();

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
        $repository = new MyListRepository(25, $directory);

        // Action
        $repository->write($myList);

        // Assert
        $actual = $repository->read();
        expect($actual)->toEqual($myList);
    } finally {
        if (file_exists($filePath)) {
            unlink($filePath);
        }
        rmdir($temporaryDirectory);
    }
});
