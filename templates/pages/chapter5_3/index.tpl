{config_load file="style.conf"}
{config_load file="emoji.conf"}
{assign var=title value="$siteName"}

{extends file="layouts/chapter5_3/base_`$smarty.server.carrier_ua`.tpl"}

{block name="content"}
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
{/block}
