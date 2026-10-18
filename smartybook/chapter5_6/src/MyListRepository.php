<?php

namespace SmartyBook\chapter5_6\src;

class MyListRepository
{
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
        $myList = unserialize($buf);

        return new MyList(
            $myList->ListName,
            $myList->NickName,
            $myList->detail_arr,
        );
    }

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
