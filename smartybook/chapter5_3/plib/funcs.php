<?php

// CSVデータを配列に格納
function get_entry_arr($i_path, $i_category)
{
    $entry_arr = array();
    $handle = fopen($i_path, "r");
    while ($arr = fgetcsv($handle, 5000, ",")) {
        if ($i_category == $arr[1]) {
            $rcd = array();
            $rcd["id"      ] = $arr[0];
            $rcd["category"] = $arr[1];
            $rcd["title"   ] = $arr[2];
            $rcd["text"    ] = $arr[3];
            $rcd["time"    ] = $arr[4];
            $rcd["image"   ] = $arr[5];

            $entry_arr[] = $rcd;
        }
    }
    fclose($handle);

    return $entry_arr;
}

// 元画像パスを大中小画像パスに置換する
/**
 * @param array $io_rcd
 * @param string $i_key
 * @param string $i_imageSizeGroup
 *
 * array_walkのコールバック関数、2つめの引数に配列キーが渡される（が、この関数では使わない）
 * @SuppressWarnings(PHPMD.UnusedFormalParameter)
 */
function replace_entry_image(&$io_rcd, $i_key, $i_imageSizeGroup)
{
    if ($io_rcd['image']) {
        $fname = basename($io_rcd['image']);
        $io_rcd['image'] = sprintf('images/%s/%s', $i_imageSizeGroup, $fname);
    }
}
