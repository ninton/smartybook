<!-- {$smarty.template|basename} -->
<!-- created time {$smarty.now|date_format:"%Y/%m/%d %H:%M:%S"} -->
<ul>
{foreach from=$menu_arr key=i item=menu}
    <li><a href="{$menu.url|escape:html}">{$menu.title|escape:html}</a></li>
{/foreach}
</ul>
