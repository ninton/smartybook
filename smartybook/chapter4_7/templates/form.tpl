{include file="head.tpl"}

<link rel="stylesheet" type="text/css" href="css/styles.css" />
</head>
<body>
<div id="wrapper">
  <h1>入力</h1>
  <form action="{$smarty.server.SCRIPT_NAME|escape:html}" method="post">
    <input type="hidden" name="action" value="confirm" />
    <table border="0" cellspacing="0">
      <tr>
        <th>都道府県</th>
        <td>
          <select name="prefecture">
            <option value="">選択してください</option>
            {html_options values=$META.prefecture output=$META.prefecture selected=$form.prefecture}
          </select>
        </td>
      </tr>
      <tr>
        <th>評価</th>
        <td>{html_radios name=rating options=$META.rating selected=$form.rating separator="<br />"}</td>
      </tr>
      <tr>
        <th>どこで知りましたか</th>
        <td>{html_checkboxes name=where_arr values=$META.where output=$META.where selected=$form.where_arr separator="<br />"}</td>
      </tr>
      <tr>
        <th>開始日時</th>
        <td>
{html_select_date prefix="" field_array="startDate" time=$form.startDate.TimeStamp display_months=0  display_days=0    end_year="+3"     }年
{html_select_date prefix="" field_array="startDate" time=$form.startDate.TimeStamp display_years=0   display_days=0    month_format="%#m"}月
{html_select_date prefix="" field_array="startDate" time=$form.startDate.TimeStamp display_years=0   display_months=0  day_format="%d"   }日
{html_select_time prefix="" field_array="startDate" time=$form.startDate.TimeStamp display_minutes=0 display_seconds=0 use_24_hours=1    }時
{html_select_time prefix="" field_array="startDate" time=$form.startDate.TimeStamp display_hours=0   display_seconds=0                   }分
{html_select_time prefix="" field_array="startDate" time=$form.startDate.TimeStamp display_hours=0   display_minutes=0                   }秒<br />
        </td>
      </tr>
      <tr>
        <th>終了日時</th>
        <td>
{include file=select_date.tpl prefix="endDate_" field_array="" time=$form.endDate_TimeStamp end_year="+3"}
{include file=select_time.tpl prefix="endDate_" field_array="" time=$form.endDate_TimeStamp}<br />
        </td>
      </tr>
    </table>
    <div id="button"><input type="submit" value="確認" /></div>'
  </form>
</div>
</body>
</html>
