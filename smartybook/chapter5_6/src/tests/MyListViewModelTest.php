<?php

declare(strict_types=1);

use SmartyBook\chapter5_6\src\MyList;
use SmartyBook\chapter5_6\src\MyListViewModel;

test('明細とAmazon API応答が空配列の場合は空の明細を返す', function () {
    $myList = new MyList('my favorite', 'taro', []);
    $itemArr = [];

    $viewModel = MyListViewModel::create($myList, $itemArr);

    expect($viewModel->ListName)->toBe('my favorite');
    expect($viewModel->NickName)->toBe('taro');
    expect($viewModel->detail_arr)->toBe([]);
});

test('明細がありAmazon API応答が空配列の場合はItemをnullにする', function () {
    $myList = new MyList('my favorite', 'taro', [
        ['ASIN' => '1234567890', 'comment' => ''],
    ]);
    $itemArr = [];

    $viewModel = MyListViewModel::create($myList, $itemArr);

    expect($viewModel->detail_arr)->toBe([
        [
            'ASIN' => '1234567890',
            'comment' => '',
            'Item' => null,
        ],
    ]);
});

test('明細のASINに一致するAmazon APIの商品情報を結合する 1件', function () {
    $myList = new MyList('my favorite', 'taro', [
        ['ASIN' => '1234567890', 'comment' => ''],
    ]);
    $itemArr = [
        [
            'ASIN' => '1234567890',
            'SmallImage' => [
                'URL' => 'https://m.media-amazon.com/images/I/51tY5PtGsuL.jpg',
                'Height' => [
                    '_content' => 75,
                ],
                'Width' => [
                    '_content' => 53,
                ],
            ],
            'DetailPageURL' => 'https://www.amazon.co.jp/dp/4774136301',
            'ItemAttributes' => [
                'Title' => '速習Webテクニック Smarty動的Webサイト構築入門 (Quick Master of Web Technique)',
                'Author' => ['原 一浩', '青木 真', '鵜飼 孝陽', '川野辺 亮'],
                'Publisher' => '技術評論社',
                'PublicationDate' => '2008/9/20',
                'ListPrice' => [
                    'FormattedPrice' => '2694',
                ],
            ],
        ],
    ];

    $viewModel = MyListViewModel::create($myList, $itemArr);

    expect($viewModel->detail_arr)->toBe([
        [
            'ASIN' => '1234567890',
            'comment' => '',
            'Item' => [
                'ASIN' => '1234567890',
                'SmallImage' => [
                    'URL' => 'https://m.media-amazon.com/images/I/51tY5PtGsuL.jpg',
                    'Height' => [
                        '_content' => 75,
                    ],
                    'Width' => [
                        '_content' => 53,
                    ],
                ],
                'DetailPageURL' => 'https://www.amazon.co.jp/dp/4774136301',
                'ItemAttributes' => [
                    'Title' => '速習Webテクニック Smarty動的Webサイト構築入門 (Quick Master of Web Technique)',
                    'Author' => ['原 一浩', '青木 真', '鵜飼 孝陽', '川野辺 亮'],
                    'Publisher' => '技術評論社',
                    'PublicationDate' => '2008/9/20',
                    'ListPrice' => [
                        'FormattedPrice' => '2694',
                    ],
                ],
            ],
        ],
    ]);
});

test('明細のASINに一致するAmazon APIの商品情報を結合する 2件', function () {
    $myList = new MyList('my favorite', 'taro', [
        ['ASIN' => '1234567890', 'comment' => ''],
        ['ASIN' => '1234567891', 'comment' => ''],
    ]);
    $itemArr = [
        [
            'ASIN' => '1234567890',
            'SmallImage' => [
                'URL' => 'https://m.media-amazon.com/images/I/51tY5PtGsuL.jpg',
                'Height' => [
                    '_content' => 75,
                ],
                'Width' => [
                    '_content' => 53,
                ],
            ],
            'DetailPageURL' => 'https://www.amazon.co.jp/dp/4774136301',
            'ItemAttributes' => [
                'Title' => '速習Webテクニック Smarty動的Webサイト構築入門 (Quick Master of Web Technique)',
                'Author' => ['原 一浩', '青木 真', '鵜飼 孝陽', '川野辺 亮'],
                'Publisher' => '技術評論社',
                'PublicationDate' => '2008/9/20',
                'ListPrice' => [
                    'FormattedPrice' => '2694',
                ],
            ],
        ],
        [
            'ASIN' => '1234567891',
            'SmallImage' => [
                'URL' => 'https://m.media-amazon.com/images/I/51tY5PtGsuL.jpg',
                'Height' => [
                    '_content' => 75,
                ],
                'Width' => [
                    '_content' => 53,
                ],
            ],
            'DetailPageURL' => 'https://www.amazon.co.jp/dp/4774136301',
            'ItemAttributes' => [
                'Title' => '速習Webテクニック Smarty動的Webサイト構築入門 (Quick Master of Web Technique)',
                'Author' => ['原 一浩', '青木 真', '鵜飼 孝陽', '川野辺 亮'],
                'Publisher' => '技術評論社',
                'PublicationDate' => '2008/9/20',
                'ListPrice' => [
                    'FormattedPrice' => '2694',
                ],
            ],
        ],
    ];

    $viewModel = MyListViewModel::create($myList, $itemArr);

    expect($viewModel->detail_arr)->toBe([
        [
            'ASIN' => '1234567890',
            'comment' => '',
            'Item' => [
                'ASIN' => '1234567890',
                'SmallImage' => [
                    'URL' => 'https://m.media-amazon.com/images/I/51tY5PtGsuL.jpg',
                    'Height' => [
                        '_content' => 75,
                    ],
                    'Width' => [
                        '_content' => 53,
                    ],
                ],
                'DetailPageURL' => 'https://www.amazon.co.jp/dp/4774136301',
                'ItemAttributes' => [
                    'Title' => '速習Webテクニック Smarty動的Webサイト構築入門 (Quick Master of Web Technique)',
                    'Author' => ['原 一浩', '青木 真', '鵜飼 孝陽', '川野辺 亮'],
                    'Publisher' => '技術評論社',
                    'PublicationDate' => '2008/9/20',
                    'ListPrice' => [
                        'FormattedPrice' => '2694',
                    ],
                ],
            ],
        ],
        [
            'ASIN' => '1234567891',
            'comment' => '',
            'Item' => [
                'ASIN' => '1234567891',
                'SmallImage' => [
                    'URL' => 'https://m.media-amazon.com/images/I/51tY5PtGsuL.jpg',
                    'Height' => [
                        '_content' => 75,
                    ],
                    'Width' => [
                        '_content' => 53,
                    ],
                ],
                'DetailPageURL' => 'https://www.amazon.co.jp/dp/4774136301',
                'ItemAttributes' => [
                    'Title' => '速習Webテクニック Smarty動的Webサイト構築入門 (Quick Master of Web Technique)',
                    'Author' => ['原 一浩', '青木 真', '鵜飼 孝陽', '川野辺 亮'],
                    'Publisher' => '技術評論社',
                    'PublicationDate' => '2008/9/20',
                    'ListPrice' => [
                        'FormattedPrice' => '2694',
                    ],
                ],
            ],
        ],
    ]);
});
