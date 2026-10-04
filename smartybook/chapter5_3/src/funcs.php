<?php

/**
 * 元画像パスを大中小画像パスに置換する
 * @param array{id: string, category: string, title: string, text: string, time: string, image: string} $io_rcd
 * @param int $i_key
 * @param '120'|'240'|'480' $i_imageSizeGroup
 * @return void
 *
 * array_walkのコールバック関数、2つめの引数に配列キーが渡される（が、この関数では使わない）
 */
function replace_entry_image(array &$io_rcd, int $i_key, string $i_imageSizeGroup): void
{
    if ($io_rcd['image']) {
        $fname = basename($io_rcd['image']);
        $io_rcd['image'] = sprintf('images/%s/%s', $i_imageSizeGroup, $fname);
    }
}
