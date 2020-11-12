<?php

namespace SmartyBook\chapter5_6\_read\classes;

/**
 *  @author MW web studio, Aoki Makoto, 2007-12
 */
class App
{
    public static function sessionStart()
    {
        session_start();
        $token = md5(TOKEN_SALT . $_SERVER['HTTP_USER_AGENT'] . $_SERVER['REMOTE_ADDR']);
        if ($_SESSION[APPID]['token'] != $token) {
            session_regenerate_id();
            $_SESSION[APPID] = array();
            $_SESSION[APPID]['token'] = $token;
        }
    }

    public static function redirect($i_qs = '')
    {
        $scheme = empty($_SERVER['HTTPS']) ? 'http' : 'https';
        $host = $_SERVER['HTTP_HOST'];
        $path = $_SERVER['REQUEST_URI'];
        $url = "$scheme://$host$path$i_qs";
        header("Location: $url");
    }

    /**
     * @return string
     *
     * @SuppressWarnings(PHPMD.ElseExpression)
     */
    public static function getCmd()
    {
        $cmd_arr = preg_grep('/^cmd.*/', array_keys($_POST));
        $cmd_arr = array_values($cmd_arr);
        if (0 < count($cmd_arr)) {
            $cmd = $cmd_arr[0];
        } else {
            $cmd = '';
        }

        return $cmd;
    }
}
