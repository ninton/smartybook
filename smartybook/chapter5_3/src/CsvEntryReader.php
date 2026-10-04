<?php

namespace SmartyBook\chapter5_3\src;

final class CsvEntryReader
{
    /**
     * CSVデータを配列に格納
     * @param string $i_path
     * @param string $i_category
     * @return list<array{id: string, category: string, title: string, text: string, time: string, image: string}>
     */
    public static function fetchByCategory(string $i_path, string $i_category): array
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
}
