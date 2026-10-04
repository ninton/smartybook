<?php

/**
 *  $_SERVER変数を偽装して、
 *  PEAR::Net_UserAgent_Mobileで、
 *  softbankのウェブコンテンツビューアの端末情報を扱えるようにする
 */

foreach ($_SERVER as $key => $value) {
    if (preg_match('/^HTTP_X_EMULATOR_/', $key)) {
        $jhone_key = preg_replace('/^HTTP_X_EMULATOR_/', 'HTTP_X_JPHONE_', $key);
        $_SERVER[$jhone_key] = $_SERVER[$key];
    }
}
