{config_load file="style.conf"}
{config_load file="emoji.conf"}
{assign var=title value="$category | $siteName"}

{extends file="layouts/chapter5_3/$layoutName"}

{block name="content"}
<div style="{#H1_STYLE#}">
  <h1>Smarty+{$platformType|escape:html}</h1>
</div>

<div>
  {$categoryIcon} {$entryViewModel.title|escape:html}<br />
  {if $entryViewModel.image_status === 'exists'}
  {html_image file=$entryViewModel.image}<br />
  {elseif $entryViewModel.image_status === 'missing'}
  <br />
  --画像準備中--<br />
  <br />
  {/if}
{* image_status === 'none' の場合は何も出力しない *}  {#icon_note#}{$entryViewModel.text|escape:html|nl2br}
</div>
<div>{#icon_clock#}{$entryViewModel.time|date_format:"%Y-%m-%d %H:%M:%S"}</div>

<div>
  <br />
{* NOTE: 各項目間に空白が入ってしまうので、あえてインデントしていません *}
{if $pagerDto->previousPageHref}<a href="{$pagerDto->previousPageHref}">≪前</a>&nbsp;{/if}
{if $pagerDto->nextPageHref}<a href="{$pagerDto->nextPageHref}">次≫</a>&nbsp;{/if}
{$categoryIcon}{$category|escape:html} {$pagerDto->currentPageID|escape:html}/{$pagerDto->numPages|escape:html}
  <br />
  □<a href="{$home|escape:html}">Home</a>
</div>
{/block}
