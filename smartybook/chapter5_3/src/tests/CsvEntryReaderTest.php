<?php

declare(strict_types=1);

use SmartyBook\chapter5_3\src\CsvEntryReader;

test('fetchByCategory 指定カテゴリのレコードだけを返す', function (string $category, array $expected) {
    $path = dirname(__DIR__, 3) . '/chapter4_1/data.csv';

    $actual = CsvEntryReader::fetchByCategory($path, $category);

    expect($actual)->toBe($expected);
})->with([
    'Study' => ['Study', [
        [
            'id' => '0001',
            'category' => 'Study',
            'title' => '勉強初日',
            'text' => '先日買ってきたSmarty入門の本を開いて勉強し始めました。これから頑張るぞ。',
            'time' => '1199463806',
            'image' => './images/001.jpg',
        ],
        [
            'id' => '0002',
            'category' => 'Study',
            'title' => '勉強二日目',
            'text' => 'Smartyを勉強してます。ただいま一服中。',
            'time' => '1199465130',
            'image' => './images/004.jpg',
        ],
    ]],
    'Work' => ['Work', [
        [
            'id' => '0004',
            'category' => 'Work',
            'title' => '打ち合わせ',
            'text' => '同僚と案件の打ち合わせを行いました。予想外に複雑な仕様になりそうです。',
            'time' => '1200378462',
            'image' => './images/003.jpg',
        ],
        [
            'id' => '0005',
            'category' => 'Work',
            'title' => '今日の予定',
            'text' => "手帳を開くと今日も予定が沢山入っていて、忙しい日になりそう。\nきちんとスケジュール管理をせねば。",
            'time' => '1200378621',
            'image' => './images/005.jpg',
        ],
    ]],
    'Eating' => ['Eating', [
        [
            'id' => '0003',
            'category' => 'Eating',
            'title' => '今日の昼食',
            'text' => '東京タワーの見える公園でランチをとりました。青空の下のごはんはおいしい。',
            'time' => '1199469257',
            'image' => './images/002.jpg',
        ],
        [
            'id' => '0006',
            'category' => 'Eating',
            'title' => '今日の朝食',
            'text' => '今日の朝食はトーストとクロワッサンです。おいしそう。',
            'time' => '1200378693',
            'image' => './images/006.jpg',
        ],
        [
            'id' => '0007',
            'category' => 'Eating',
            'title' => '今日の昼食',
            'text' => '東京タワーの見える公園でランチをとりました。青空の下のごはんはおいしい。',
            'time' => '1203321453',
            'image' => './images/002.jpg',
        ],
    ]],
    'Unkown' => ['Unkown', []],
]);
