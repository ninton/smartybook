<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="Content-Style-Type" content="text/css; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="./css/styles.css" />
<title>時間毎にヘッダーを変える</title>
</head>
<body>
<div id="wrapper">
<div id="header">
{if $hour >= "6" && $hour < "18"}
    <h1><img src="./images/title_day.gif" width="650" height="110" alt="Smarty for Designers" /></h1>
{else}
    <h1><img src="./images/title_night.gif" width="650" height="110" alt="Smarty for Designers" /></h1>
{/if}
<!-- p>現在{$hour}時です。</p -->
</div>
<div id="gMenu">
    <ul>
        <li><a href="#">HOME</a></li>
        <li class="select"><a href="#">HOW TO</a></li>
        <li><a href="#">GEAR</a></li>
        <li><a href="#">SHOPPING</a></li>
        <li><a href="#">ABOUT</a></li>
    </ul>
</div>
<div id="contents">
    <div id="main">
        <h2>HOW TO</h2>
        <p>このコンテンツでは、スノーボードに関するHOW TOを掲載しています。</p>
        <h3>あなたはレギュラー・それともグーフィー？</h3>
        <p>左足が前に来るスタンスをレギュラー・スタンスといいます。逆に、右足が前に来るスタンスをグーフィースタンスと呼びます。あなたはどちらのスタンスでしょうか？</p>
        <p>階段やエスカレーターなどの乗り降りで、無意識に出るはじめの一歩が前足になると言われています。</p>
        <h3>何はともあれ、まずはスケーティング!</h3>
        <p>スケーティングとは、後ろ足のバインディングを外して片足だけで滑って進む基本的なテクニックです。これができないと、リフトの乗り降りで非常に困りますし、危険です。まずは、リフトに乗る前に充分にスケーティングの練習をして、ボードで滑る感覚を身に付けましょう！</p>
    </div>
    <div id="subMenu">
        <h3>基本テクニック</h3>
        <ul>
            <li><a href="#">オーリー</a></li>
            <li><a href="#">ノーリー</a></li>
            <li><a href="#">フロントサイド180</a></li>
            <li><a href="#">バックサイド180</a></li>
            <li><a href="#">ノーズマニュアル</a></li>
            <li><a href="#">テールマニュアル</a></li>
        </ul>
        <h3>中級者テクニック</h3>
        <ul>
            <li><a href="#">ノーズプレス</a></li>
            <li><a href="#">テールプレス</a></li>
            <li><a href="#">フロントサイド360</a></li>
            <li><a href="#">バックサイド360</a></li>

        </ul>
    </div>
</div>
<div id="footer">
    <p>Copyright 2008 Smarty for Designers All rights reserved.</p>
</div>
</div>
</body>
