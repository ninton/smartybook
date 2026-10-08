<?php

declare(strict_types=1);

use App\PearStub\ServicesAmazonStub;

test('空文字列を渡すとItemは空配列になる', function () {
    $amazon = new ServicesAmazonStub('access-key', 'secret-key');
    $result = $amazon->ItemLookup('');

    expect($result['Item'])->toBe([]);
});

test('ASINを渡すと該当する商品が1件返る', function () {
    $amazon = new ServicesAmazonStub('access-key', 'secret-key');
    $result = $amazon->ItemLookup('1234567890');

    expect($result['Item'])->toBe([
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

test('ASINを2件渡すと該当する商品が2件返る', function () {
    $amazon = new ServicesAmazonStub('access-key', 'secret-key');
    $result = $amazon->ItemLookup('1234567890,2345678901');

    expect($result['Item'])->toBe([
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
            'ASIN' => '2345678901',
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
