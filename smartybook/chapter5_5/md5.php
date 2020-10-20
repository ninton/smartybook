<?php
// 暗号化したい文字列を格納
$value = "guest";
// MD5化
$md5edValue = md5($value);
// MD5化した文字列を表示
echo $md5edValue;
?>
