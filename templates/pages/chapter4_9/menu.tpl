<ul>
{foreach from=$menu_arr key=i item=menu}
    <li><a href="{$menu.url|escape:html}">{$menu.title|escape:html}</a></li>
{/foreach}
</ul>
