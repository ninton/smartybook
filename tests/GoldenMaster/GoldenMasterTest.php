<?php

declare(strict_types=1);

namespace Tests\GoldenMaster;

use PHPUnit\Framework\TestCase;

final class GoldenMasterTest extends TestCase
{
    use HtmlStringAssertionTrait;

    public function tearDown(): void
    {
        $_GET = [];
        $_POST = [];
        $_REQUEST = [];
        $_SESSION = [];
        unset(
            $_SERVER['REQUEST_METHOD'],
            $_SERVER['REQUEST_URI'],
        );

        putenv('PHPUNIT_RUNNING');

        parent::tearDown();
    }

    /**
     * @param array<string, mixed> $getVars
     * @param array<string, mixed> $postVars
     * @dataProvider dataProvider
     */
    public function test(string $url, string $method, array $getVars, array $postVars, string $storageName): void
    {
        // 準備
        $_GET = $getVars;
        $_POST = $postVars;
        $_SESSION = [];
        $_REQUEST = array_merge($_GET, $_POST);

        $_SERVER['REQUEST_METHOD'] = $method;
        $_SERVER['REQUEST_URI'] = '';

        putenv('PHPUNIT_RUNNING=1');

        // 実行
        $output = CrawlCode::crawl(
            $url,
            $method,
            http_build_query($postVars)
        );

        // 検証
        $masterPath = __DIR__ . "/fixtures/current/{$storageName}.html";
        $actualPath = __DIR__ . "/fixtures/actual/{$storageName}.html";

        file_put_contents($actualPath, $output);

        if (getenv('SHOULD_UPDATE_GOLDEN_MASTER') === '1') {
            file_put_contents($masterPath, $output);
        } else {
            GoldenMasterTest::assertFileExists($masterPath, "Golden Master が見つかりません: {$masterPath}");

            $expectedHtml = file_get_contents($masterPath);
            if ($expectedHtml === false) {
                GoldenMasterTest::fail("Golden Master の読み込みに失敗しました: {$masterPath}");
            }

            $actual = $this->sanitizeHtml($output);
            $expected = $this->sanitizeHtml($expectedHtml);

            static::assertHtmlStringEqualsHtmlString($expected, $actual, "URL: {$url} のレスポンスが変化しています");
        }
    }

    /**
     * @return array<string, array{string, string, array<string, mixed>, array<string, mixed>, string}>
     */
    public static function dataProvider(): array
    {
        $crawlCommandArr = CrawlCode::readCrawlCommandArrFromCsv(__DIR__ . '/url.csv');
        $len = count($crawlCommandArr);

        $data = [];

        foreach ($crawlCommandArr as $i => $cmd) {
            $getVars = [];
            $postVars = [];

            parse_str(parse_url($cmd->url, PHP_URL_QUERY) ?? '', $getVars);
            parse_str($cmd->data, $postVars);

            $title = sprintf("%d/%d %s", $i + 1, $len, $cmd->title);

            // 1. ファイル名に使えない文字を置換
            $safeUrl = preg_replace('/[^a-zA-Z0-9]/', '_', $cmd->url);
            // 2. IDを付与して「001_list_php_F001_num_1.html」のような名前に
            $storageName = sprintf('%03d_%s', $i + 1, $safeUrl);

            $data[$title] = [
                $cmd->url,
                $cmd->method,
                $getVars,
                $postVars,
                $storageName,
            ];
        }

        return $data;
    }

    private function sanitizeHtml(string $html): string
    {
            // 日付と時刻を置換
        $html = preg_replace(
            '/\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2}/',
            'YYYY-MM-DD HH:MM:SS',
            $html
        );

        // type="hidden" name="date" を含むinput要素のvalue属性のみ置換
        $html = preg_replace(
            '/<input[^>]*type="hidden"[^>]*name="date"[^>]*value="\d+"[^>]*>/',
            '<input type="hidden" name="date" value="TIMESTAMP">',
            $html
        );

        // 年月日時分秒のセレクトボックスの値を置換
        if (str_contains($html, 'startDate[Year]')) {
            $html = str_replace(' selected="selected"', '', $html);
            $html = preg_replace(
                '/<option value="(\d{4})">(\d{4})<\/option>/',
                '<option value="YYYY">YYYY</option>',
                $html
            );
        }

        return $html;
    }
}
