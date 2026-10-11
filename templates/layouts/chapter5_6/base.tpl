<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ja" lang="ja">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <meta http-equiv="Content-Style-Type" content="text/css; charset=utf-8" />
  <meta http-equiv="Content-Script-Type" content="text/javascript; charset=utf-8" />
  <link rel="stylesheet" href="./css/styles.css" type="text/css" />
{* ▼ ページごとにhead内へ追記できる拡張ポイントを作る *}
{block name="head"}{/block}
  <title>Smarty for Designers</title>
</head>
<body>
  <div id="wrapper">
  <div id="alpha">
    <p id="siteTitle">Smarty for Designers</p>
  </div>
  <div id="beta">
{block name="content"}{/block}
  </div>
{include file="partials/chapter5_6/footer.tpl"}
  </div>
</body>
</html>
