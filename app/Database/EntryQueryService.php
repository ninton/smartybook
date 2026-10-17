<?php

namespace App\Database;

use PDO;

/**
 *  テーブルCMSの読み出し操作
 */
final readonly class EntryQueryService
{
    public function __construct(private PDO $pdo)
    {
    }

    public function count(): int
    {
        return (int) $this->pdo->query('SELECT COUNT(id) FROM entries')->fetchColumn();
    }

    /**
     * @param int $offset
     * @param int $limit
     * @param string $sortKey 並び替えの基準となるカラム名
     * @param string $sortDirection 並び替えの方向（asc または desc）
     * @return list<array<string, mixed>>
     */
    public function findList(int $offset, int $limit, string $sortKey, string $sortDirection): array
    {
        $allowedSortKeys = ['id', 'category', 'title', 'comment', 'time'];
        $allowedDirections = ['asc', 'desc'];

        if (!in_array($sortKey, $allowedSortKeys, true)) {
            return [];
        }

        if (!in_array($sortDirection, $allowedDirections, true)) {
            return [];
        }

        $query = "SELECT * FROM entries ORDER BY $sortKey $sortDirection LIMIT $offset, $limit";

        return $this->pdo->query($query)->fetchAll(PDO::FETCH_ASSOC);
    }
}
