{include file="head.tpl"}
<title>Smarty for Designers</title>
</head><body>
<div id="wrapper">
<div id="alpha">
    <p id="siteTitle">Smarty for Designers</p>
</div>
<div id="beta">
    <h1>マイリスト(プレビュー)</h1>
    <p><a class="button" href="view.php?ListId={$mylist->ListId|escape:html}" target="_blank">公開ページを確認</a></p>

    {if $message }
    <div class="message">{$message|escape:html}</div>
    {/if}

    <table class="listMeta" cellspacing="2">
        <tr>
            <th>リスト名</th>
            <td>{$mylist->ListName|escape:html}</td>
        </tr>
        <tr>
            <th>ニックネーム</th>
            <td>{$mylist->NickName|escape:html}</td>
        </tr>
    </table>
    <table class="list" cellspacing="0">
        {foreach name=f from=$mylist->detail_arr key=i item=detail}
          
          {if $detail.ASIN != '' || $detail.comment != ''}
            <tr>
              <td>{$smarty.foreach.f.iteration|escape:html}</td>
              <td>{include file="amazon_image.tpl" image=$detail.Item.SmallImage  width=75 height=75}</td>
              
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
    <div id="btn">
        <form action="{$smarty.server.SCRIPT_NAME|escape:html}" method="get">
            <input type="hidden" name="show"   value="form" />
            <input type="hidden" name="ListId" value="{$mylist->ListId|escape:html}" />
            <input class="button" type="submit" value="編集" />
        </form>
    </div>
</div>
{include file="footer.tpl"} 
