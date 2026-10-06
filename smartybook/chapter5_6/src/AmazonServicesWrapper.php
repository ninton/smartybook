<?php

/**
 * 2020年3月で、本プログラムで使っているAmazon_ECSのAPIは廃止となりました。
 * APIを呼ぶ代わりにダミーデータを返すスタブクラスを使います。
 */

/**
 * ### クラス命名の思考プロセス
 * 1. AppAmazon（改善前）
 * 「AppAmazon」は範囲が広すぎて「何をするクラスか」が分からない。
 *
 * 2. AmazonServicesWrapper（段階的リファクタリング）
 * 既存の ServicesAmazon::ItemLookup の件数制限を吸収するためだけのラッパー。
 *
 * 3. AmazonProductFetcher（理想的なリファクタリング）
 * 「Amazonから商品情報を取得する」という**目的（ユースケース）**をそのまま命名。
 * 10件ごとの分割取得だけでなく、APIレスポンスの配列をアプリケーション用のDTO（あるいは専用の配列構造）へ変換する責務を
 * 持たせることで、外部APIの仕様変更に強い設計へ進化させることができる。
 *
 * ### リファクタリング解説ポイント
 * 1. **クラス名（AppAmazon ➔ AmazonServicesWrapper）**
 * - 「App〜」という曖昧な名前を配し、`ServicesAmazon` の制約（10件分割リクエスト等）を
 * 吸収するための薄いラッパー（Wrapper）であることを明確にしました。
 *
 * 2. **メソッド名（ItemLookup を維持）**
 * - PHPの標準的な命名規則（ローワーキャメルケース）からは外れますが、
 * あえて元ライブラリ（ServicesAmazon::ItemLookup）のメソッド名をそのまま維持しています。
 * - これにより、「元のAPIをそのまま透過的にラップしている」という意図が明確になり、
 * レガシーコード全体の追跡性を高めています。
 */

namespace SmartyBook\chapter5_6\src;

use App\PearStub\ServicesAmazonStub;

final readonly class AmazonServicesWrapper
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
    // FIXME: AmazonProductFetcher へリファクタするときに ItemLookupメソッド名のリネームも検討してください
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
