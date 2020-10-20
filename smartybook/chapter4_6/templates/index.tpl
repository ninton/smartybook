<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ja" lang="ja">
<head>
<title>複数ある項目を並び替える</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="Content-Style-Type" content="text/css; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="./css/styles.css" />
</head>
<body>
<div id="wrapper">

{$SortNavi->setOption('asc_current' , '<img src="images/btn_asc_current.gif"  alt="" border="0" />')}
{$SortNavi->setOption('asc_link'    , '<img src="images/btn_asc.gif"          alt="" border="0" />')}
{$SortNavi->setOption('desc_current', '<img src="images/btn_desc_current.gif" alt="" border="0" />')}
{$SortNavi->setOption('desc_link'   , '<img src="images/btn_desc.gif"         alt="" border="0" />')}


<h1>Smarty for Designers</h1>

<div id="info">
<form action="{$smarty.server.SCRIPT_NAME}" name="perPage">
<input type="hidden" name="sort"  value="{$smarty.request.sort}" />
<input type="hidden" name="order" value="{$smarty.request.order}" />
全{$Pager->numItems()}件中 {$Pager->ExOffsetFrom}件目～{$Pager->ExOffsetTo}件目 | 
全{$Pager->numPages()}ページ中 {$Pager->getCurrentPageID()}ページ目 | 
表示件数{$Pager->getPerPageSelectBox(1, 20, 1, true, $perpage_params)}
</form>
</div>


<table border="0" cellspacing="0">
<tr>
  <th>ID      <br />{$SortNavi->show('id')      }</th>
  <th>カテゴリ<br />{$SortNavi->show('category')}</th>
  <th>タイトル<br />{$SortNavi->show('title')   }</th>
  <th class="comment">コメント<br />{$SortNavi->show('comment') }</th>
  <th>日付    <br />{$SortNavi->show('time')    }</th>
</tr>
{foreach from=$rcd_arr key=i item=rcd}
<tr class="{cycle name="cycle2" values='tr2_1,tr2_2'} {cycle name="cycle5" values=',,,,tr5_5'}">
  <td>{$rcd.id|escape:html}</td>
  <td>{$rcd.category|escape:html}</td>
  <td>{$rcd.title|escape:html}</td>
  <td>{$rcd.comment|escape:html}</td>
  <td>{$rcd.time|date_format:"%Y-%m-%d"}</td>
</tr>
{foreachelse}
<tr>
  <td colspan="5">データなし</td>
</tr>
{/foreach}
</table>


<div id="navi">
{if not $Pager->isFirstPage()}
<a href="{$Pager->ExFirstPageLink}">&lt;&lt;先頭へ</a>
{else}
&lt;&lt;先頭へ
{/if}

{if $Pager->getPreviousPageID()}
<a href="{$Pager->ExPreviousPageLink}">&lt;前へ</a>
{else}
&lt;前へ
{/if}

{$Pager->getPageSelectBox($popup_params)}
{$Pager->ExLinks}

{if $Pager->getNextPageID()}
<a href="{$Pager->ExNextPageLink}">次へ&gt;</a>
{else}
次へ&gt;
{/if}


{if not $Pager->isLastPage()}
<a href="{$Pager->ExLastPageLink}">最後へ&gt;&gt;</a>
{else}
最後へ&gt;&gt;
{/if}

{$Pager->getCurrentPageID()}/{$Pager->numPages()}ページ
</div><!-- id="navi" -->

</div><!-- id="wrapper" -->
</body>
</html>
