<?php

declare(strict_types=1);

namespace Tests\GoldenMaster;

use InvalidArgumentException;

final class CrawlCode
{
    private const string DEFAULT_USER_AGENT = 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:143.0) Gecko/20100101 Firefox/143.0';

    /**
     * @param string $urlCsv
     * @return list<CrawlCommand>
     */
    public static function readCrawlCommandArrFromCsv(string $urlCsv): array
    {
        $csvArr = self::readCsvArr($urlCsv);

        $csvArr2 = array_slice($csvArr, 1); // ヘッダー行を削除

        $csvArr3 = array_filter(
            $csvArr2,
            fn (array $row) => !empty($row[0]) && !str_starts_with($row[0], '#'),
        );

        $crawlCommandArr = array_map(
            fn (array $row) => new CrawlCommand(
                $row[0],
                $row[1],
                $row[2],
                $row[3] ?? '',
            ),
            $csvArr3,
        );

        return array_values($crawlCommandArr);
    }

    /**
     * @param string $urlCsv
     * @return list<list<string>>
     */
    private static function readCsvArr(string $urlCsv): array
    {
        $fp = fopen($urlCsv, 'r');
        if (!$fp) {
            throw new \Exception("Failed to open CSV file: {$urlCsv}");
        }

        try {
            $csvArr = [];
            while ($row = fgetcsv($fp, null, ',', '"', '\\')) {
                $csvArr[] = $row;
            }
        } finally {
            fclose($fp);
        }

        return $csvArr;
    }

    public static function crawl(string $url, string $method, string $data, string $userAgent = self::DEFAULT_USER_AGENT): string
    {
        if ($url === '') {
            throw new InvalidArgumentException('URL must be a non-empty string.');
        }

        $ch = curl_init();
        if (!$ch) {
            throw new \Exception('Failed to initialize cURL');
        }
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_USERAGENT, $userAgent);

        if (strtoupper($method) === 'POST') {
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        }

        $response = curl_exec($ch);

        return is_bool($response) ? '' : $response;
    }

    /** @noinspection PhpUnused curlで PHPUNIT_RUNNING=1 を設定する方法を検討中、利用予定 */
    public static function main(string $urlCsv): int
    {
        $crawlCommandArr = self::readCrawlCommandArrFromCsv($urlCsv);

        foreach ($crawlCommandArr as $crawlCommand) {
            self::crawl($crawlCommand->url, $crawlCommand->method, $crawlCommand->data);
        }

        return count($crawlCommandArr);
    }
}
