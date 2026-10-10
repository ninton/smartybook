<?php

namespace SmartyBook\chapter5_6\src;

class MyListRepository
{
    /**
     * @var int
     */
    private int $max_items;

    /**
     * @param int $max_items
     */
    public function __construct(int $max_items)
    {
        $this->max_items = $max_items;
    }

    /**
     * @return MyList|null
     */
    public function read(string $path): ?MyList
    {
        if ($path === '') {
            return null;
        }
        if (!file_exists($path)) {
            return null;
        }

        $buf = file_get_contents($path);
        if (!$buf) {
            return new MyList();
        }

        /**
         * @fixme 保存形式をJSONに変更したい
         * serialize形式は オブジェクトのFQDNを含むので、クラス名やディレクトリ構造を変更すると復元できない。
         */
        $mylist = unserialize($buf);

        // FIXME: リポジトリで切り詰めをするよりも、入力層でバリデーションとエラー表示、VO生成時にも件数チェックしたい
        return new MyList(
            $mylist->ListName,
            $mylist->NickName,
            array_slice($mylist->detail_arr, 0, $this->max_items),
        );
    }

    /**
     * @param MyList $MyList
     * @return void
     */
    public function write(string $path, MyList $MyList): void
    {
        /**
         * @fixme MyListオブジェクトを連想配列やスカラー値に変換し、json_encode()で保存したい
         * serialize形式は オブジェクトのFQDNを含むので、クラス名やディレクトリ構造を変更すると復元できない。
         */
        $buf = serialize($MyList);

        if ($path !== '') {
            file_put_contents($path, $buf);
        }
    }
}
