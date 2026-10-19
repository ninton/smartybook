<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="utf-8">
<title>{$siteName}</title>
<link href="css/check.css" rel="stylesheet" type="text/css" />
</head>
<body>
<div id="toppage">
  {* ヘッダーはじまり *}
  <div id="header">
    <div id="intro">
      <h1 id="siteTitle"><a href="{$home}"><img src="images/top_title.gif" alt="{$siteName}" /></a></h1>
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
  {* ヘッダーおわり *}
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
