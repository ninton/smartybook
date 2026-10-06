<?php

declare(strict_types=1);

namespace SmartyBook\chapter5_6\src\SmartyPlugin;

final class MbTruncateModifier
{
    /**
     * Smarty truncate modifier plugin
     *
     * Type:     modifier<br>
     * Name:     mb_truncate<br>
     * Purpose:  Truncate a string to a certain length if necessary,
     *           optionally appending the $etc string.
     * @param string $i_string
     * @param int $i_length
     * @param string $i_etc
     * @return string
     */
    public static function truncate(string $i_string, int $i_length = 40, string $i_etc = '...'): string
    {
        if ($i_length == 0) {
            $result = '';
        } elseif (strlen($i_string) < $i_length) {
            $result = $i_string;
        } else {
            $length = $i_length - min($i_length, strlen($i_etc));
            $result = mb_substr($i_string, 0, $length) . $i_etc;
        }

        return $result;
    }
}
