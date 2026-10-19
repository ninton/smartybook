<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="utf-8">
<title>Smarty for Designers</title>
<link rel="stylesheet" href="css/styles.css" type="text/css" />
</head>
<body>
<div id="wrapper">

{block name="heading"}{/block}

{include file="partials/chapter4_8/menubox.tpl"}

<div id="contents">
{block name="content"}{/block}
</div>

</div>
<script type="module" src="js/main.js"></script>
</body>
</html>
