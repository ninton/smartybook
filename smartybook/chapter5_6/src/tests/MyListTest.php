<?php

declare(strict_types=1);

/**
 * MyList テスト値の計画
 *
 * | 項目 | テスト値 | 分類 |
 * | --- | --- | --- |
 * | ListName | 「あ」200文字 | 正常値（上限） |
 * | ListName | 空文字列、「あ」201文字 | 仕様外（空文字列、上限超過） |
 * | NickName | 「あ」200文字 | 正常値（上限） |
 * | NickName | 空文字列、「あ」201文字 | 仕様外（空文字列、上限超過） |
 * | ASIN | 数字1桁、10桁、13桁 | 正常値（入力途中の値を含む） |
 * | ASIN | 空文字列、数字14桁、数字以外を含む値 | 仕様外 |
 * | comment | 空文字列、「あ」200文字 | 正常値（空文字列可、200文字まで） |
 * | comment | 「あ」201文字 | 仕様外（上限超過） |
 * | detail_arr | 空配列、1件、25件 | 正常値（空配列可、25件まで） |
 * | detail_arr | 26件 | 仕様外（上限超過） |
 *
 * 仕様外の値も、現状はバリデーションがないため受け入れて保持することを確認する。
 */
use SmartyBook\chapter5_6\src\MyList;

// デフォルト値のテスト、デフォルト値として空文字列を許容するかについて検討すること
test('引数省略時は空の初期値を使用する', function () {
    $myList = new MyList();
    expect($myList->ListName)->toBe('')
        ->and($myList->NickName)->toBe('')
        ->and($myList->detail_arr)->toBe([]);
});

test('ListNameの正常値を保持する', function (string $listName) {
    $myList = new MyList(ListName: $listName);

    expect($myList->ListName)->toBe($listName);
})->with([
    '200文字（上限）' => [str_repeat('あ', 200)],
]);

// 現状の挙動確認:現状はバリデーションがないため通過してしまうことを記録（本来は仕様外）
test('ListNameの仕様外の値も保持する', function (string $listName) {
    $myList = new MyList(ListName: $listName);

    expect($myList->ListName)->toBe($listName);
})->with([
    '空文字列' => [''],
    '201文字（上限超過）' => [str_repeat('あ', 201)],
]);

test('NickNameの正常値を保持する', function (string $nickName) {
    $myList = new MyList(NickName: $nickName);

    expect($myList->NickName)->toBe($nickName);
})->with([
    '200文字（上限）' => [str_repeat('あ', 200)],
]);

// 現状の挙動確認:現状はバリデーションがないため通過してしまうことを記録（本来は仕様外）
test('NickNameの仕様外の値も保持する', function (string $nickName) {
    $myList = new MyList(NickName: $nickName);

    expect($myList->NickName)->toBe($nickName);
})->with([
    '空文字列' => [''],
    '201文字（上限超過）' => [str_repeat('あ', 201)],
]);

test('ASINの正常値を保持する', function (string $asin) {
    $details = [['ASIN' => $asin, 'comment' => '']];
    $myList = new MyList(detail_arr: $details);

    expect($myList->detail_arr)->toBe($details);
})->with([
    '数字1桁' => ['1'],
    '数字10桁' => ['1234567890'],
    '数字13桁' => ['1234567890123'],
]);

// 現状の挙動確認:現状はバリデーションがないため通過してしまうことを記録（本来は仕様外）
test('ASINの仕様外の値も保持する', function (string $asin) {
    $details = [['ASIN' => $asin, 'comment' => '']];
    $myList = new MyList(detail_arr: $details);

    expect($myList->detail_arr)->toBe($details);
})->with([
    '空文字列' => [''],
    '数字14桁（上限超過）' => ['12345678901234'],
    '数字以外を含む値' => ['A1'],
    '空白' => [' '],
    '前後空白' => [' 1 '],
]);

test('commentの正常値を保持する', function (string $comment) {
    $details = [['ASIN' => '1', 'comment' => $comment]];
    $myList = new MyList(detail_arr: $details);

    expect($myList->detail_arr)->toBe($details);
})->with([
    '空文字列' => [''],
    '200文字（上限）' => [str_repeat('あ', 200)],
]);

// 現状の挙動確認:現状はバリデーションがないため通過してしまうことを記録（本来は仕様外）
test('commentの仕様外の値も保持する', function (string $comment) {
    $details = [['ASIN' => '1', 'comment' => $comment]];
    $myList = new MyList(detail_arr: $details);

    expect($myList->detail_arr)->toBe($details);
})->with([
    '201文字（上限超過）' => [str_repeat('あ', 201)],
]);

test('detail_arrの正常値を保持する', function (array $details) {
    $myList = new MyList(detail_arr: $details);

    expect($myList->detail_arr)->toBe($details);
})->with([
    '空配列' => [[]],
    '1件' => [[['ASIN' => '1234567890', 'comment' => '']]],
    '25件（上限）' => [array_fill(0, 25, ['ASIN' => '1234567890', 'comment' => ''])],
]);

// 現状の挙動確認:現状はバリデーションがないため通過してしまうことを記録（本来は仕様外）
test('detail_arrの仕様外の値も保持する', function (array $details) {
    $myList = new MyList(detail_arr: $details);

    expect($myList->detail_arr)->toBe($details);
})->with([
    '26件（上限超過）' => [array_fill(0, 26, ['ASIN' => '1234567890', 'comment' => ''])],
]);

test('getASINs ASIN 正常値', function (array $details, string $expected) {
    $myList = new MyList(detail_arr: $details);

    expect($myList->getASINs())->toBe($expected);
})->with([
    '空配列' => [[], ''],
    '10桁が1件' => [[['ASIN' => '1234567890', 'comment' => 'first']], '1234567890'],
    '13桁が1件' => [[['ASIN' => '1234567890123', 'comment' => 'first']], '1234567890123'],
    '3件のうち2件が重複' => [[
        ['ASIN' => '1234567890', 'comment' => 'first'],
        ['ASIN' => '0987654321', 'comment' => 'second'],
        ['ASIN' => '1234567890', 'comment' => 'duplicate'],
    ], '1234567890,0987654321'],
]);

test('getASINs ASINが仕様外の値', function (array $details, string $expected) {
    $myList = new MyList(detail_arr: $details);

    expect($myList->getASINs())->toBe($expected);
})->with([
    '空文字列、0 をスキップする' => [[
        ['ASIN' => '', 'comment' => '空文字列'],
        ['ASIN' => '0', 'comment' => '数字の0'],
        ['ASIN' => '1', 'comment' => '数字1桁'],
    ], '1'],
    '前後空白と大文字小文字は正規化されない' => [[
        ['ASIN' => ' A ', 'comment' => '前後空白'],
        ['ASIN' => 'A1', 'comment' => '大文字を含む'],
        ['ASIN' => 'a1', 'comment' => '小文字を含む'],
    ], ' A ,A1,a1'],
]);
