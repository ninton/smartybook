<?php
require_once( 'Pager.php' );
require_once( dirname(__FILE__) . '/../smarty/libs/Smarty.class.php' );
require_once( dirname(__FILE__) . '/../chapter4_1/ini.php' );

$CFG['SRCIMG_DIR'] = '../chapter4_1/images/';
$CFG['DSTIMG_DIR'] = './images/';
$CFG['CSV_FILE'  ] = "../chapter4_1/$csv";
?>