{include file="head_`$smarty.server.carrier_ua`.tpl"}
{config_load file="style.conf"}
{config_load file="emoji.conf"}
{assign var=category value=$smarty.get.category}
{assign var=cate_icon value="icon_$category"}
<title>{$category|escape:html} | {$siteName|escape:html}</title>
</head>
<body style="{#BODY_STYLE#}">

<div style="{#H1_STYLE#}">
<h1>Smarty+{$smarty.server.carrier_ua|escape:html}</h1>
</div>


<div>
{$smarty.config.$cate_icon} {$entry.title|escape:html}<br />
{if $entry.image}
  {if file_exists($entry.image)}
    {html_image file=$entry.image}<br />
  {else}
    <br />
    --画像準備中--<!-- {$entry.image|escape:html} --><br />
    <br />
  {/if}
{/if}
{#icon_note#}{$entry.text|escape:html|nl2br}
</div>
<div>{#icon_clock#}{$entry.time|date_format:"%Y-%m-%d %H:%M:%S"}</div>

<div>
<br />
{if $Pager->ExPreviousPageLink}<a href="{$Pager->ExPreviousPageLink}">≪前</a>&nbsp;{/if}
{if $Pager->ExNextPageLink}<a href="{$Pager->ExNextPageLink}">次≫</a>&nbsp;{/if}
{$smarty.config.$cate_icon}{$category|escape:html} {$Pager->getCurrentPageID()|escape:html}/{$Pager->numPages()|escape:html}
<br />
□<a href="{$home|escape:html}">Home</a>
</div>

<hr style="{#HR_STYLE#}" />
<div>
copyright 2007<br />
{$siteName|escape:html}<br />
All rights reserved.
</div>

</body>
</html>

