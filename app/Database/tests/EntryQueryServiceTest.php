<?php

declare(strict_types=1);

use App\Database\EntryQueryService;

it('エントリー件数を整数で返す', function (bool $seed, int $expected): void {
    $service = new EntryQueryService(createEntryQueryServiceTestPdo($seed));

    expect($service->count())->toBe($expected);
})->with([
    '複数件のエントリーがある場合' => [true, 3],
    'エントリーがない場合' => [false, 0],
]);

it('許可された各ソートキーと方向でエントリーを並べ替える', function (string $sortKey, string $sortDirection, array $expectedIds): void {
    $service = new EntryQueryService(createEntryQueryServiceTestPdo());

    $rows = $service->findList(0, 10, $sortKey, $sortDirection);

    expect(array_column($rows, 'id'))->toBe($expectedIds);
})->with([
    'id の昇順' => ['id', 'asc', [1, 2, 3]],
    'id の降順' => ['id', 'desc', [3, 2, 1]],
    'category の昇順' => ['category', 'asc', [2, 3, 1]],
    'category の降順' => ['category', 'desc', [1, 3, 2]],
    'title の昇順' => ['title', 'asc', [3, 1, 2]],
    'title の降順' => ['title', 'desc', [2, 1, 3]],
    'comment の昇順' => ['comment', 'asc', [1, 3, 2]],
    'comment の降順' => ['comment', 'desc', [2, 3, 1]],
    'time の昇順' => ['time', 'asc', [3, 2, 1]],
    'time の降順' => ['time', 'desc', [1, 2, 3]],
]);

it('指定されたオフセットと取得件数を適用する', function (int $offset, int $limit, array $expectedIds): void {
    $service = new EntryQueryService(createEntryQueryServiceTestPdo());

    $rows = $service->findList($offset, $limit, 'id', 'asc');

    expect(array_column($rows, 'id'))->toBe($expectedIds);
})->with([
    '先頭ページ' => [0, 2, [1, 2]],
    '先頭のエントリーを除いたページ' => [1, 1, [2]],
    '残件数が指定件数に満たない最終ページ' => [2, 2, [3]],
    'オフセットがエントリーの範囲外の場合' => [3, 2, []],
    '取得件数がゼロの場合' => [0, 0, []],
]);

it('全カラムの値を保持する連想配列のリストを返す', function (): void {
    $service = new EntryQueryService(createEntryQueryServiceTestPdo());

    expect($service->findList(1, 1, 'id', 'asc'))->toBe([
        ['id' => 2, 'category' => 'A', 'title' => 'C', 'comment' => 'C', 'time' => 200, 'image' => 'second.jpg'],
    ]);
});

it('許可されていないソート指定ではクエリを実行せず空のリストを返す', function (string $sortKey, string $sortDirection): void {
    $pdo = createEntryQueryServiceTestPdo();
    // クエリが実行されると例外になる状態で、早期リターンを確認する。
    $pdo->exec('DROP TABLE entries');
    $service = new EntryQueryService($pdo);

    expect($service->findList(0, 10, $sortKey, $sortDirection))->toBe([]);
})->with([
    '許可されていないソートキー' => ['image', 'asc'],
    '許可されていないソート方向' => ['id', 'ASC'],
]);

it('エントリーがない場合は空のリストを返す', function (): void {
    $service = new EntryQueryService(createEntryQueryServiceTestPdo(false));

    expect($service->findList(0, 10, 'id', 'asc'))->toBe([]);
});

function createEntryQueryServiceTestPdo(bool $seed = true): PDO
{
    $pdo = new PDO('sqlite::memory:', options: [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    ]);
    $pdo->exec('CREATE TABLE entries (
        id INTEGER PRIMARY KEY,
        category TEXT NOT NULL,
        title TEXT NOT NULL,
        comment TEXT NOT NULL,
        time INTEGER NOT NULL,
        image TEXT NOT NULL
    )');

    if ($seed) {
        $pdo->exec("INSERT INTO entries (id, category, title, comment, time, image) VALUES
            (1, 'C', 'B', 'A', 300, 'first.jpg'),
            (2, 'A', 'C', 'C', 200, 'second.jpg'),
            (3, 'B', 'A', 'B', 100, 'third.jpg')");
    }

    return $pdo;
}
