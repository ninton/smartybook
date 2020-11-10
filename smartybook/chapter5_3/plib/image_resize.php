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
    $src_im = null;
    $dst_im = null;

    list($srcW, $srcH) = getimagesize($i_src_path);
    $scaleType = get_scale_type($srcW, $srcH, $i_maxW, $i_maxH);
    list($dstW, $dstH) = scale($scaleType, $srcW, $srcH, $i_maxW, $i_maxH);

    $src_im = image_from_file($i_src_path);
    if ($src_im == null) {
        return false;
    }
    $dst_im = imagecreatetruecolor($dstW, $dstH);

    $retcode = imagecopyresized($dst_im, $src_im, 0, 0, 0, 0, $dstW, $dstH, $srcW, $srcH);
    imagejpeg($dst_im, $i_dst_path, $i_quality);

    imagedestroy($dst_im);
    imagedestroy($src_im);

    return $retcode;
}

function get_scale_type($srcW, $srcH, $i_maxW, $i_maxH)
{
    $type = -1;

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
    }

    return $type;
}

function scale($type, $srcW, $srcH, $i_maxW, $i_maxH)
{
    switch ($type) {
        case 0:
        default:
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
    }

    return array($dstW, $dstH);

}

function image_from_file($i_src_path)
{
    $path_parts = pathinfo($i_src_path);

    $src_im = null;
    switch (strtolower($path_parts['extension'])) {
        case 'jpg':
            $src_im = imagecreatefromjpeg($i_src_path);
            break;

        case 'gif':
            $src_im = imagecreatefromgif($i_src_path);
            break;

        case 'png':
            $src_im = imagecreatefrompng($i_src_path);
            break;
    }

    return $src_im;
}
