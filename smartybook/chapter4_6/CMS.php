<?php

namespace SmartyBook\chapter4_6;

/**
 *  テーブルCMSの読み出し操作
 */
class CMS
{
    /**
     * @var PDO
     */
    private $dbh;

    /**
     *  @param  string
     *  @param  array
     *  @return void
     *
     * @SuppressWarnings(PHPMD.MissingImport)
     */
    public function __construct($i_dsn, $i_dbuser)
    {
        $this->dbh = new PDO($i_dsn, $i_dbuser);
        $this->dbh->query('SET NAMES UTF8');
    }

    /**
     *  @return integer
     */
    public function getCount()
    {
        $stmt = $this->dbh->query('SELECT COUNT(id) FROM cms');
        $row = $stmt->fetch(PDO::FETCH_NUM);
        return $row[0];
    }

    /**
     *  @param  integer
     *  @param  integer
     *  @param  string
     *  @param  string
     *  @return array
     */
    public function getAll($i_offset, $i_limit, $i_sort, $i_order)
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
                return array();
        }

        switch ($i_order) {
            case 'asc':
            case 'desc':
                break;
            default:
                return array();
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
