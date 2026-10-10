<?php

declare(strict_types=1);

// 2020年3月で、本プログラムで使っているAmazon_ECSのAPIは廃止となりました。
// 常に410エラーです

return [
    // マイリストの商品数
    'max_items' => 25,

    // amazon.com Web サービス 登録ID
    // 下記の登録IDを書き換えてご使用下さい
    'access_key_id' => '********************',
    'secret_access_key' => '********************',

    // amazon.co.jp アソシエイトID
    // 下記のアフィリエイトIDを書き換えてご使用ください
    'associate_tag' => '********************',

    // 保存ファイル
    'storage_path' => dirname(__DIR__, 1) . '/_write/mylist/1.txt',
];
