<?php

// Deprecated: Creation of dynamic property App\PearStub\PagerStub::$ExOffsetFrom is deprecated in smartybook/chapter5_3/plib/pager_ex.php on line 16
error_reporting(error_reporting() & ~E_DEPRECATED);

// ウェブサイト名
$siteName = 'Smarty for Designers';
// CSVファイル名
$csv = dirname(__DIR__, 2) . '/chapter4_1/data.csv';
// ホーム
$home = 'index.php';
// カテゴリ一覧
$categories = ['Study', 'Eating', 'Work'];

/**
 * @fixme chapter5_3 配下にdata.csvを配置したい
 */
$CFG['SRCIMG_DIR'] = dirname(__DIR__, 2) . '/chapter4_1/images/';
$CFG['DSTIMG_DIR'] = './images/';
$CFG['CSV_FILE'  ] = $csv;
