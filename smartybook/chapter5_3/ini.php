<?php

// PHP Strict Standards:  Non-static method Net_UserAgent_Mobile::factory() should not be called statically
error_reporting(error_reporting() & ~E_DEPRECATED);
require_once dirname(__DIR__, 2) . '/bootstrap/app.php';

// ウェブサイト名
$siteName = 'Smarty for Designers';
// CSVファイル名
$csv = dirname(__DIR__, 1) . '/chapter4_1/data.csv';
// ホーム
$home = 'index.php';
// カテゴリ一覧
$categories = ['Study', 'Eating', 'Work'];

/**
 * @fixme chapter5_3 配下にdata.csvを配置したい
 */
$CFG['SRCIMG_DIR'] = dirname(__DIR__, 1) . '/chapter4_1/images/';
$CFG['DSTIMG_DIR'] = './images/';
$CFG['CSV_FILE'  ] = $csv;
