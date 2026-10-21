<?php

use App\Smarty\AppSmarty as Smarty;

require_once dirname(__DIR__, 3) . '/bootstrap/app.php';

// ----- アクセスされた公開スクリプト名から対応する TPL を特定 -----
$scriptName = basename($_SERVER['SCRIPT_NAME'] ?? 'index.php');
$templateName = preg_replace('/\.php$/', '.tpl', $scriptName);

// ----- メニュー構造データ -----
/**
 * @note 本来 $menuTree のようなサイトマップ構造は、DB から取得（またはCMS等で動的生成）すべき「データ」です。
 * 今回は DB 化を行わない章であるため、src/common_render.php（または src/menu_data.php）内に配列として保持しています。
 * 「設定値」ではないため、config.php 等への共通化は避けています。
 */
$menuTree = [
    [
        'title' => 'INDEX',
        'url'   => 'index.php',
        'children' => [
            [
                'title' => 'PRESS TRICK',
                'url'   => 'cate1.php',
                'children' => [
                    ['title' => 'NOSE PRESS', 'url' => 'page1.php'],
                    ['title' => 'TAIL PRESS', 'url' => 'page2.php'],
                ],
            ],
            [
                'title' => 'SPIN TRICK',
                'url'   => 'cate2.php',
                'children' => [
                    ['title' => 'FRONTSIDE 180', 'url' => 'page3.php'],
                    ['title' => 'BACKSIDE 180',  'url' => 'page4.php'],
                ],
            ],
        ],
    ],
];

// ----- Smarty 初期化 & レンダリング -----
$smarty = new Smarty();
$smarty->assign('menuTree', $menuTree);
$smarty->assign('currentPage', $scriptName);

$smarty->display('pages/chapter4_8/' . $templateName);
