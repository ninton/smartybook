{foreach from=$person item="value" key="key" name="person"}
{if $smarty.foreach.person.first}<ul>{/if}
<li>{$key} : {$value}</li>
{if $smarty.foreach.person.last}</ul>{/if}
{/foreach}
<br />
**ループ総回数：{$smarty.foreach.person.total}回です。
