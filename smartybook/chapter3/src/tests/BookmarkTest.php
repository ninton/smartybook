<?php

declare(strict_types=1);

namespace SmartyBook\chapter3\src\tests;

use SmartyBook\chapter3\src\Bookmark;

it('コンストラクタプロモーションで各プロパティが初期化される', function (): void {
    $bookmark = new Bookmark(
        title: 'Google',
        url: 'https://www.google.com/',
    );

    expect($bookmark->title)->toBe('Google')
        ->and($bookmark->url)->toBe('https://www.google.com/');
});

it('returns expected domain or empty string for a given URL', function (string $url, string $expectedDomain): void {
    $bookmark = new Bookmark(
        title: 'サンプルサイト',
        url: $url,
    );

    expect($bookmark->getDomain())->toBe($expectedDomain);
})->with([
    '通常のHTTPS URL' => ['https://example.com/articles/1', 'example.com'],
    'サブドメインあり' => ['https://www.example.co.jp/', 'www.example.co.jp'],
    'クエリとフラグメント付き' => ['https://example.com/search?q=php#top', 'example.com'],
    'ポート番号付き' => ['http://localhost:8080/index.php', 'localhost'],
    'スキームなし文字列は空文字' => ['example.com/path', ''],
    '空文字URLは空文字' => ['', ''],
]);
