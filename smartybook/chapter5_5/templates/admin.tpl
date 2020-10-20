<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ja" lang="ja">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>入力フォーム | 管理画面</title>
<link href="css/check.css" rel="stylesheet" type="text/css" />
</head>
<body>
<div id="entrypage">
	<!-- ヘッダーはじまり -->
	<div id="header">
		<h1 id="siteTitle"><a href="{$admin}"><img src="images/system_title.gif" alt="入力フォーム | 管理画面" border="0" /></a></h1>
	</div>
	<!-- ヘッダーおわり -->
	<!-- メインはじまり -->
	<div id="main">
		<div id="navigation"><p><a href="{$home}">サイト閲覧</a> | 管理画面</p></div>
	<!-- 情報パネルはじまり -->
	<div class="panel">
		<div class="header">
			<h2>記事の投稿</h2>
		</div>
		<div class="contents">
			<p class="message">下記フォームに記事の内容を投稿してください / <a href="admin.php?lo=ok">ログアウトする</a></p>
			<!-- フォームはじまり -->
			<form action="confirm.php" method="post" enctype="multipart/form-data" name="cmsForm" target="_top" id="cmsForm" class="submitForm">
				<fieldset>
				<table cellspacing="0">
					<tr>
						<th> <label for="category">記事のカテゴリーを選択</label>
						</th>
						<td>{html_options name="category" values=$categories output=$categories selected="Study"}
                        </td>
					</tr>
					<tr>
						<th> <label for="title">タイトル</label>
						</th>
						<td><input name="title" type="text" class="oneLineInput" id="title" size="30" />
						</td>
					</tr>
					<tr>
						<th> <label for="contents">本文</label>
						</th>
						<td><textarea class="txt" name="contents" id="contents" cols="30" rows="10"></textarea>
						</td>
					</tr>
					<tr>
						<th> <label for="date">日付け</label>
						</th>
						<td>{$smarty.now|date_format:"%Y-%m-%d %H:%M:%S"}
							<input type="hidden" name="date" id="date" value="{$smarty.now}" />
						</td>
					</tr>
					<tr>
						<th> <label for="image">画像</label>
						</th>
						<td><input name="image" id="image" type="file" class="oneLineInput" size="30" />
						</td>
					</tr>
					<tr>
						<th>&nbsp;</th>
						<td><input type="image" src="./images/form_btn_confirm.gif" alt="Send" value="send" width="94" height="24" />
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
