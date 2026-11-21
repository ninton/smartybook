<?php

declare(strict_types=1);

namespace SmartyBook\chapter3\src;

use DateTimeImmutable;
use DateTimeZone;
use InvalidArgumentException;

final class DaysCounter
{
    /**
     * 指定した日付と基準日時（デフォルトは現在日時）の日数差を日付単位（00:00:00基準）で返します。
     * 過去の日付の場合は正の数、未来の日付の場合は負の数を返します。
     *
     * @throws InvalidArgumentException 日付の形式が不正な場合
     */
    public static function diffFrom(
        string $date,
        string $timezone = 'Asia/Tokyo',
        ?DateTimeImmutable $baseDateTime = null,
    ): int {
        $tz = new DateTimeZone($timezone);

        $parsedDate = DateTimeImmutable::createFromFormat('!Y/m/d', $date, $tz);
        $errors = DateTimeImmutable::getLastErrors();

        if ($parsedDate === false || ($errors !== false && ($errors['warning_count'] > 0 || $errors['error_count'] > 0))) {
            throw new InvalidArgumentException("日付の形式が不正です（Y/m/d形式で指定してください）: {$date}");
        }

        $targetDate = $parsedDate->setTime(0, 0, 0);
        $referenceDateTime = ($baseDateTime ?? new DateTimeImmutable('now', $tz))
            ->setTimezone($tz)
            ->setTime(0, 0, 0);

        $diff = $targetDate->diff($referenceDateTime);

        return (int) $diff->format('%r%a');
    }
}
