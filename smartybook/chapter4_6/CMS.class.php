<?php

/**
 *  テーブルCMSの読み出し操作
 */
class CMS
{


    var $db;

    /**
     *  @param  string
     *  @param  array
     *  @return void
     */
    function CMS($i_dsn, $i_dbuser)
    {
        try {
            $this->db = new PDO($i_dsn, $i_dbuser);
        } catch (Exception $e) {
            die($e->getMessage());
        }

        $this->db->query('SET NAMES UTF8');
    }

    /**
     *  @return integer
     */
    function getCount()
    {
        $stmt = $this->db->query('SELECT COUNT(id) FROM cms');
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
    function getAll($i_offset, $i_limit, $i_sort, $i_order)
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
                die();
        }

        switch ($i_order) {
            case 'asc':
            case 'desc':
                break;
            default:
                die();
        }

        $sort  = addslashes($i_sort);
        $order = addslashes($i_order);
        $offset = 0 + (int)$i_offset;
        $limit = 0 + (int)$i_limit;
        $query = "SELECT * FROM cms ORDER BY $sort $order LIMIT $offset, $limit";
        $stmt = $this->db->query($query);
        $rcd_arr = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $rcd_arr;
    }
}
