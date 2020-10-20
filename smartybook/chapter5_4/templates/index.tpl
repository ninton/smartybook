<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ja" lang="ja">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>{$siteName}</title>
<link href="css_05_04/check.css" rel="stylesheet" type="text/css" />
</head>
<body>
<div id="portalPage">
	<!-- ヘッダーはじまり -->
	<div id="header">
		<h1 id="siteTitle"><a href="{$home}">{$siteName} : {$smarty.now}</a></h1>
		<h2 id="siteDescription">{$siteDescription}</h2>
	</div>
	<!-- ヘッダーおわり -->
	<!-- メインはじまり -->
	<div id="main" class="clearfix">
		<!-- Twitterはじまり -->
		<div id="twitter">
			<h3 class="cornerTitle">Twitter</h3>
			<div id="twitter1">
				<div id="prof">
					<p><img alt="プロフィール画像" src="{$aTwitter[0]->user->profile_image_url}" /><br /><a href="http://twitter.com/{$aTwitter[0]->user->screen_name}">{$aTwitter[0]->user->screen_name}</a></p>
				</div>
			</div>
			<div id="twitter2">
				<div class="status">
				{section loop=$aTwitter name="twitter" max="10"}
					<div class="statusBody">
						<p>{$aTwitter[twitter]->text|escape|nl2br}</p>
					</div>
				{sectionelse}
					<div class="statusBody">
						<p>発言はありません。</p>
					</div>
				{/section}
				</div>
			</div>
		</div>
		<!-- Twitterおわり -->
		<!-- Photoはじまり -->
		<div id="photo">
			<h3 class="cornerTitle">Photo</h3>
			
			{section loop=$picture name="pct" max="2"}
			<div class="entry">
				<h4>{$picture[pct].title|escape}</h4>
				<div class="entryBody">
					{if $picture[pct].image}<p><img alt="{$picture[pct].title|escape}" src="{$picture[pct].image}" /></p>{/if}
					<p>{$picture[pct].text|escape|nl2br}</p>
				</div>
				<div class="entryDate"><p>{$picture[pct].time|date_format:"%Y-%m-%d %H:%M:%S"}</p></div>
			</div>
			{sectionelse}
			<div class="entry">
				<div class="entryBody">
					<p>記事はありません。</p>
				</div>
			</div>
			{/section}
		</div>
		<!-- Photoおわり -->
		<!-- Linkはじまり -->
		<div id="link">
			<h3 class="cornerTitle">Link</h3>
			<ul>
				{foreach from=$data item="link" name="link"}
				{if $link.category eq "Link"}
				<li><a href="{$link.text|escape|nl2br}">{$link.title|escape}</a></li>
				{/if}
				{foreachelse}
				<li>リンクはありません。</li>
				{/foreach}
			</ul>
		</div>
		<!-- Linkおわり -->
	</div>
	<!-- メインおわり -->
	<!-- フッターはじまり -->
	<div id="footer">
		<address>
		copyright 2008 {$siteName} All rights reserved.
		</address>
	</div>
	<!-- フッターおわり -->
</div>
</body>
</html>