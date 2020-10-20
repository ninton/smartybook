<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ja" lang="ja">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>{$siteName}</title>
<link href="css/check.css" rel="stylesheet" type="text/css" />
</head>
<body>
<div id="toppage">
	<!-- ヘッダーはじまり -->
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
	<!-- ヘッダーおわり -->
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