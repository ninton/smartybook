<?php

/*
 image_resize( $i_src_path, $i_dst_path, $i_maxW = 640, $i_maxH = 640, $i_quality = 75 )
　   1番目の引数は、コピー元のファイルパスです。
　    2番目の引数は、コピー先のファイルパスです。
　    3番目、4番目はコピー先画像の最大枠の幅と高さで、
　 この最大枠に収まるように、コピー元画像の幅と高さの比率を維持したまま縮小します。
　  もともと収まる場合は、同じサイズのままコピーします。
*/
/*
   $type
  1. 幅だけが超えている
   2. 高さだけが超えている
  3. 幅・高さともに超えていて、横方向に縮める必要がある
   4. 幅・高さともに超えていて、縦方向に縮める必要がある
*/

function image_resize($i_src_path, $i_dst_path, $i_maxW = 640, $i_maxH = 640, $i_quality = 75)
{
    $srcW   = 0;
    $srcH   = 0;
    $type   = 0;
    $dstW   = 0;
    $dstH   = 0;
    $src_im = null;
    $dst_im = null;
    $rc     = 0;

    list($srcW, $srcH) = getimagesize($i_src_path);
    if (($srcW <= $i_maxW) && ($srcH <= $i_maxH)) {
        $type = 0;
    } elseif (($i_maxW < $srcW) && ($srcH <= $i_maxH)) {
        $type = 1;
    } elseif (($srcW <= $i_maxW) && ($i_maxH < $srcH)) {
        $type = 2;
    } elseif ($srcH / $i_maxH <= $srcW / $i_maxW) {
        $type = 3;
    } elseif ($srcW / $i_maxW <  $srcH / $i_maxH) {
        $type = 4;
    } else {
        assert(0);
        exit();
    }

    switch ($type) {
        case 0:
            $dstW = $srcW;
            $dstH = $srcH;
            break;

        case 1:
        case 3:
            $dstW = $i_maxW;
            $dstH = $srcH * $dstW / $srcW;
            break;

        case 2:
        case 4:
            $dstH = $i_maxH;
            $dstW = $srcW * $dstH / $srcH;
            break;

        default:
            assert(0);
            exit();
    }
    // printf( "type: %d\n", $type );
    // printf( "dstW: %d, dstH: %d\n", $dstW, $dstH );

    $pi = pathinfo($i_src_path);
    switch (strtolower($pi['extension'])) {
        case 'jpg':
            $src_im = imagecreatefromjpeg($i_src_path);
            break;

        case 'gif':
            $src_im = imagecreatefromgif($i_src_path);
            break;

        case 'png':
            $src_im = imagecreatefrompng($i_src_path);
            break;

        default:
            die();
    }

    $dst_im = imagecreatetruecolor($dstW, $dstH);

    $rc = imagecopyresized($dst_im, $src_im, 0, 0, 0, 0, $dstW, $dstH, $srcW, $srcH);
    imagejpeg($dst_im, $i_dst_path, $i_quality);

    imagedestroy($dst_im);
    imagedestroy($src_im);

    return $rc;
}
