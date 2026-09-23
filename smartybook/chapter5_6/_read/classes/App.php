<?php

namespace SmartyBook\chapter5_6\_read\classes;

class App
{
    /**
     * @return void
     */
    public static function sessionStart(): void
    {
        session_start();
        $token = md5(TOKEN_SALT . $_SERVER['HTTP_USER_AGENT'] . $_SERVER['REMOTE_ADDR']);
        if ($_SESSION[APPID]['token'] != $token) {
            session_regenerate_id();
            $_SESSION[APPID] = [];
            $_SESSION[APPID]['token'] = $token;
        }
    }

    /**
     * @param string $i_qs
     * @return void
     */
    public static function redirect($i_qs = ''): void
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
