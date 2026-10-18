<?php

namespace App\Csv;

final class CsvEntryReader
{
    /**
     * CSVデータを配列に格納
     * @param string $path
     * @param string $category
     * @return list<array{id: string, category: string, title: string, text: string, time: string, image: string}>
     */
    public static function fetchByCategory(string $path, string $category): array
    {
        $entry_arr = [];
        $handle = fopen($path, 'r');
        while ($arr = fgetcsv($handle, 5000, escape: '')) {
            if ($category == $arr[1]) {
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
