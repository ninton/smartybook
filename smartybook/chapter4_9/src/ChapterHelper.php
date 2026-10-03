<?php

namespace SmartyBook\Chapter4_9\src;

class ChapterHelper
{
    /**
     * メニューを作る
     * @param list<string> $i_categories
     * @return list<array<string, string>>
     */
    public static function get_menu_arr(array $i_categories): array
    {
        $menu_arr = [];
        foreach ($i_categories as $category) {
            $rcd = [];
            $rcd['title'] = $category;
            $rcd['url'  ] = self::get_contents_url($category);
            $menu_arr[] = $rcd;
        }
        return $menu_arr;
    }

    /**
     * 注目記事を1件選ぶ
     * @param string $i_csv
     * @return list<array<string, string|null>>
     */
    public static function get_featured_arr(string $i_csv): array
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
            $rcd['url'     ] = self::get_contents_url($rcd['category']);

            if ($rcd['image'] != '') {
                if (substr($rcd['image'], 0, 2) == './') {
                    $rcd['image'] = substr($rcd['image'], 2);
                }
                $rcd['image'] = self::get_image_url($rcd['image']);
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
    private static function get_contents_url(string $i_category): string
    {
        return sprintf('%s/contents.php?category=%s', self::get_url(), $i_category);
    }

    /**
     * @param string $i_image
     * @return string
     */
    public static function get_image_url(string $i_image): string
    {
        return sprintf('%s/%s', self::get_url(), $i_image);
    }

    /**
     * chapter4_1/ のURLを求める
     * @return string
     */
    public static function get_url(): string
    {
        static $url;

        if (empty($url)) {
            $scheme = empty($_SERVER['HTTPS']) ? 'http' : 'https';
            $host   = $_SERVER['HTTP_HOST'];
            $url    = "$scheme://$host" . BAT_SRC_WS_DIR;
        }
        return $url;
    }
}
