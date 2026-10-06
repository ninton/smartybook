{include file="components/chapter5_6/head.tpl"}
<title>Smarty for Designers</title>
<script src="js/isbn.js"></script>
</head><body>
<div id="wrapper">
<div id="alpha">
    <p id="siteTitle">Smarty for Designers</p>
</div>
<div id="beta">
    <h1>
        （2020年3月で本プログラムが使っているAmazon_ECSのAPIは廃止となりました。代わりにダミーデータを表示します）<br>
        マイリスト(編集)
    </h1>

    {if $message }
    <div class="message">{$message|escape:html}</div>
    {/if}

    <form action="{$smarty.server.SCRIPT_NAME|escape:html}" method="post">
        <input type="hidden" name="action" value="save" />
        <table class="listMeta" cellspacing="2">
            <tr>
                <th>リスト名</th>
                <td><input name="ListName" value="{$myList->ListName|escape:html}" /></td>
            </tr>
            <tr>
                <th>ニックネーム</th>
                <td><input name="NickName" value="{$myList->NickName|escape:html}" /></td>
            </tr>
        </table>
        <table class="list" cellspacing="0">
            <tr>
                <th>&nbsp;</th>
                <th>ISBN</th>
                <th>コメント</th>
            </tr>

            {section name=i loop=$config.max_items}
            <tr>
                <td>{$smarty.section.i.iteration|escape:html}</td>
                <td>
                  <input class="inp_isbn"
                    name="detail_arr[{$smarty.section.i.index|escape:html}][ASIN]"    
                  	value="{$myList->detail_arr[i].ASIN|escape:html}"
                  	size="14" maxlength="13"
                  	onchange="this.value=isbn13_to_isbn10(this.value)" />
                </td>
                <td>
                  <input class="inp_comment"
                    name="detail_arr[{$smarty.section.i.index|escape:html}][comment]"
                    value="{$myList->detail_arr[i].comment|escape:html}"
                    size="30" maxlength="200" />
                </td>
            </tr>
            {/section}
        </table>
        <div id="btn">
            <input class="button" type="submit" value="保存" />
            <input class="button" type="button" value="キャンセル" onclick="location.href='?action=preview'" />
        </div>
    </form>
</div>
{include file="components/chapter5_6/footer.tpl"} 
