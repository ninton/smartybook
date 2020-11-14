<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ja" lang="ja">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>{$siteName}</title>
<link href="css/check.css" rel="stylesheet" type="text/css" />
</head>
<body>
<div id="toppage">

	<!-- ヘッダーはじまり
	<div id="header">
		<div id="intro">
			<h1 id="siteTitle"><a href="{$home}"><img src="images/top_title.gif" alt="{$siteName}" border="0" /></a></h1>
			<div id="index">
				<h2 class="categories"><img alt="カテゴリー" src="images/top_menu_categories.gif" /></h2>
{section name="menu" loop=$categories}
    {if $smarty.section.menu.first}<p class="indexMenuArea">{/if}
    <a href="contents.php?category={$categories[menu]}">{$categories[menu]}</a>
    {if !$smarty.section.menu.last}
         / 
    {else}
        </p>
    {/if}
{/section}
			</div>
		</div>
	</div>
	ヘッダーおわり -->

	<!-- ヘッダーはじまり -->
	<div id="header">
		<h1 id="siteTitle"><a href="{$home}"><img src="images/page_title.gif" alt="{$siteName}" border="0" /></a></h1>
	</div>
	<!-- ヘッダーおわり -->

	<!-- メインはじまり -->
	<div id="main" class="clearfix">
		<!-- パンくず -->
		<div id="topicPath"><p>Home</p></div>
		<!-- コンテンツはじまり -->
		<div id="contents">
			<!-- エントリーはじまり -->
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
<div class="entry">
    <div class="contentsBody"><p>記事はありません。</p></div>
</div>
{/foreach}
			<!-- エントリーおわり -->
			<!-- ページナビゲーションはじまり -->
			<div class="pageNav"><a href="#toppage">ページトップに戻る</a></div>
			<!-- ページナビゲーションおわり -->
		</div>
		<!-- コンテンツおわり -->
		<div id="sideArea1">
			<h2 class="sideArea1Title">メニュー</h2>
			<ul>
			{section name="menu" loop=$categories}
    			<li><a href="contents.php?category={$categories[menu]}">{$categories[menu]}</a></li>
			{/section}
			</ul>
			<h2 class="sideArea1Title">バナー</h2>
			<p>
				{insert name="noticeText2" siteName=$siteName assign="myInsert"}
				{$myInsert}
			</p>
		</div>

	</div>

	<!-- メインおわり -->
	<!-- フッターはじまり -->
	<div id="footer">
		<address>
		copyright 2007 {$siteName} All rights reserved.
		</address>
	</div>
	<!-- フッターおわり -->
</div>
</body>
</html>