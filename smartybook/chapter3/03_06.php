<?php


class BookMark
{
    public string $title;
    public string $url;
    public string $date;

    /**
     * @param string $title
     * @param string $url
     * @param string $date
     */
    public function __construct($title, $url, $date)
    {
        $this->title = $title; //サイト名
        $this->url   = $url; //サイトURL
        $this->date  = $date; //ブックマークした日付
    }

    /**
     * @return int
     */
    public function getAgo()
    {
        //現在日時からどのくらい時間が経っているか（単位:秒）
        $span = time() - strtotime($this->date);
        //単位を日数に換算して値を返す
        return floor($span / (60 * 60 * 24));
    }
}

use Smarty\Smarty;

require_once('../../vendor/autoload.php');
$smarty = new Smarty();
$smarty->setTemplateDir('templates');
$smarty->setCompileDir('templates_c');
//BookMarkオブジェクトの作成
$bookmark = new BookMark('Google', 'http://www.google.com/', '2006/11/01');
$smarty->assign('bookmark', $bookmark);
$smarty->display('03_06.tpl');
