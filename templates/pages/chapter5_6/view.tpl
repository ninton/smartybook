{extends file='layouts/chapter5_6/base.tpl'}

{block name="content"}
<h1>
  （2020年3月で本プログラムが使っているAmazon_ECSのAPIは廃止となりました。代わりにダミーデータを表示します）<br>
  {$myList->ListName|escape:html} - {$myList->NickName|escape:html}
</h1>

<table class="list" cellspacing="0">
  {foreach name=f from=$myList->detail_arr key=i item=detail}
    {if $detail.ASIN != '' || $detail.comment != ''}
  <tr>
    <td>
      {if isset($detail.Item.SmallImage)}
        {include file="components/chapter5_6/amazon_image.tpl" image=$detail.Item.SmallImage width=75 height=75}
      {/if}
    </td>

      {strip}
    <td>
        {include file="components/chapter5_6/amazon_item.tpl" item=$detail.Item}
      <div class="comment">
        <strong>コメント: </strong> {$detail.comment|escape:html}
      </div>
    </td>
      {/strip}
  </tr>
    {/if}
  {/foreach}
</table>
{/block}
