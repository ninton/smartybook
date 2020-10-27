<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="Content-Style-Type" content="text/css; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="./css/styles.css" />
<title>コンテンツごとにデザインを変える</title>
</head>
<body>
<div id="news">
    <h3>NEWS</h3>
    <ul>
    {foreach from=$data item=item}
        {if $item.category == "news"}
            <li><img src="./images/icon_new.gif" alt="" />　[ {$item.time|date_format:"%Y/%m/%d"} ]　{$item.title|escape}</li>
        {/if}
    {/foreach}
    </ul>
</div>
<div id="diary">
    <h3>STAFF DIARY</h3>
    <ul>
    {foreach from=$data item=item}
        {if $item.category == "diary"}
            <li><img src="./images/{$item.author}.gif" alt="author:{$item.author}" />　{$item.title|escape} <span>{$item.time|date_format:"%Y/%m/%d %H:%M"}</span></li>
        {/if}
    {/foreach}
    </ul>
</div>
</body>
