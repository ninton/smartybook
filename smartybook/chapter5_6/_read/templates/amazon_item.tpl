{*
	item=
*}
{if $item}
<a href="{$item.DetailPageURL|escape:html}">
  <span class="Title">{$item.ItemAttributes.Title|mb_truncate:28|escape:html}</span>
</a><br />
<span class="Author">{if is_array($item.ItemAttributes.Author)}{", "|join:$item.ItemAttributes.Author|escape:html}{/if}</span><br />
<span class="Publisher">{$item.ItemAttributes.Publisher|escape:html}</span>
<span class="PublicationDate">{$item.ItemAttributes.PublicationDate|escape:html}</span><br />
<span class="Price">{$item.ItemAttributes.ListPrice.FormattedPrice|escape:html}</span><br />
{/if}
