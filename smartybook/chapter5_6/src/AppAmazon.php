<?php

/**
 * 2020年3月で、本プログラムで使っているAmazon_ECSのAPIは廃止となりました。
 * APIを呼ぶ代わりにダミーデータを返すスタブクラスを使います。
 */

namespace SmartyBook\chapter5_6\src;

use App\PearStub\ServicesAmazonStub;

final readonly class AppAmazon
{
    public function __construct(private ServicesAmazonStub $servicesAmazonStub)
    {
    }

    /*
        $ASINs = '12345,23456,34567';
        $options['ResponseGroup'] = 'Medium';
        $errmsg = $servicesAmazon->ItemLookup( $ASINs, $options, &$itemArr ) {
        print_r( $itemArr );

        $itemArr[0]    ASIN「12345」のItem情報
        $itemArr[2]    ASIN「23456」のItem情報
        $itemArr[3]    ASIN「34567」のItem情報
    */
    // ItemLookupで書籍掲載しているので、itemLookupではなく、ItemLookupのままとすることにした。
    /**
     * @param string $ASINs
     * @param array<string, mixed> $options
     * @param array<int, mixed> $itemArr
     * @param-out array<mixed> $itemArr
     * @return string error message
     */
    public function ItemLookup(string $ASINs, array $options, array &$itemArr): string
    {
        $ASIN_arr = explode(',', $ASINs);

        // $ASIN_arrから10個づつ問合わせして、$itemArrに蓄積する
        $itemArr = [];
        $asin_arr_cnt = count($ASIN_arr);
        for ($i = 0; $i < $asin_arr_cnt; $i += 10) {
            $slicedASINs = join(',', array_slice($ASIN_arr, $i, 10));
            if ($slicedASINs != '') {
                $result = $this->servicesAmazonStub->ItemLookup($slicedASINs, $options);

                $itemArr = array_merge($itemArr, $result['Item']);
            }
        }
        return '';
    }
}
