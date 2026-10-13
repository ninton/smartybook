<?php

return [
    // ウェブサイト名
    'siteName' => 'Smarty for Designers',

    // CSVファイル名
    // @fixme chapter5_3 配下にdata.csvを配置したい
    'csvFilePath' => dirname(__DIR__, 2) . '/chapter4_1/data.csv',

    // ホーム
    'home' => 'index.php',

    // カテゴリ一覧
    'categories' => ['Study', 'Eating', 'Work'],

    'categoryToIconMap' => [
        'Study'  => '&#xE683;',
        'Eating' => '&#xE66F;',
        'Work'   => '&#xE733;',
    ],

    'platformTypeToLayoutMap' => [
        'imode' => 'base_imode.tpl',
        'ezweb' => 'base_ezweb.tpl',
        'softbank' => 'base_softbank.tpl',
    ],
];
