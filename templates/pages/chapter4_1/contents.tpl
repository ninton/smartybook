<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="utf-8">
<title>詳細ページ | {$siteName}</title>
<link href="css/check.css" rel="stylesheet" type="text/css" />
</head>
<body>
<div id="entrypage">
  {* ヘッダーはじまり *}
  <div id="header">
    <h1 id="siteTitle"><a href="{$homeURL}"><img src="images/page_title.gif" alt="{$siteName}" /></a></h1>
  </div>
  {* ヘッダーおわり *}
  {* メインはじまり *}
  <div id="main">
    {* パンくず *}
    <div id="topicPath"><p><a href="{$homeURL}">Home</a> &gt; {$category|escape}</p></div>
    {* コンテンツはじまり *}
    <div id="contents">
      {* エントリーはじまり *}
{foreach from=$data item="topic" name="article"}
<div class="entry">
    <h2 class="entryTitle">{$topic.title|escape}</h2>
    <div class="contentsBody">
        {if $topic.image}<p><img alt="" src="{$topic.image}" /></p>{/if}
        <p>{$topic.text|escape|nl2br}</p>
    </div>
    <div class="entryDate"><p>{$topic.time|date_format:"%Y-%m-%d %H:%M:%S"}</p></div>
</div>
{foreachelse}
    <p>記事はありません。</p>
{/foreach}
      {* エントリーおわり *}
      {* ページナビゲーションはじまり *}
      <div class="pageNav"><a href="#entrypage">ページトップに戻る</a></div>
      {* ページナビゲーションおわり *}
    </div>
    {* コンテンツおわり *}
  </div>
  {* メインおわり *}
  {* フッターはじまり *}
  <div id="footer">
    <address>
    copyright 2007 {$siteName} All rights reserved.
    </address>
  </div>
  {* フッターおわり *}
</div>
</body>
</html>
