{foreach from=$person item="data" name="person"}
{if $smarty.foreach.person.first}<ul>{/if}
    {foreach from=$data item="value" key="key" name="data"}
    {if $smarty.foreach.data.first}<li>{/if}
    {$key} : {$value}　
    {if $smarty.foreach.data.last}</li>{/if}
    {/foreach}
{if $smarty.foreach.person.last}</ul>{/if}
{/foreach}
<br />
**ループ総回数(person)：{$smarty.foreach.person.total}回です。<br />
**ループ総回数(data)：{$smarty.foreach.data.total}回です。
