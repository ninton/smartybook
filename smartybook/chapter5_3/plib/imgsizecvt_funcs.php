<?php

use SmartyBook\chapter5_3\plib\ImageResizer;

// 現在アクセス中のURL
function get_current_url()
{
    $shceme = empty($_SERVER['HTTPS']) ? 'http' : 'https';
    $host = $_SERVER['HTTP_HOST'];
    $path = $_SERVER['REQUEST_URI'];
    $url = "$shceme://$host$path";

    return $url;
}

// 画像一覧データ
//  $rcd_arr[]['fname']
//
//   $rcd_arr[]['src']['path'  ]
//  $rcd_arr[]['src']['width' ]
//  $rcd_arr[]['src']['height']
//
//   $rcd_arr[]['dst'][120]['path'  ]
// $rcd_arr[]['dst'][120]['width' ]
// $rcd_arr[]['dst'][120]['height']
//
//  $rcd_arr[]['dst'][240]['path'  ]
// $rcd_arr[]['dst'][240]['width' ]
// $rcd_arr[]['dst'][240]['height']
//
//  $rcd_arr[]['dst'][480]['path'  ]
// $rcd_arr[]['dst'][480]['width' ]
// $rcd_arr[]['dst'][480]['height']
function proc_image_list()
{
    global  $CFG;
    $rcd_arr = array();
    $arr = glob($CFG['SRCIMG_DIR'] . '*.jpg');
    foreach ($arr as $src) {
        $fname = basename($src);

        $rcd = array();
        $rcd['fname'] = $fname;
        $path = $src;
        $img = array();
        $img['path'] = $path;
        list($img['width'], $img['height']) = getimagesize($path);
        $rcd['src'] = $img;

        foreach (array(120, 240, 480) as $width) {
            $path = $CFG['DSTIMG_DIR'] . "$width/$fname";
            $img = array();
            $img['path'] = $path;
            $img['width'] = '';
            $img['height'] = '';
            if (file_exists($path)) {
                list($img['width'], $img['height']) = getimagesize($path);
            }
            $rcd['dst'][$width] = $img;
        }
        $rcd_arr[] = $rcd;
    }

    return $rcd_arr;
}

/**
 * 元画像から大中小の画像を作る
 * @param $i_fname
 *
 * @SuppressWarnings(PHPMD.StaticAccess)
 */
function proc_image_resize($i_fname)
{
    global  $CFG;

    $fname = basename($i_fname);
    $src_path = $CFG['SRCIMG_DIR'] . $fname;
    if (file_exists($src_path)) {
        foreach (array(120, 240, 480) as $width) {
            $dst_path = $CFG['DSTIMG_DIR'] . "$width/$fname";
            ImageResizer::image_resize($src_path, $dst_path, $width, $width * 1.5);
        }
    }
}
