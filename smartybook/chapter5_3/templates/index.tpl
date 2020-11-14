{include file="head_`$smarty.server.carrier_ua`.tpl"}
{config_load file="style.conf"}
{config_load file="emoji.conf"}
<title>{$siteName|escape:html}</title>
</head>
<body style="{#BODY_STYLE#}">

<div style="{#H1_STYLE#}">
<h1>Smarty+{$smarty.server.carrier_ua|escape:html}</h1>
</div>


<div>
<br />
{foreach from=$categories key=i item=category}
  {assign var=cate_icon value="icon_$category"}
  {$smarty.config.$cate_icon}<a href="contents.php?category={$category|escape:html}">{$category|escape:html}</a><br />
{/foreach}
<br />
</div>

<hr style="{#HR_STYLE#}" />
<div>
copyright 2007<br />
{$siteName|escape:html}<br />
All rights reserved.
</div>

</body>
</html>

