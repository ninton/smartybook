<?php

/**
 *  @author MW web studio, Aoki Makoto, 2007-12
 */
class MyList
{
    public $ListId;
    public $ListName;
    public $NickName;
    public $detail_arr;

    public function __construct()
    {
        $this->ListId    = '';
        $this->ListName  = '';
        $this->NickName  = '';
        $this->detail_arr = array();
    }

    public function input($i_vars)
    {
        $this->ListName    = $i_vars['ListName'];
        $this->NickName    = $i_vars['NickName'];
        $this->detail_arr  = $i_vars['detail_arr'];
    }

    public function getASINs()
    {
        // ASINの重複要素と空要素を取り除いて、カンマ区切りにする
        $map = array();

        foreach ($this->detail_arr as $detail) {
            if (! empty($detail['ASIN'])) {
                $map[$detail['ASIN']] = 1;
            }
        }

        return join(',', array_keys($map));
    }

    public function setItems($i_Item_arr)
    {
        $map = array();
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
