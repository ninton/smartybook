<?php

namespace SmartyBook\chapter4_6;

use PDO;

/**
 *  テーブルCMSの読み出し操作
 */
class CMS
{
    private PDO $dbh;

    /**
     * @param string $i_dsn
     * @param string $i_dbuser
     * @param string $dbPassword
     * @return void
     */
    public function __construct(string $i_dsn, string $i_dbuser, string $dbPassword)
    {
        $this->dbh = new PDO($i_dsn, $i_dbuser, $dbPassword);
        $this->dbh->query('SET NAMES UTF8');
    }

    /**
     * @return int
     */
    public function getCount(): int
    {
        $stmt = $this->dbh->query('SELECT COUNT(id) FROM cms');
        $row = $stmt->fetch(PDO::FETCH_NUM);
        return $row[0];
    }

    /**
     * @param int $i_offset
     * @param int $i_limit
     * @param string $i_sort
     * @param string $i_order
     * @return list<array<string, mixed>>
     */
    public function getAll(int $i_offset, int $i_limit, string $i_sort, string $i_order): array
    {
        // 安全な値かどうかをチェックする
        switch ($i_sort) {
            case 'id':
            case 'category':
            case 'title':
            case 'comment':
            case 'time':
                break;
            default:
                return [];
        }

        switch ($i_order) {
            case 'asc':
            case 'desc':
                break;
            default:
                return [];
        }

        $sort  = addslashes($i_sort);
        $order = addslashes($i_order);
        $offset = 0 + (int)$i_offset;
        $limit = 0 + (int)$i_limit;
        $query = "SELECT * FROM cms ORDER BY $sort $order LIMIT $offset, $limit";
        $stmt = $this->dbh->query($query);
        $rcd_arr = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $rcd_arr;
    }
}
