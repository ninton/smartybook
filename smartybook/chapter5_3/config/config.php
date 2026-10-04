<?php

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
$CFG['CSV_FILE'  ] = $csv;
