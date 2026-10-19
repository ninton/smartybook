{extends file="layouts/chapter4_7/base.tpl"}

{block name="content"}
  <h1>確認</h1>
  <table>
    <tr>
      <th>都道府県</th>
      <td>{$form.prefecture|default:"(未選択)"|escape:html}</td>
    </tr>
    <tr>
      <th>評価</th>
      <td>{$META.rating[$form.rating|default:""]|default:"(未選択)"|escape:html}</td>
    </tr>
    <tr>
      <th>どこで知りましたか</th>
      <td>
        {foreach from=$form.where_arr|default:[] item=where}
          {$where|escape:html}<br />
        {foreachelse}
          (未選択)<br />
        {/foreach}
      </td>
    </tr>
    <tr>
      <th>開始日時</th>
      <td>{$form.startDate.TimeStamp|date_format:"%Y-%m-%d %H:%M:%S"}</td>
    </tr>
    <tr>
      <th>終了日時</th>
      <td>{$form.endDate_TimeStamp|date_format:"%Y-%m-%d %H:%M:%S"}</td>
    </tr>
  </table>
  <div id="button">
    <form action="{$smarty.server.SCRIPT_NAME|escape:html}" method="post">
      <input type="hidden" name="csrf_token" value="{$csrf_token}">
      <input type="hidden" name="action" value="submit" />
      <input type="button" value="再入力" onclick="window.location='{$smarty.server.SCRIPT_NAME|escape:html}?action=form'" />
      <input type="submit" value="送信" />
    </form>
  </div>
{/block}
