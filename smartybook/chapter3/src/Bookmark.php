<?php

declare(strict_types=1);

namespace SmartyBook\chapter3\src;

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
     * URL からホスト名（ドメイン）を取り出します。
     */
    public function getDomain(): string
    {
        $host = parse_url($this->url, PHP_URL_HOST);

        if (!is_string($host) || $host === '') {
            return '';
        }

        return $host;
    }
}
