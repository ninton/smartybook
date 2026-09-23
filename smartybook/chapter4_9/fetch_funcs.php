<?php

/**
 * メニューを作る
 * @param list<string> $i_categories
 * @return list<array<string, string>>
 */
function get_menu_arr($i_categories): array
{
    $menu_arr = [];
    foreach ($i_categories as $category) {
        $rcd = [];
        $rcd['title'] = $category;
        $rcd['url'  ] = get_contents_url($category);
        $menu_arr[] = $rcd;
    }
    return $menu_arr;
}

/**
 * 注目記事を1件選ぶ
 * @param string $i_csv
 * @return list<array<string, string|null>>
 */
function get_featured_arr($i_csv): array
{
    $cms_arr = [];
    $handle = fopen($i_csv, 'r');
    while ($arr = fgetcsv($handle, 10000, escape: '')) {
        $rcd = [];
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

/**
 * @param string $i_category
 * @return string
 */
function get_contents_url($i_category): string
{
    return sprintf('%s/contents.php?category=%s', get_url(), $i_category);
}

/**
 * @param string $i_image
 * @return string
 */
function get_image_url($i_image): string
{
    return sprintf('%s/%s', get_url(), $i_image);
}

/**
 * chapter4_1/ のURLを求める
 * @return string
 */
function get_url(): string
{
    static $url;

    if (empty($url)) {
        $scheme = empty($_SERVER['HTTPS']) ? 'http' : 'https';
        $host   = $_SERVER['HTTP_HOST'];
        $url    = "$scheme://$host" . BAT_SRC_WS_DIR;
    }
    return $url;
}
