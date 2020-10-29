<?php

class BookMark
{
    function BookMark($title, $url, $date)
    {
        $this->title = $title; //サイト名
        $this->url = $url; //サイトURL
        $this->date = $date; //ブックマークした日付
    }
    function getAgo()
    {
        //現在日時からどのくらい時間が経っているか（単位:秒）
        $span = time() - strtotime($this->date);
        //単位を日数に換算して値を返す
        return floor($span / (60 * 60 * 24));
    }
}

require_once("../smarty/libs/Smarty.class.php");
$smarty = new Smarty();
$smarty->template_dir = "templates";
$smarty->compile_dir = "templates_c";
//BookMarkオブジェクトの作成
$bookmark = new BookMark("Google", "http://www.google.com/", "2006/11/01");
$smarty->assign("bookmark", $bookmark);
$smarty->display("03_06.tpl");
