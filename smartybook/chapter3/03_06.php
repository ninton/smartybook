<?php


class BookMark
{
    public string $title;
    public string $url;
    public string $date;

    /**
     * @param string $title サイト名
     * @param string $url サイトURL
     * @param string $date ブックマークした日付
     */
    public function __construct(string $title, string $url, string $date)
    {
        $this->title = $title;
        $this->url   = $url;
        $this->date  = $date;
    }

    /**
     * 現在日時からどのくらい日数が経過しているかを取得します。
     * @return int 経過日数
     */
    public function getAgo(): int
    {
        //現在日時からどのくらい時間が経っているか（単位:秒）
        $span = time() - strtotime($this->date);
        //単位を日数に換算して値を返す
        return (int)floor($span / (60 * 60 * 24));
    }
}

use Smarty\Smarty;

require_once '../../vendor/autoload.php';
$smarty = new Smarty();
$smarty->setTemplateDir('templates');
$smarty->setCompileDir('templates_c');
//BookMarkオブジェクトの作成
$bookmark = new BookMark('Google', 'http://www.google.com/', '2006/11/01');
$smarty->assign('bookmark', $bookmark);
$smarty->display('03_06.tpl');
