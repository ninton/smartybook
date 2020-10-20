多次元配列
<hr />
{section name="group" loop=$group}
グループ{$smarty.section.group.iteration} : 
    {section name="name" loop=$group[group]}
    {$group[group][name]}
    {if !$smarty.section.name.last} and {/if}
    {/section}
<br />
{/section}
<br />
**ループ総回数（group）：{$smarty.section.group.total}回です。<br />
**ループ総回数（name）：{$smarty.section.name.total}回です。
