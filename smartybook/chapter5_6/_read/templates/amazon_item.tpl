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
        {else}
            Author empty
        {/if}
    </span><br />

    <span class="Publisher">
        {if isset($item.ItemAttributes.Publisher)}
            {$item.ItemAttributes.Publisher|escape:html}
        {else}
            Publisher empty
        {/if}
    </span>

    <span class="PublicationDate">
        {if isset($item.ItemAttributes.PublicationDate)}
            {$item.ItemAttributes.PublicationDate|escape:html}
        {else}
            PublicationDate empty
        {/if}
    </span><br />

    <span class="Price">
        {if isset($item.ItemAttributes.ListPrice.FormattedPrice)}
            {$item.ItemAttributes.ListPrice.FormattedPrice|escape:html}
        {else}
            ListPrice empty
        {/if}
    </span><br />
{/if}
