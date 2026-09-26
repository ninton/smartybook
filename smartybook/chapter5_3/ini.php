<?php

// PHP Strict Standards:  Non-static method Net_UserAgent_Mobile::factory() should not be called statically
error_reporting(error_reporting() & ~E_DEPRECATED);
require_once __DIR__ . '/../../vendor/autoload.php';
require_once __DIR__ . '/../chapter4_1/ini.php';

/**
 * @fixme chapter5_3 配下にdata.csvを配置したい
 * @var string $csv chapter4_1/ini.phpで絶対パス定義されている
 */
$CFG['SRCIMG_DIR'] = '../chapter4_1/images/';
$CFG['DSTIMG_DIR'] = './images/';
$CFG['CSV_FILE'  ] = $csv;
