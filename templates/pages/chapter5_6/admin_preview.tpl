{extends file='layouts/chapter5_6/base.tpl'}

{block name="content"}
    <h1>マイリスト(プレビュー)</h1>
    <p><a class="button" href="view.php" target="_blank">公開ページを確認</a></p>

    {if $message }
    <div class="message">{$message|escape:html}</div>
    {/if}

    <table class="listMeta" cellspacing="2">
        <tr>
            <th>リスト名</th>
            <td>{$myList->ListName|escape:html}</td>
        </tr>
        <tr>
            <th>ニックネーム</th>
            <td>{$myList->NickName|escape:html}</td>
        </tr>
    </table>
    <table class="list" cellspacing="0">
        {foreach name=f from=$myList->detail_arr key=i item=detail}
          
            {if $detail.ASIN != '' || $detail.comment != ''}
                <tr>
                    <td>{$smarty.foreach.f.iteration|escape:html}</td>
                    <td>
                        {if isset($detail.Item.SmallImage)}
                            {include file="components/chapter5_6/amazon_image.tpl" image=$detail.Item.SmallImage  width=75 height=75}
                        {else}
                            SmallImage empty
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
    <div id="btn">
        <form action="{$smarty.server.SCRIPT_NAME|escape:html}" method="get">
            <input type="hidden" name="action" value="form" />
            <input class="button" type="submit" value="編集" />
        </form>
    </div>
{/block}
