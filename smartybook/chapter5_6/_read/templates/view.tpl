{include file="head.tpl"}
<title>Smarty for Designers</title>
</head>
<body>
<div id="wrapper">
<div id="alpha">
    <p id="siteTitle">Smarty for Designers</p>
</div>
<div id="beta">
    <h1>
        （2020年3月で本プログラムが使っているAmazon_ECSのAPIは廃止となりました。常に410エラーです）<br>
        {$mylist->ListName|escape:html} - {$mylist->NickName|escape:html}
    </h1>

    <table class="list" cellspacing="0">
        {foreach name=f from=$mylist->detail_arr key=i item=detail}
            {if $detail.ASIN != '' || $detail.comment != ''}
                <tr>

                  <td>
                      {if isset($detail.Item.SmallImage)}
                        {include file="amazon_image.tpl" image=$detail.Item.SmallImage width=75 height=75}
                      {/if}
                  </td>

                  {strip}
                  <td>
                    {include file="amazon_item.tpl" item=$detail.Item}
                    <div class="comment">
                      <strong>コメント: </strong> {$detail.comment|escape:html}
                    </div>
                  </td>
                  {/strip}
                </tr>
            {/if}
        {/foreach}
    </table>
</div>
{include file="footer.tpl"} 
