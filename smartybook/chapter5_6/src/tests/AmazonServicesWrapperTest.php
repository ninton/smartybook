<?php

declare(strict_types=1);

use App\PearStub\ServicesAmazonStub;
use SmartyBook\chapter5_6\src\AmazonServicesWrapper;

test('ASINsに空文字列を渡すとitemArrは空配列になる', function () {
    $amazon = new AmazonServicesWrapper(new ServicesAmazonStub('access-key', 'secret-key'));
    $itemArr = [['ASIN' => 'existing']];

    $amazon->ItemLookup('', [], $itemArr);

    expect($itemArr)->toBe([]);
});

test('ASINsを1件渡すとitemArrに該当する商品が1件入る', function () {
    $amazon = new AmazonServicesWrapper(new ServicesAmazonStub('access-key', 'secret-key'));
    $itemArr = [];

    $amazon->ItemLookup('1234567890', [], $itemArr);

    expect($itemArr)->toBe([
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
    ]);
});
test('ASINsを11件渡すとitemArrに該当する商品が11件入る', function () {
    $amazon = new AmazonServicesWrapper(new ServicesAmazonStub('access-key', 'secret-key'));
    $itemArr = [];
    $ASINs = '1234567890,1234567891,1234567892,1234567893,1234567894,1234567895,1234567896,1234567897,1234567898,1234567899,1234567800';

    $amazon->ItemLookup($ASINs, [], $itemArr);

    expect($itemArr)->toHaveCount(11);

    expect($itemArr[9])->toBe([
        'ASIN' => '1234567899',
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
    ]);

    expect($itemArr[10])->toBe([
        'ASIN' => '1234567800',
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
    ]);
});
