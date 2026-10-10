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

            $xpath = new \DOMXPath($dom);

            // 1. レイアウト用空白の除去対象とする主要なブロックレベル要素・構造要素
            $blockElements = [
                'article', 'aside', 'blockquote', 'body', 'dd', 'div', 'dl', 'dt',
                'fieldset', 'figcaption', 'figure', 'footer', 'form', 'h1', 'h2',
                'h3', 'h4', 'h5', 'h6', 'header', 'hr', 'html', 'li', 'main',
                'nav', 'ol', 'option', 'p', 'section', 'select', 'table', 'tbody',
                'td', 'tfoot', 'th', 'thead', 'tr', 'ul',
            ];

            // 2. ブロック要素直下の「改行・空白のみのテキストノード」のみを特定して削除
            $conditions = array_map(
                static fn (string $tag) => sprintf('name()="%s"', $tag),
                $blockElements,
            );
            $xpathQuery = sprintf('//text()[trim(.) = "" and parent::*[%s]]', implode(' or ', $conditions));

            foreach ($xpath->query($xpathQuery) as $node) {
                $node->parentNode->removeChild($node);
            }

            return trim($dom->saveHTML() ?: '');
        };

        static::assertEquals($normalize($expected), $normalize($actual), $message);
    }
}
