<?php

namespace SmartyBook\chapter5_6\src;

class MyList
{
    /** @var string */
    public string $ListName;
    /** @var string */
    public string $NickName;
    /** @var list<array{ASIN: string, comment: string}> */
    public array $detail_arr;

    public function __construct()
    {
        $this->ListName   = '';
        $this->NickName   = '';
        $this->detail_arr = [];
    }

    /**
     * @param array{ListName: string, NickName: string, detail_arr: list<array{ASIN: string, comment: string}>} $vars
     * @return void
     */
    public function input(array $vars): void
    {
        $this->ListName   = $vars['ListName'];
        $this->NickName   = $vars['NickName'];
        $this->detail_arr = $vars['detail_arr'];
    }

    /**
     * @return string
     */
    public function getASINs(): string
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
}
