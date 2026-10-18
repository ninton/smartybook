<?php

declare(strict_types=1);

namespace Tests\GoldenMaster;

use Exception;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

final class GoldenMasterTest extends TestCase
{
    use HtmlStringAssertionTrait;

    private static string $cookieFile = '';

    public static function setUpBeforeClass(): void
    {
        parent::setUpBeforeClass();

        if (getenv('SHOULD_UPDATE_GOLDEN_MASTER') === '1') {
            $fixtures = glob(__DIR__ . '/fixtures/current/*');
            if ($fixtures === false) {
                throw new \RuntimeException('Golden Master の一覧取得に失敗しました');
            }
            foreach ($fixtures as $fixture) {
                if (!unlink($fixture)) {
                    throw new \RuntimeException("Golden Master の削除に失敗しました: {$fixture}");
                }
            }
        }

        // sys_get_temp_dir() を使用し、一意なファイル名を動的に生成
        self::$cookieFile = sys_get_temp_dir() . '/curl_cookie_' . uniqid('', true) . '.txt';
    }

    public static function tearDownAfterClass(): void
    {
        // ファイルが存在する場合のみ安全に削除
        if (self::$cookieFile !== '' && file_exists(self::$cookieFile)) {
            @unlink(self::$cookieFile);
        }

        parent::tearDownAfterClass();
    }

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
     * @throws Exception
     */
    #[DataProvider('dataProvider')]
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
            http_build_query($postVars),
            self::$cookieFile,
        );

        // 検証
        $masterPath = __DIR__ . "/fixtures/current/{$storageName}.html";
        $actualPath = __DIR__ . "/fixtures/actual/{$storageName}.html";

        $actual = $this->sanitizeHtml($output);
        file_put_contents($actualPath, $actual);

        if (getenv('SHOULD_UPDATE_GOLDEN_MASTER') === '1') {
            file_put_contents($masterPath, $actual);
        }

        GoldenMasterTest::assertFileExists($masterPath, "Golden Master が見つかりません: {$masterPath}");

        $expected = file_get_contents($masterPath);
        if ($expected === false) {
            GoldenMasterTest::fail("Golden Master の読み込みに失敗しました: {$masterPath}");
        }

        self::assertHtmlStringEqualsHtmlString($expected, $actual, "URL: {$url} のレスポンスが変化しています");
    }

    /**
     * @return array<string, array{string, string, array<string, mixed>, array<string, mixed>, string}>
     * @throws Exception
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

            $title = sprintf('%d/%d %s', $i + 1, $len, $cmd->title);

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

    public function testSanitizeScriptVersions(): void
    {
        self::assertSame(
            '<script src="path/to/xxx.js?v=VERSION"></script>',
            $this->sanitizeHtml('<script src="path/to/xxx.js?v=1234abcd"></script>'),
        );
        self::assertSame(
            "<script defer src='path/to/xxx.js?v=VERSION&amp;lang=ja'></script>",
            $this->sanitizeHtml("<script defer src='path/to/xxx.js?v=5678efgh&amp;lang=ja'></script>"),
        );
        $html = '<script src="path/to/xxx.js"></script><a href="path/to/xxx.js?v=1234abcd">JS</a>';
        self::assertSame($html, $this->sanitizeHtml($html));
    }

    public function testSanitizeStylesheetVersions(): void
    {
        self::assertSame(
            '<link rel="stylesheet" type="text/css" href="./css/styles.css?v=VERSION" />',
            $this->sanitizeHtml('<link rel="stylesheet" type="text/css" href="./css/styles.css?v=1234abcd" />'),
        );
        self::assertSame(
            "<link href='./css/styles.css?v=VERSION&amp;lang=ja' rel='stylesheet' />",
            $this->sanitizeHtml("<link href='./css/styles.css?v=5678efgh&amp;lang=ja' rel='stylesheet' />"),
        );
        $html = '<link rel="stylesheet" href="./css/styles.css" /><a href="./css/styles.css?v=1234abcd">CSS</a>';
        self::assertSame($html, $this->sanitizeHtml($html));
    }

    public function testSanitizeCsrfToken(): void
    {
        self::assertSame(
            '<input type="hidden" name="csrf_token" value="CSRF_TOKEN">',
            $this->sanitizeHtml(
                '<input type="hidden" name="csrf_token" value="0123456789abcdef">',
            ),
        );
    }

    private function sanitizeHtml(string $html): string
    {
        $html = preg_replace(
            '/(<input type="hidden" name="csrf_token" value=")[0-9a-f]+(")/',
            '${1}CSRF_TOKEN${2}',
            $html,
        );

        // script の src に含まれるバージョン値を置換
        $html = preg_replace(
            '/(<script\b[^>]*\ssrc=["\'][^"\']*\.js\?v=)[^"\'&\s>]+/i',
            '${1}VERSION',
            $html,
        );

        // link の href に含まれる CSS のバージョン値を置換
        $html = preg_replace(
            '/(<link\b[^>]*\shref=["\'][^"\']*\.css\?v=)[^"\'&\s>]+/i',
            '${1}VERSION',
            $html,
        );

        // 日付と時刻を置換
        $html = preg_replace(
            '/\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2}/',
            'YYYY-MM-DD HH:MM:SS',
            $html,
        );

        // type="hidden" name="date" を含むinput要素のvalue属性のみ置換
        $html = preg_replace(
            '/<input[^>]*type="hidden"[^>]*name="date"[^>]*value="\d+"[^>]*>/',
            '<input type="hidden" name="date" value="TIMESTAMP">',
            $html,
        );

        // 7259日前にブックマーク
        $html = preg_replace(
            '/\d+日前にブックマーク/',
            'XXXX日前にブックマーク',
            $html,
        );

        $html = preg_replace(
            '#/opt/lampp/htdocs/#',
            '/var/www/html/',
            $html,
        );

        $html = preg_replace(
            '#/templates_c/.+\.tpl\.php#',
            '/templates_c/1234abcd.tpl.php',
            $html,
        );

        $html = preg_replace(
            '/Smartyのバージョン：\d+\.\d+\.\d+/',
            'Smartyのバージョン：X.X.X',
            $html,
        );

        if (str_contains($html, '時間毎にヘッダーを変える')) {
            // chapter4_5/index.php 昼画像・夜画像
            $html = str_replace('title_night.gif', 'title_REPLACED.gif', $html);
            $html = str_replace('title_day.gif', 'title_REPLACED.gif', $html);

            // chapter4_5/index.php 現在xx時
            $html = preg_replace('/現在\d{1,2}時/', '現在XX時', $html);
        }

        if (str_contains($html, 'startDate[Year]')) {
            // chapter4_7/index.php 年月日時分秒のセレクトボックスの selected="selected" 値を削除します
            $html = preg_replace(
                '/(<option\b(?=[^>]*\bvalue="\d+")[^>]*?)\s+selected="selected"/i',
                '$1',
                $html,
            );

            // chapter4_7/index.php 年のセレクトボックスの値を YYYY に置換します
            $html = preg_replace(
                '/<option value="(\d{4})".*?>(\d{4})<\/option>/',
                '<option value="YYYY">YYYY</option>',
                $html,
            );
        }

        // chapter5_4/index.php
        $html = preg_replace(
            '/Smarty for Designers : \d+/',
            'Smarty for Designers : TIMESTAMP',
            $html,
        );

        return $html;
    }
}
