<?php

declare(strict_types=1);

use SmartyBook\chapter5_3\src\EntryMapper;

test('toViewModel 画像の存在状態を判定し、エントリの内容を保持する', function (string $image, string $imageStatus) {
    $temporaryDirectory = sys_get_temp_dir() . '/entry-mapper-' . bin2hex(random_bytes(8));
    mkdir($temporaryDirectory);
    $imageFile = $temporaryDirectory . '/photo.jpg';

    try {
        touch($imageFile);
        $entry = [
            'title' => 'テスト記事',
            'text' => "<p>本文 & 内容</p>\n次の行",
            'time' => '2026-10-13 12:34:56',
            'image' => $image,
        ];

        $actual = EntryMapper::toViewModel($entry, $temporaryDirectory);

        expect($actual)->toBe([
            'title' => 'テスト記事',
            'text' => "<p>本文 & 内容</p>\n次の行",
            'time' => '2026-10-13 12:34:56',
            'image' => $image,
            'image_status' => $imageStatus,
        ]);
    } finally {
        if (file_exists($imageFile)) {
            unlink($imageFile);
        }
        rmdir($temporaryDirectory);
    }
})->with([
    '画像未指定' => ['', 'none'],
    '画像が存在する' => ['photo.jpg', 'exists'],
    '画像が存在しない' => ['missing.jpg', 'missing'],
]);
