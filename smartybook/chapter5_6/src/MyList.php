<?php

declare(strict_types=1);

namespace SmartyBook\chapter5_6\src;

final readonly class MyList
{
    /**
     * @param list<array{ASIN: string, comment: string}> $detail_arr
     */
    public function __construct(
        public string $ListName = '',
        public string $NickName = '',
        public array $detail_arr = [],
    ) {
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
