<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ja" lang="ja">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>投稿完了 | 管理画面</title>
<link href="css/check.css" rel="stylesheet" type="text/css" />
</head>
<body>
<div id="entrypage">
	<!-- ヘッダーはじまり -->
	<div id="header">
		<h1 id="siteTitle"><a href="{$admin}"><img src="images/system_title.gif" alt="投稿完了 | 管理画面" border="0" /></a></h1>
	</div>
	<!-- ヘッダーおわり -->
	<!-- メインはじまり -->
	<div id="main">
		<div id="navigation"><p><a href="{$home}">サイト閲覧</a> | 管理画面</p></div>
	<!-- 情報パネルはじまり -->
	<div class="panel">
		<div class="header">
			<h2>投稿が完了しました</h2>
		</div>
		<div class="contents">
            <p class="message">
            {if $flag}
			    記事が保存されました。<br />続いて入力を行う場合は、「入力フォームへ戻る」ボタンを押してください。
            {else}
                <span class="attention">書き込みに失敗しました。</span>
            {/if}
            </p>
			<p><a href="{$admin}"><img src="./images/form_btn_end.gif" alt="戻る" width="155" height="24" /></a></p>
		</div>
	</div>
	<!-- 情報パネルおわり -->
	<!-- ページナビゲーションはじまり -->
	<div class="pageNav"><a href="#entrypage">ページトップに戻る</a></div>
	<!-- ページナビゲーションおわり -->
	</div>
	<!-- メインおわり -->
	<!-- フッターはじまり -->
	<div id="footer">
		<address>
		copyright {$siteName} All rights reserved.
		</address>
	</div>
	<!-- フッターおわり -->
</div>
</body>
</html>
