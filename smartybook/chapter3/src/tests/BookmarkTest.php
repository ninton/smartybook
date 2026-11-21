<?php

declare(strict_types=1);

namespace SmartyBook\chapter3\src\tests;

use InvalidArgumentException;
use SmartyBook\chapter3\src\Bookmark;

it('コンストラクタプロモーションで各プロパティが初期化される', function (): void {
    $bookmark = new Bookmark(
        title: 'Google',
        url: 'https://www.google.com/',
        date: '2026/11/01',
    );

    expect($bookmark->title)->toBe('Google')
        ->and($bookmark->url)->toBe('https://www.google.com/')
        ->and($bookmark->date)->toBe('2026/11/01');
});

it('getDaysAgo() が経過日数を整数（int）で返す', function (): void {
    $bookmark = new Bookmark(
        title: 'Google',
        url: 'https://www.google.com/',
        date: '2026/11/01',
    );

    expect($bookmark->getDaysAgo())->toBeInt();
});

it('日付フォーマットが不正な場合は InvalidArgumentException をスローする', function (): void {
    $bookmark = new Bookmark(
        title: 'Invalid',
        url: 'https://example.com/',
        date: 'invalid-date',
    );

    expect(fn () => $bookmark->getDaysAgo())
        ->toThrow(InvalidArgumentException::class);
});
