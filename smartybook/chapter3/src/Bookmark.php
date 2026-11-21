<?php

declare(strict_types=1);

namespace SmartyBook\chapter3\src;

use DateTimeImmutable;

final readonly class Bookmark
{
    /**
     * @param string $title サイト名
     * @param string $url サイトURL
     * @param string $date ブックマークした日付
     */
    public function __construct(
        public string $title,
        public string $url,
        public string $date,
    ) {
    }

    /**
     * 現在日時からどのくらい日数が経過しているかを取得します。
     *
     * @return int 経過日数
     * @noinspection PhpUnused Smartyテンプレートで参照しています。PhpStormでは未使用と判定されるため、抑制コメントを追加しています。
     */
    public function getDaysAgo(): int
    {
        $targetDate = new DateTimeImmutable($this->date);
        $now = new DateTimeImmutable('now', $targetDate->getTimezone());
        $diffSeconds = $now->getTimestamp() - $targetDate->getTimestamp();

        return (int)floor($diffSeconds / (60 * 60 * 24));
    }
}
