<?php

// 2020年3月で、本プログラムで使っているAmazon_ECSのAPIは廃止となりました。
// 常に410エラーです

// マイリストの商品数
$CFG['max_items'] = 25;

// amazon.com Web サービス 登録ID
// 下記の登録IDを書き換えてご使用下さい
$CFG['access_key_id'] = '********************';
$CFG['secret_access_key'] = '********************';

// amazon.co.jp アソシエイトID
// 下記のアフィリエイトIDを書き換えてご使用ください
$CFG['associate_tag'] = '********************';

// ファイル、ディレクトリ
$CFG['mylist_dir'  ] = __DIR__ . '/../_write/mylist/';
$CFG['aws_cache_dir'] =  __DIR__ . '/../_temp/amazon/';
mb_internal_encoding('UTF-8');
