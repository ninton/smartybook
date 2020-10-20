{include file="head.tpl"}
<link rel="stylesheet" type="text/css" href="css/styles.css" />
</head><body>
<div id="wrapper">
  <h1>確認</h1>
  <table border="0" cellspacing="0">
    <tr>
      <th>都道府県</th>
      <td>{$form.prefecture|escape:html|default:"(未選択)"}</td>
    </tr>
    <tr>
      <th>評価</th>
      <td>{$META.rating[$form.rating]|default:"(未選択)"}</td>
    </tr>
    <tr>
      <th>どこで知りましたか</th>
      <td>
        {foreach from=$form.where_arr item=where}
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
      <input type="hidden" name="action" value="submit" />
      <input type="button" value="再入力" onclick="window.location='{$smarty.server.SCRIPT_NAME|escape:html}?action=form'" />
      <input type="submit" value="送信" />
    </form>
  </div>
</div>
</body>
</html>