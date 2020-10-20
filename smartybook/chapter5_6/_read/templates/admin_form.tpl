{include file="head.tpl"}
<title>Smarty for Designers</title>
<script src="js/isbn.js"></script>
</head><body>
<div id="wrapper">
<div id="alpha">
    <p id="siteTitle">Smarty for Designers</p>
</div>
<div id="beta">
    <h1>マイリスト(編集)</h1>

    {if $message }
    <div class="message">{$message|escape:html}</div>
    {/if}

    <form action="{$smarty.server.SCRIPT_NAME|escape:html}" method="post">
        <input type="hidden" name="ListId" value="{$mylist->ListId|escape:html}" />
        
        <table class="listMeta" cellspacing="2">
            <tr>
                <th>リスト名</th>
                <td><input name="ListName" value="{$mylist->ListName|escape:html}" /></td>
            </tr>
            <tr>
                <th>ニックネーム</th>
                <td><input name="NickName" value="{$mylist->NickName|escape:html}" /></td>
            </tr>
        </table>
        <table class="list" cellspacing="0">
            <tr>
                <th>&nbsp;</th>
                <th>ISBN</th>
                <th>コメント</th>
            </tr>

            {section name=i loop=$CFG.max_items}
            <tr>
                <td>{$smarty.section.i.iteration|escape:html}</td>
                <td>
                  <input class="inp_isbn"
                    name="detail_arr[{$smarty.section.i.index|escape:html}][ASIN]"    
                  	value="{$mylist->detail_arr[i].ASIN|escape:html}"
                  	size="14" maxlength="13"
                  	onchange="this.value=isbn13_to_isbn10(this.value)" />
                </td>
                <td>
                  <input class="inp_comment"
                    name="detail_arr[{$smarty.section.i.index|escape:html}][comment]"
                    value="{$mylist->detail_arr[i].comment|escape:html}"
                    size="30" maxlength="200" />
                </td>
            </tr>
            {/section}
        </table>
        <div id="btn">
            <input class="button" type="submit" name="cmdSave"   value="保存" />
            <input class="button" type="submit" name="cmdCancel" value="キャンセル" />
        </div>
    </form>
</div>
{include file="footer.tpl"} 
