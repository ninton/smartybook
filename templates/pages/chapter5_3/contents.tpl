{config_load file="style.conf"}
{config_load file="emoji.conf"}
{assign var=title value="$category | $siteName"}

{extends file="layouts/chapter5_3/$layoutName"}

{block name="content"}
<div style="{#H1_STYLE#}">
  <h1>Smarty+{$platformType|escape:html}</h1>
</div>

<div>
  {$categoryIcon} {$entry.title|escape:html}<br />
  {if $entry.image}
    {if file_exists($entry.image)}
    {html_image file=$entry.image}<br />
    {else}
    <br />
    --画像準備中--<br />
    <br />
    {/if}
  {/if}
  {#icon_note#}{$entry.text|escape:html|nl2br}
</div>
<div>{#icon_clock#}{$entry.time|date_format:"%Y-%m-%d %H:%M:%S"}</div>

<div>
  <br />
{* NOTE: 各項目間に空白が入ってしまうので、あえてインデントしていません *}
{if $pagerDto->ExPreviousPageLink}<a href="{$pagerDto->ExPreviousPageLink}">≪前</a>&nbsp;{/if}
{if $pagerDto->ExNextPageLink}<a href="{$pagerDto->ExNextPageLink}">次≫</a>&nbsp;{/if}
{$categoryIcon}{$category|escape:html} {$pager->getCurrentPageID()|escape:html}/{$pager->numPages()|escape:html}
  <br />
  □<a href="{$home|escape:html}">Home</a>
</div>
{/block}
