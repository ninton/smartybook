<?php

/**
 * CSVデータを配列に格納
 * @param string $i_path
 * @param string $i_category
 * @return list<array{id: string, category: string, title: string, text: string, time: string, image: string}>
 */
function get_entry_arr($i_path, $i_category): array
{
    $entry_arr = [];
    $handle = fopen($i_path, 'r');
    while ($arr = fgetcsv($handle, 5000, ',', escape: '')) {
        if ($i_category == $arr[1]) {
            $rcd = [];
            $rcd['id'      ] = $arr[0];
            $rcd['category'] = $arr[1];
            $rcd['title'   ] = $arr[2];
            $rcd['text'    ] = $arr[3];
            $rcd['time'    ] = $arr[4];
            $rcd['image'   ] = $arr[5];

            $entry_arr[] = $rcd;
        }
    }
    fclose($handle);

    return $entry_arr;
}

/**
 * 元画像パスを大中小画像パスに置換する
 * @param array{id: string, category: string, title: string, text: string, time: string, image: string} $io_rcd
 * @param int $i_key
 * @param '120'|'240'|'480' $i_imageSizeGroup
 * @return void
 *
 * array_walkのコールバック関数、2つめの引数に配列キーが渡される（が、この関数では使わない）
 */
function replace_entry_image(&$io_rcd, $i_key, $i_imageSizeGroup): void
{
    if ($io_rcd['image']) {
        $fname = basename($io_rcd['image']);
        $io_rcd['image'] = sprintf('images/%s/%s', $i_imageSizeGroup, $fname);
    }
}
