連想配列を含む多次元配列
<hr />
{section name="person" loop=$person}
{if $smarty.section.person.first}<ul>{/if}
<li>{$person[person].name} - {$person[person].height}cm</li>
{if $smarty.section.person.last}</ul>{/if}
{/section}
<br />
**ループ総回数：{$smarty.section.person.total}回です。
