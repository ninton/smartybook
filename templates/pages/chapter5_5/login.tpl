<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="utf-8">
<title>ログイン | 管理画面</title>
<link href="css/check.css" rel="stylesheet" type="text/css" />
</head>
<body>
<div id="entrypage">
  {* ヘッダーはじまり *}
  <div id="header">
    <h1 id="siteTitle"><a href="{$adminURL}"><img src="images/system_title.gif" alt="ログイン | 管理画面" /></a></h1>
  </div>
  {* ヘッダーおわり *}
  {* メインはじまり *}
  <div id="main">
    <div id="navigation"><p><a href="{$home}">サイト閲覧</a> | 管理画面</p></div>
  {* 情報パネルはじまり *}
  <div class="panel">
    <div class="header">
      <h2>管理画面ログイン</h2>
    </div>
    <div class="contents">
      {if $errorMessage neq ""}
      <p class="message">{$errorMessage}</p>
      {/if}
      {login_form self="$self" username=$username}
    </div>
  </div>
  {* 情報パネルおわり *}
  {* ページナビゲーションはじまり *}
  <div class="pageNav"><a href="#entrypage">ページトップに戻る</a></div>
  {* ページナビゲーションおわり *}
  </div>
  {* メインおわり *}
  {* フッターはじまり *}
  <div id="footer">
    <address>
    copyright {$siteName} All rights reserved.
    </address>
  </div>
  {* フッターおわり *}
</div>
</body>
</html>
