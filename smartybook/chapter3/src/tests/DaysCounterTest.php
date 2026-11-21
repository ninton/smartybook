<?php

declare(strict_types=1);

namespace SmartyBook\chapter3\src\tests;

use DateTimeImmutable;
use DateTimeZone;
use InvalidArgumentException;
use SmartyBook\chapter3\src\DaysCounter;

it('00:00:00基準で過去日付の経過日数を正の整数で返す', function (): void {
    $baseDateTime = new DateTimeImmutable('2026-11-21 23:59:59', new DateTimeZone('Asia/Tokyo'));

    expect(DaysCounter::diffFrom('2026/11/20', 'Asia/Tokyo', $baseDateTime))->toBe(1)
        ->and(DaysCounter::diffFrom('2026/11/01', 'Asia/Tokyo', $baseDateTime))->toBe(20);
});

it('同一暦日の場合は基準時刻に関わらず0を返す', function (): void {
    $baseDateTime = new DateTimeImmutable('2026-11-21 01:00:00', new DateTimeZone('Asia/Tokyo'));

    expect(DaysCounter::diffFrom('2026/11/21', 'Asia/Tokyo', $baseDateTime))->toBe(0);
});

it('未来日付の場合は負の整数を返す', function (): void {
    $baseDateTime = new DateTimeImmutable('2026-11-21 12:00:00', new DateTimeZone('Asia/Tokyo'));

    expect(DaysCounter::diffFrom('2026/11/26', 'Asia/Tokyo', $baseDateTime))->toBe(-5);
});

it('基準日時を指定タイムゾーンに変換してから日数を計算する', function (): void {
    // 2026-11-21 16:00:00 UTC は Asia/Tokyo では 2026-11-22 01:00:00
    $utcBase = new DateTimeImmutable('2026-11-21 16:00:00', new DateTimeZone('UTC'));

    expect(DaysCounter::diffFrom('2026/11/21', 'Asia/Tokyo', $utcBase))->toBe(1);
});

it('不正な日付フォーマットや存在しない日付の場合はInvalidArgumentExceptionをスローする', function (string $invalidDate): void {
    expect(fn () => DaysCounter::diffFrom($invalidDate))
        ->toThrow(InvalidArgumentException::class);
})->with([
    '2026-11-01',
    '2026/2/30',
    '2026/13/01',
    '2026/11/01 extra',
    'not-a-date',
    '26/11/01',
]);
