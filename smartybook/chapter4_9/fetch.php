<?php

require_once('./fetch_ini.php');
// メニュー
$menu_arr = get_menu_arr($categories);
// 注目記事
$featured_arr = get_featured_arr(BAT_SRC_DIR . "/$csv");
$smarty = new Smarty();
$smarty->plugins_dir[] = __DIR__;
$smarty->assign('menu_arr', $menu_arr);
$smarty->assign('featured_arr', $featured_arr);
$buf = $smarty->fetch('menu.tpl');
file_put_contents('./html/menu.html', $buf);
print $buf;
$buf = $smarty->fetch('featured.tpl');
file_put_contents('./html/featured.html', $buf);
print $buf;


// メニューを作る
function get_menu_arr($i_categories)
{
    $menu_arr = array();
    foreach ($i_categories as $category) {
        $rcd = array();
        $rcd['title'] = $category;
        $rcd['url'  ] = get_contents_url($category);
        $menu_arr[] = $rcd;
    }
    return $menu_arr;
}

// 注目記事を1件選ぶ
function get_featured_arr($i_csv)
{
    $cms_arr = array();
    $handle = fopen($i_csv, 'r');
    while ($arr = fgetcsv($handle, 10000)) {
        $rcd = array();
        $rcd['id'      ] = $arr[0];
        $rcd['category'] = $arr[1];
        $rcd['title'   ] = $arr[2];
        $rcd['comment' ] = $arr[3];
        $rcd['time'    ] = $arr[4];
        $rcd['image'   ] = $arr[5];
        $rcd['url'     ] = get_contents_url($rcd['category']);

        if ($rcd['image'] != '') {
            if (substr($rcd['image'], 0, 2) == './') {
                $rcd['image'] = substr($rcd['image'], 2);
            }
            $rcd['image'] = get_image_url($rcd['image']);
        }
        $cms_arr[] = $rcd;
    }
    fclose($handle);
//ランダムに1件選ぶ
    $offset = array_rand($cms_arr, 1);
    $featured_arr = array_slice($cms_arr, $offset, 1);
    return $featured_arr;
}

function get_contents_url($i_category)
{
    return sprintf("%s/contents.php?category=%s", get_url(), $i_category);
}

function get_image_url($i_image)
{
    return sprintf("%s/%s", get_url(), $i_image);
}

// chapter4_1/ のURLを求める
function get_url()
{
    static $url;

    if (empty($url)) {
        $scheme = empty($_SERVER['HTTPS']) ? 'http' : 'https';
        $host   = $_SERVER['HTTP_HOST'];
        $url    = "$scheme://$host" . BAT_SRC_WS_DIR;
    }
    return $url;
}
