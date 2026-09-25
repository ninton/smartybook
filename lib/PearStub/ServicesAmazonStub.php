<?php

namespace Lib\PearStub;

class ServicesAmazonStub
{
    // @phpstan-ignore-next-line
    public function __construct($access_key_id, $secret_access_key, $associate_tag = null)
    {
        // スタブなので親を呼ばなくてよい
    }

    /**
     *  @param string $item_id
     *  @param array<string,string> $options
     *  @return array{Item: list<array<string, mixed>>}
     */
    public function ItemLookup($item_id, $options = []): array
    {
        $item_id_arr = preg_split('/,/', $item_id, -1, PREG_SPLIT_NO_EMPTY);

        $result['Item'] = array_map(
            self::createDummyItem(...),
            $item_id_arr,
        );

        return $result;
    }

    /**
     *  @param string $item_id
     *  @return array<string, mixed>
     */
    private static function createDummyItem(string $item_id): array
    {
        return [
            'ASIN' => "$item_id",
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
        ];
    }
}
