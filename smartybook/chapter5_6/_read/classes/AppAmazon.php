<?php

namespace SmartyBook\chapter5_6\_read\classes;

use Services_Amazon;

/**
 *  @author MW web studio, Aoki Makoto, 2007-12
 */
class AppAmazon
{
    /**
     * @var Services_Amazon
     */
    private $amazon;

    /**
     *  @param  string
     *  @param  string
     *  @param  string
     *  @return void
     *
     *  @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function __construct($i_access_key_id, $i_associate_id, $i_cache_dir)
    {
        // Services_AmazonECS4は非推奨となり、Services_Amazon(を使うようにとのこと
        // https://wiki.php.net/pear/packages/services_amazon
        $amazon = new Services_Amazon($i_access_key_id, $i_associate_id);
        $amazon->setLocale('JP');
        //$amazon->setCache('file', array('cache_dir' => $i_cache_dir));
        $amazon->setCacheExpire(24 * 3600);
        $this->amazon = $amazon;
    }

    /**
     *  @param  string
     *  @param  assoc
     *  @param  array
     *  @return string  error message
     *
     * @SuppressWarnings(PHPMD.StaticAccess)
     */
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
    public function ItemLookup($i_ASINs, $i_options, &$o_Item_arr)
    {
        $ASIN_arr = explode(',', $i_ASINs);

        // $ASIN_arrから10個づつ問合わせして、$o_Item_arrに蓄積する
        $o_Item_arr = array();
        $asin_arr_cnt = count($ASIN_arr);
        for ($i = 0; $i < $asin_arr_cnt; $i += 10) {
            $ASINs = join(',', array_slice($ASIN_arr, $i, 10));
            if ($ASINs != '') {
                $result = $this->amazon->ItemLookup($ASINs, $i_options);
                if (\PEAR::isError($result)) {
                    return $result->message;
                }

                $o_Item_arr = array_merge($o_Item_arr, $result['Item']);
            }
        }
        return '';
    }
}
