{section name="member" loop=$member}
{if $smarty.section.member.first}<table style="width:200px;">{/if}
<tr style="background:{cycle values="#ccffff,#ccf0ff"};">
<td>{$member[member]}</td>
</tr>
{if $smarty.section.member.last}</table>{/if}
{/section}
