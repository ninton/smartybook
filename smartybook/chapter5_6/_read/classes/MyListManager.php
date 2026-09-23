<?php

namespace SmartyBook\chapter5_6\_read\classes;

class MyListManager
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
    public function __construct($i_max_items, $i_dir)
    {
        $this->max_items = $i_max_items;
        $this->dir = $i_dir;
    }

    /**
     * @param string $i_ListId
     * @return MyList|null
     */
    public function read($i_ListId): ?MyList
    {
        $path = $this->getPath($i_ListId);
        if ($path === '') {
            return null;
        }
        if (!file_exists($path)) {
            return null;
        }

        $buf = file_get_contents($path);
        if (!$buf) {
            $mylist = new MyList();
            $mylist->ListId = $i_ListId;
            return $mylist;
        }

        $mylist = unserialize($buf);
        $mylist->item_arr    = array_slice($mylist->item_arr, 0, $this->max_items);

        return $mylist;
    }

    /**
     * @param MyList $i_MyList
     * @return void
     */
    public function write($i_MyList): void
    {
        $buf = serialize($i_MyList);
        $path = $this->getPath($i_MyList->ListId);
        if ($path !== '') {
            file_put_contents($path, $buf);
        }
    }

    /**
     * @param string $i_ListId
     * @return string
     */
    public function getPath($i_ListId): string
    {
        if (preg_match('/[^0-9A-Za-z]/', $i_ListId)) {
            return '';
        }

        return sprintf('%s%s.txt', $this->dir, $i_ListId);
    }
}
