<?php

declare(strict_types=1);

namespace Tests\GoldenMaster;

trait HtmlStringAssertionTrait
{
    public static function assertHtmlStringEqualsHtmlString(string $expected, string $actual, string $message = ''): void
    {
        $normalize = static function (string $html): string {
            if ($html === '') {
                return '';
            }

            $dom = new \DOMDocument();

            // 1. 読み込み前に設定を済ませる
            $dom->preserveWhiteSpace = false;
            $dom->formatOutput = true;

            // グローバル設定を汚さないよう、直前状態を退避して復元する。
            $previousUseInternalErrors = libxml_use_internal_errors(true);

            try {
                // 2. この時点で、余計な空白を無視してDOMが構築される
                $dom->loadHTML($html, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
            } finally {
                libxml_clear_errors();
                libxml_use_internal_errors($previousUseInternalErrors);
            }

            return trim($dom->saveHTML() ?: '');
        };

        static::assertEquals($normalize($expected), $normalize($actual), $message);
    }
}
