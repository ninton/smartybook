<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ja" lang="ja">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>入力内容の確認 | 管理画面</title>
<link href="css/check.css" rel="stylesheet" type="text/css" />
</head>
<body>
<div id="entrypage">
	<!-- ヘッダーはじまり -->
	<div id="header">
		<h1 id="siteTitle"><a href="{$admin}"><img src="images/system_title.gif" alt="入力内容の確認 | 管理画面" border="0" /></a></h1>
	</div>
	<!-- ヘッダーおわり -->
	<!-- メインはじまり -->
	<div id="main">
		<div id="navigation"><p><a href="{$home}">サイト閲覧</a> | 管理画面</p></div>
	<!-- 情報パネルはじまり -->
	<div class="panel">
		<div class="header">
			<h2>投稿内容の確認</h2>
		</div>
		<div class="contents">
			<p class="message">下記の内容で送信します。よろしければ「書き込む」ボタンをおしてください</p>
			<!-- フォームはじまり -->
			<form action="complete.php" method="post" name="cmsForm" target="_top" id="cmsForm" class="submitForm">
				<fieldset>
				<table cellspacing="0">
					<tr>
						<th> 記事のカテゴリー
						</th>
						<td>{$category|default:'<span class="attention">選択されていません</span>'}
						</td>
					</tr>
					<tr>
						<th> タイトル
						</th>
						<td>{$title|escape|default:'<span class="attention">未入力です</span>'}
						</td>
					</tr>
					<tr>
						<th> 本文
						</th>
						<td>{$contents|escape|nl2br|default:'<span class="attention">未入力です</span>'}
						</td>
					</tr>
					<tr>
						<th> 日付け
						</th>
						<td>{$date|date_format:"%Y-%m-%d %H:%M:%S"}</td>
					</tr>
					<tr>
						<th> 画像
						</th>
						<td>
                            {if $imageFile == ""}
                                ファイルは指定されていません
                            {else}
                                <img src="{$imageFile}" alt="" />
                            {/if}
						</td>
					</tr>
					<tr>
						<th>
							<input type="hidden" name="category" value="{$category}" />
							<input type="hidden" name="title" value="{$title|escape}" />
							<input type="hidden" name="contents" value="{$contents|escape}" />
							<input type="hidden" name="date" value="{$date}" />
							<input type="hidden" name="image" value="{$imageFile}" /></th>
						<td>
                            {if $category != "" && $title != "" && $contents != ""}
                                <input type="image" src="./images/form_btn_submit.gif" alt="Send" value="send" width="94" height="24" class="submitBtn" />
                            {/if}
                            <a href="javascript:onclick=history.back()"><img src="./images/form_btn_back.gif" alt="戻る" width="94" height="24" /></a>
						</td>
					</tr>
				</table>
				</fieldset>
			</form>
			<!-- フォームおわり -->
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
		copyright 2007 {$siteName} All rights reserved.
		</address>
	</div>
	<!-- フッターおわり -->
</div>
</body>
</html>