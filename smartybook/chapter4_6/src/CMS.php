<?php

namespace SmartyBook\chapter4_6\src;

use PDO;

/**
 *  テーブルCMSの読み出し操作
 */
class CMS
{
    private PDO $pdo;

    /**
     * @param string $dsn
     * @param string $dbuser
     * @param string $dbPassword
     */
    public function __construct(string $dsn, string $dbuser, string $dbPassword)
    {
        $this->pdo = new PDO($dsn, $dbuser, $dbPassword);
    }

    /**
     * @return int
     */
    public function getCount(): int
    {
        $stmt = $this->pdo->query('SELECT COUNT(id) FROM cms');
        $row = $stmt->fetch(PDO::FETCH_NUM);
        return $row[0];
    }

    /**
     * @param int $offset
     * @param int $limit
     * @param string $sort
     * @param string $order
     * @return list<array<string, mixed>>
     */
    public function getAll(int $offset, int $limit, string $sort, string $order): array
    {
        // 安全な値かどうかをチェックする
        switch ($sort) {
            case 'id':
            case 'category':
            case 'title':
            case 'comment':
            case 'time':
                break;
            default:
                return [];
        }

        switch ($order) {
            case 'asc':
            case 'desc':
                break;
            default:
                return [];
        }

        $sort  = addslashes($sort);
        $order = addslashes($order);
        $offset = 0 + (int)$offset;
        $limit = 0 + (int)$limit;
        $query = "SELECT * FROM cms ORDER BY $sort $order LIMIT $offset, $limit";
        $stmt = $this->pdo->query($query);
        $rcd_arr = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $rcd_arr;
    }
}
