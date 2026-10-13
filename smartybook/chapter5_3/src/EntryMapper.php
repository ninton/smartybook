<?php

declare(strict_types=1);

namespace SmartyBook\chapter5_3\src;

final readonly class EntryMapper
{
    /**
     * 画像パスを解決し、画像の存在状態を判定した上で、ビュー用の配列に変換する
     *
     * @param array{title: string, text: string, time: string, image: string} $entry CMSから取得したエントリ配列
     * @param string $baseDir 画像パス解決の基準ディレクトリ
     * @return array{title: string, text: string, time: string, image: string, image_status: string} ビュー用のエントリ配列
     */
    public static function toViewModel(array $entry, string $baseDir): array
    {
        $imagePath = $entry['image'] ?? '';
        $imageStatus = 'none';

        if ($imagePath !== '') {
            if (file_exists($baseDir . '/' . $imagePath)) {
                $imageStatus = 'exists';
            } else {
                $imageStatus = 'missing';
            }
        }

        return [
            'title' => $entry['title'],
            'text' => $entry['text'],
            'time' => $entry['time'],
            'image' => $imagePath,
            'image_status' => $imageStatus,
        ];
    }
}
