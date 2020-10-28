<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ja" lang="ja">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>ログイン | 管理画面</title>
<link href="css/check.css" rel="stylesheet" type="text/css" />
</head>
<body>
<div id="entrypage">
	<!-- ヘッダーはじまり -->
	<div id="header">
		<h1 id="siteTitle"><a href="{$admin}"><img src="images/system_title.gif" alt="ログイン | 管理画面" border="0" /></a></h1>
	</div>
	<!-- ヘッダーおわり -->
	<!-- メインはじまり -->
	<div id="main">
		<div id="navigation"><p><a href="{$home}">サイト閲覧</a> | 管理画面</p></div>
	<!-- 情報パネルはじまり -->
	<div class="panel">
		<div class="header">
			<h2>管理画面ログイン</h2>
		</div>
		<div class="contents">
			{if $errormsg neq ""}
			<p class="message">{$errormsg}</p>
			{/if}
			{login_form self="$self" username=$username}
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
