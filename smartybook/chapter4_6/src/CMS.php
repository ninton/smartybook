<?php

namespace SmartyBook\chapter4_6\src;

use PDO;

/**
 *  テーブルCMSの読み出し操作
 */
final readonly class CMS
{
    public function __construct(private PDO $pdo)
    {
    }

    public function count(): int
    {
        return (int) $this->pdo->query('SELECT COUNT(id) FROM cms')->fetchColumn();
    }

    /**
     * @param int $offset
     * @param int $limit
     * @param string $sort 並び替える項目
     * @param string $order 並び替えの順序（asc または desc）
     * @return list<array<string, mixed>>
     */
    public function findList(int $offset, int $limit, string $sort, string $order): array
    {
        // SQLインジェクションを防ぐためのホワイトリスト検証
        $allowedSorts = ['id', 'category', 'title', 'comment', 'time'];
        $allowedOrders = ['asc', 'desc'];

        if (!in_array($sort, $allowedSorts, true)) {
            return [];
        }

        if (!in_array($order, $allowedOrders, true)) {
            return [];
        }

        $query = "SELECT * FROM cms ORDER BY $sort $order LIMIT $offset, $limit";

        return $this->pdo->query($query)->fetchAll(PDO::FETCH_ASSOC);
    }
}
