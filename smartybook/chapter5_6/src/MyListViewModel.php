<?php

declare(strict_types=1);

namespace SmartyBook\chapter5_6\src;

final readonly class MyListViewModel
{
    /**
     * @param list<array{ASIN: string, comment: string, Item?: mixed}> $detail_arr
     */
    public function __construct(
        public string $ListName = '',
        public string $NickName = '',
        public array $detail_arr = [],
    ) {
    }

    /**
     * MyList と Amazon API 応答から表示用 ViewModel を構築するファクトリ
     *
     * @param MyList $myList
     * @param list<array<string, mixed>> $itemArr
     */
    public static function create(MyList $myList, array $itemArr): self
    {
        // ASIN をキーにした検索用マップを作成 (O(N) でマージ)
        $itemMap = array_column($itemArr, null, 'ASIN');

        $combinedDetailArr = array_map(
            static function (array $detail) use ($itemMap): array {
                $asin = (string)($detail['ASIN'] ?? '');
                return array_merge($detail, [
                    'Item' => $itemMap[$asin] ?? null,
                ]);
            },
            $myList->detail_arr,
        );

        return new self(
            $myList->ListName,
            $myList->NickName,
            $combinedDetailArr,
        );
    }
}
