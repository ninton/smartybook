<?php

namespace SmartyBook\chapter5_6\src;

class MyListRepository
{
    /**
     * @var int
     */
    private int $max_items;

    /**
     * @var string
     */
    private string $dir;

    /**
     * @param int $i_max_items
     * @param string $i_dir
     */
    public function __construct(int $i_max_items, string $i_dir)
    {
        $this->max_items = $i_max_items;
        $this->dir = $i_dir;
    }

    /**
     * @return MyList|null
     */
    public function read(): ?MyList
    {
        $path = $this->getPath();
        if ($path === '') {
            return null;
        }
        if (!file_exists($path)) {
            return null;
        }

        $buf = file_get_contents($path);
        if (!$buf) {
            $mylist = new MyList();
            return $mylist;
        }

        /**
         * @fixme 保存形式をJSONに変更したい
         * serialize形式は オブジェクトのFQDNを含むので、クラス名やディレクトリ構造を変更すると復元できない。
         */
        $mylist = unserialize($buf);
        $mylist->detail_arr = array_slice($mylist->detail_arr, 0, $this->max_items);

        return $mylist;
    }

    /**
     * @param MyList $i_MyList
     * @return void
     */
    public function write(MyList $i_MyList): void
    {
        /**
         * @fixme MyListオブジェクトを連想配列やスカラー値に変換し、json_encode()で保存したい
         * serialize形式は オブジェクトのFQDNを含むので、クラス名やディレクトリ構造を変更すると復元できない。
         */
        $buf = serialize($i_MyList);
        $path = $this->getPath();
        if ($path !== '') {
            file_put_contents($path, $buf);
        }
    }

    /**
     * @return string
     */
    public function getPath(): string
    {
        return sprintf('%s1.txt', $this->dir);
    }
}
