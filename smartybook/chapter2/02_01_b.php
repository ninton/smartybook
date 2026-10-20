<?php

// ----- 設定ファイル -----
// ウェブサイト名
$siteName = 'Smarty for Designers';

// バージョン番号
$revision = 1;

// CSVファイル名
$csvFilePath = __DIR__ . '/data.csv';

// 画像ディレクトリ
// ※結合時に二重スラッシュ（//）になるのを防ぐため末尾の '/' は除外
// （使用時は $imageDir . '/' . $filename と指定）
$imageDir = './images';

// トップページ
$homeURL = '02_02.php';

// 管理ページ
$adminURL = '02_04.php';

// カテゴリ一覧
$categories[0] = 'Study';
$categories[1] = 'Eating';
$categories[2] = 'Work';
