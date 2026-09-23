<?php

namespace SmartyBook\chapter5_6\_read\classes;

class MyList
{
    /** @var string */
    public $ListId;
    /** @var string */
    public $ListName;
    /** @var string */
    public $NickName;
    /** @var list<array{ASIN: string, Item?: mixed}> */
    public $detail_arr;

    public function __construct()
    {
        $this->ListId     = '';
        $this->ListName   = '';
        $this->NickName   = '';
        $this->detail_arr = [];
    }

    /**
     * @param array{ListName: string, NickName: string, detail_arr: list<array{ASIN: string, Item?: mixed}>} $i_vars
     * @return void
     */
    public function input($i_vars)
    {
        $this->ListName   = $i_vars['ListName'];
        $this->NickName   = $i_vars['NickName'];
        $this->detail_arr = $i_vars['detail_arr'];
    }

    /**
     * @return string
     */
    public function getASINs()
    {
        // ASINの重複要素と空要素を取り除いて、カンマ区切りにする
        $map = [];

        foreach ($this->detail_arr as $detail) {
            if (! empty($detail['ASIN'])) {
                $map[$detail['ASIN']] = 1;
            }
        }

        return join(',', array_keys($map));
    }

    /**
     * @param list<array{ASIN: string}> $i_Item_arr
     * @return void
     */
    public function setItems($i_Item_arr)
    {
        $map = [];
        foreach ($this->detail_arr as $i => $detail) {
            if (! empty($detail['ASIN'])) {
                $map[$detail['ASIN']][] = $i;
            }
        }

        foreach ($i_Item_arr as $Item) {
            foreach ($map[$Item['ASIN']] as $i) {
                $this->detail_arr[$i]['Item'] = $Item;
            }
        }
    }
}
