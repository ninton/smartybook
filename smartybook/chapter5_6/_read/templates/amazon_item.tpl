{*
	item=
*}
{if $item}
    <a href="{$item.DetailPageURL|escape:html}">
      <span class="Title">{$item.ItemAttributes.Title|mb_truncate:28|escape:html}</span>
    </a><br />

    <span class="Author">
        {if isset($item.ItemAttributes.Author) && is_array($item.ItemAttributes.Author)}
            {", "|join:$item.ItemAttributes.Author|escape:html}
        {/if}
    </span><br />

    <span class="Publisher">
        {if isset($item.ItemAttributes.Publisher)}
            {$item.ItemAttributes.Publisher|escape:html}
        {/if}
    </span>

    <span class="PublicationDate">
        {if isset($item.ItemAttributes.PublicationDate)}
            {$item.ItemAttributes.PublicationDate|escape:html}
        {/if}
    </span><br />

    <span class="Price">
        {if isset($item.ItemAttributes.ListPrice.FormattedPrice)}
            {$item.ItemAttributes.ListPrice.FormattedPrice|escape:html}
        {/if}
    </span><br />
{/if}
