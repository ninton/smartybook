<?php
/**
 * Smarty plugin
 * @package Smarty
 * @subpackage plugins
 */


/**
 * Smarty truncate modifier plugin
 *
 * Type:     modifier<br>
 * Name:     mb_truncate<br>
 * Purpose:  Truncate a string to a certain length if necessary,
 *           optionally appending the $etc string.
 * @author   Aoki Makoto <gzl03577@nifty.com>
 * @param string
 * @param integer
 * @param string
 * @return string
 */
function smarty_modifier_mb_truncate($i_string, $i_length = 40, $i_etc = '...')
{
	$string = '';
	
    if ($i_length == 0) {
		$string = '';
	} else if (strlen($i_string) < $i_length) {
		$string = $i_string;
    } else {
        $length = $i_length - min($i_length, strlen($i_etc));
		$string = mb_substr($i_string, 0, $length) . $i_etc;
    }
    
    return $string;
}

/* vim: set expandtab: */

?>
