<?php
// マイリストの商品数
$CFG['max_items'] = 25;

// amazon.com Web サービス 登録ID
// 下記の登録IDを書き換えてご使用下さい
$CFG['access_key_id'] = '********************';

// amazon.co.jp アソシエイトID
// 下記のアフィリエイトIDを書き換えてご使用ください
$CFG['associate_id'] = '***********';

// ファイル、ディレクトリ
$CFG['mylist_dir'  ] = '_write/mylist/';
$CFG['aws_cache_dir'] = '_temp/amazon/';

mb_internal_encoding( 'UTF-8' );
?>