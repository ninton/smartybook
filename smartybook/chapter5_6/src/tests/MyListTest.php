<?php

declare(strict_types=1);

use SmartyBook\chapter5_6\src\MyList;

test('constructor uses empty defaults', function () {
    $myList = new MyList();

    expect($myList->ListName)->toBe('')
        ->and($myList->NickName)->toBe('')
        ->and($myList->detail_arr)->toBe([]);
});

test('constructor preserves provided values', function () {
    $details = [
        ['ASIN' => 'A1', 'comment' => 'first'],
        ['ASIN' => 'B2', 'comment' => 'second'],
    ];
    $myList = new MyList('favorites', 'reader', $details);

    expect($myList->ListName)->toBe('favorites')
        ->and($myList->NickName)->toBe('reader')
        ->and($myList->detail_arr)->toBe($details);
});

test('getASINs formats ASINs', function (array $details, string $expected) {
    $myList = new MyList(detail_arr: $details);

    expect($myList->getASINs())->toBe($expected);
})->with([
    'empty list' => [[], ''],
    'single ASIN' => [[['ASIN' => 'A1', 'comment' => 'first']], 'A1'],
    'duplicates preserve first-seen order' => [[
        ['ASIN' => 'A1', 'comment' => 'first'],
        ['ASIN' => 'B2', 'comment' => 'second'],
        ['ASIN' => 'A1', 'comment' => 'duplicate'],
    ], 'A1,B2'],
    'empty ASIN and string zero are omitted' => [[
        ['ASIN' => '', 'comment' => 'empty'],
        ['ASIN' => '0', 'comment' => 'zero'],
        ['ASIN' => 'A1', 'comment' => 'present'],
    ], 'A1'],
    'whitespace and letter case are not normalized' => [[
        ['ASIN' => ' a1 ', 'comment' => 'spaced'],
        ['ASIN' => 'A1', 'comment' => 'uppercase'],
        ['ASIN' => 'a1', 'comment' => 'lowercase'],
    ], ' a1 ,A1,a1'],
]);
