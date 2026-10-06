<?php

/**
 * 2020年3月で、本プログラムで使っているAmazon_ECSのAPIは廃止となりました。
 * APIを呼ぶ代わりにダミーデータを返すスタブクラスを使います。
 */

namespace SmartyBook\chapter5_6\src;

use App\PearStub\ServicesAmazonStub;

class AppAmazon
{
    private ServicesAmazonStub $amazon;

    /**
     * @param string $access_key_id
     * @param string $secret_access_key
     * @param string $associate_tag
     * @return void
     */
    public function __construct(string $access_key_id, string $secret_access_key, string $associate_tag)
    {
        $amazon = new ServicesAmazonStub($access_key_id, $secret_access_key, $associate_tag);
        $this->amazon = $amazon;
    }

    /*
        $ASINs = '12345,23456,34567';
        $options['ResponseGroup'] = 'Medium';
        $errmsg = $amazon->ItemLookup( $ASINs, $options, &$itemArr ) {
        print_r( $itemArr );

        $itemArr[0]    ASIN「12345」のItem情報
        $itemArr[2]    ASIN「23456」のItem情報
        $itemArr[3]    ASIN「34567」のItem情報
    */
    // ItemLookupで書籍掲載しているので、itemLookupではなく、ItemLookupのままとすることにした。
    /**
     * @param string $i_ASINs
     * @param array<string, mixed> $i_options
     * @param array<int, mixed> $itemArr
     * @param-out array<mixed> $itemArr
     * @return string error message
     */
    public function ItemLookup(string $i_ASINs, array $i_options, array &$itemArr): string
    {
        $ASIN_arr = explode(',', $i_ASINs);

        // $ASIN_arrから10個づつ問合わせして、$itemArrに蓄積する
        $itemArr = [];
        $asin_arr_cnt = count($ASIN_arr);
        for ($i = 0; $i < $asin_arr_cnt; $i += 10) {
            $ASINs = join(',', array_slice($ASIN_arr, $i, 10));
            if ($ASINs != '') {
                $result = $this->amazon->ItemLookup($ASINs, $i_options);

                $itemArr = array_merge($itemArr, $result['Item']);
            }
        }
        return '';
    }
}
