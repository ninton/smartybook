{config_load file="style.conf"}
{config_load file="emoji.conf"}
{assign var=title value="$siteName"}

{extends file="layouts/chapter5_3/$layoutName"}

{block name="content"}
<div style="{#H1_STYLE#}">
  <h1>Smarty+{$carrierName|escape:html}</h1>
</div>

<div>
  <br />
  {foreach from=$categoryDataArr item=categoryData}
  {$categoryData.icon}<a href="{$categoryData.url}">{$categoryData.name|escape:'html'}</a><br />
  {/foreach}
  <br />
</div>
{/block}
