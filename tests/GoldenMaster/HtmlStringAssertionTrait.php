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
            $dom->formatOutput = false;

            // グローバル設定を汚さないよう、直前状態を退避して復元する。
            $previousUseInternalErrors = libxml_use_internal_errors(true);

            try {
                // 2. この時点で、余計な空白を無視してDOMが構築される
                $dom->loadHTML($html, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
            } finally {
                libxml_clear_errors();
                libxml_use_internal_errors($previousUseInternalErrors);
            }

            $xpath = new \DOMXPath($dom);

            // すべてのテキストノードを取得
            foreach ($xpath->query('//text()') as $textNode) {
                // 改行・連続空白を1つのスペースに置換
                $cleaned = preg_replace('/\s+/', ' ', $textNode->nodeValue);

                // タグ間の改行など「空白のみのテキストノード」はノード自体を削除
                if (trim($cleaned) === '') {
                    $textNode->parentNode->removeChild($textNode);
                } else {
                    $textNode->nodeValue = $cleaned;
                }
            }

            return trim($dom->saveHTML() ?: '');
        };

        static::assertEquals($normalize($expected), $normalize($actual), $message);
    }
}
