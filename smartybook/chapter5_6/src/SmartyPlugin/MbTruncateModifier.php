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
     * @param string $string
     * @param int $length
     * @param string $etc
     * @return string
     */
    public static function truncate(string $string, int $length = 40, string $etc = '...'): string
    {
        if ($length == 0) {
            $result = '';
        } elseif (strlen($string) < $length) {
            $result = $string;
        } else {
            $length = $length - min($length, strlen($etc));
            $result = mb_substr($string, 0, $length) . $etc;
        }

        return $result;
    }
}
