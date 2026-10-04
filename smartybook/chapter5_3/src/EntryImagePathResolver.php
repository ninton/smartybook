<?php

namespace SmartyBook\chapter5_3\src;

final class EntryImagePathResolver
{
    /**
     * 元画像パスを大中小画像パスに置換する
     *
     * $i_imageSizeGroup = '480' の場合
     * $entry['image'] = './images/005.jpg'
     * ↓
     * $entry['image'] = 'images/480/005.jpg' 実際の動作結果
     *
     * @note 元々の意図 './images/480/005.jpg' へ置換することだった可能性がある
     *
     * @param array{id: string, category: string, title: string, text: string, time: string, image: string} $io_rcd
     * @param int $i_key
     * @param '120'|'240'|'480' $i_imageSizeGroup
     * @return void
     *
     * array_walkのコールバック関数、2つめの引数に配列キーが渡される（が、この関数では使わない）
     */
    public static function resolve(array &$io_rcd, int $i_key, string $i_imageSizeGroup): void
    {
        if ($io_rcd['image']) {
            $fname = basename($io_rcd['image']);
            $io_rcd['image'] = sprintf('images/%s/%s', $i_imageSizeGroup, $fname);
        }
    }
}
