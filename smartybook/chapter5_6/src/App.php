<?php

namespace SmartyBook\chapter5_6\src;

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
     * @return string
     */
    public static function getCmd(): string
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
