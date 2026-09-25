<?php

/**
 * 2020年3月で、本プログラムで使っているAmazon_ECSのAPIは廃止となりました。
 * APIを呼ぶ代わりにダミーデータを返すスタブクラスを使います。
 */

namespace SmartyBook\chapter5_6\_read\classes;

use Lib\PearStub\ServicesAmazonStub;

class AppAmazon
{
    private ServicesAmazonStub $amazon;

    /**
     *  @param string $access_key_id
     *  @param string $secret_access_key
     *  @param string $associate_tag
     *  @return void
     *
     */
    public function __construct(string $access_key_id, string $secret_access_key, string $associate_tag)
    {
        $amazon = new ServicesAmazonStub($access_key_id, $secret_access_key, $associate_tag);
        $this->amazon = $amazon;
    }

    /*
        $ASINs = '12345,23456,34567';
        $options['ResponseGroup'] = 'Medium';
        $errmsg = $amazon->ItemLookup( $ASINs, $options, &$Item_arr ) {
        print_r( $Item_arr );

        $Item_arr[0]    ASIN「12345」のItem情報
        $Item_arr[2]    ASIN「23456」のItem情報
        $Item_arr[3]    ASIN「34567」のItem情報
    */
    // ItemLookupで書籍掲載しているので、itemLookupではなく、ItemLookupのままとすることにした。
    /**
     *  @param string $i_ASINs
     *  @param array<string, mixed> $i_options
     *  @param array<int, mixed> $o_Item_arr
     *  @param-out array<mixed> $o_Item_arr
     *  @return string  error message
     */
    public function ItemLookup(string $i_ASINs, array $i_options, array &$o_Item_arr): string
    {
        $ASIN_arr = explode(',', $i_ASINs);

        // $ASIN_arrから10個づつ問合わせして、$o_Item_arrに蓄積する
        $o_Item_arr = [];
        $asin_arr_cnt = count($ASIN_arr);
        for ($i = 0; $i < $asin_arr_cnt; $i += 10) {
            $ASINs = join(',', array_slice($ASIN_arr, $i, 10));
            if ($ASINs != '') {
                $result = $this->amazon->ItemLookup($ASINs, $i_options);

                $o_Item_arr = array_merge($o_Item_arr, $result['Item']);
            }
        }
        return '';
    }
}
