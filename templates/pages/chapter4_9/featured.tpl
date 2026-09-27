<!-- {$smarty.template|basename} -->
<!-- created time {$smarty.now|date_format:"%Y/%m/%d %H:%M:%S"} -->
<h2 class="moduleHeader">注目の記事</h2>

{foreach from=$featured_arr key=i item=entry}
    <div class="entry">
        <h3 class="entryTitle"><a href="{$entry.url|escape:html}">{$entry.title|escape:html}</a></h3>
        <div class="contentsBody">
            {if $entry.image ne ''}<p><img alt="" src="{$entry.image|escape:html}" /></p>{/if}
            {$entry.comment|mb_truncate:26|escape:html}
        </div>
        <div class="entryDate">{$entry.time|date_format:"%Y-%m-%d"}</div>
    </div>
{/foreach}
