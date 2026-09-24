<?php

/**
 * 2020年3月で、本プログラムで使っているAmazon_ECSのAPIは廃止となりました。
 * APIを呼ぶ代わりにダミーデータを返します。
 */

namespace SmartyBook\chapter5_6\_read\classes;

class AppAmazon
{
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
        // 空のASINを除外する
        $ASIN_arr = array_filter($ASIN_arr, static fn (string $ASIN): bool => $ASIN !== '');

        $o_Item_arr = array_map(
            fn ($ASIN) => [
                'ASIN' => "$ASIN",
                'SmallImage' => [
                    'URL' => 'https://m.media-amazon.com/images/I/51tY5PtGsuL.jpg',
                    'Height' => [
                        '_content' => 75,
                    ],
                    'Width' => [
                        '_content' => 53,
                    ],
                ],
                'DetailPageURL' => 'https://www.amazon.co.jp/dp/4774136301',
                'ItemAttributes' => [
                    'Title' => '速習Webテクニック Smarty動的Webサイト構築入門 (Quick Master of Web Technique)',
                    'Author' => ['原 一浩', '青木 真', '鵜飼 孝陽', '川野辺 亮'],
                    'Publisher' => '技術評論社',
                    'PublicationDate' => '2008/9/20',
                    'ListPrice' => [
                        'FormattedPrice' => '2694',
                    ],
                ],
            ],
            $ASIN_arr,
        );

        return '';
    }
}
