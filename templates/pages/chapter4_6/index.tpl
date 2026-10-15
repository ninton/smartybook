{extends file="layouts/chapter4_6/base.tpl"}

{block name="content"}
  {$sortNavigator->setOption('asc_current' , '<img src="images/btn_asc_current.gif"  alt="" border="0" />')}
  {$sortNavigator->setOption('asc_link'    , '<img src="images/btn_asc.gif"          alt="" border="0" />')}
  {$sortNavigator->setOption('desc_current', '<img src="images/btn_desc_current.gif" alt="" border="0" />')}
  {$sortNavigator->setOption('desc_link'   , '<img src="images/btn_desc.gif"         alt="" border="0" />')}

  <h1>Smarty for Designers</h1>

  <div id="info">
  <form action="{$smarty.server.SCRIPT_NAME}" name="perPage">
  <input type="hidden" name="sort"  value="{$sortKey}" />
  <input type="hidden" name="order" value="{$sortDirection}" />
  全{$pagerDto->numItems}件中 {$pagerDto->offsetFrom}件目～{$pagerDto->offsetTo}件目 | 
  全{$pagerDto->numPages}ページ中 {$pagerDto->currentPageID}ページ目 | 
  表示件数{html_options
      name="setPerPage"
      options=$perPageOptions
      selected=$currentPerPage
      onchange='document.forms["perPage"].submit()'
  }
  </form>
  </div>


  <table border="0" cellspacing="0">
  <tr>
    <th>ID      <br />{$sortNavigator->show('id')}</th>
    <th>カテゴリ<br />{$sortNavigator->show('category')}</th>
    <th>タイトル<br />{$sortNavigator->show('title')}</th>
    <th class="comment">コメント<br />{$sortNavigator->show('comment')}</th>
    <th>日付    <br />{$sortNavigator->show('time')}</th>
  </tr>
  {foreach from=$entryArr key=i item=entry}
  <tr class="{cycle name="cycle2" values='tr2_1,tr2_2'} {cycle name="cycle5" values=',,,,tr5_5'}">
    <td>{$entry.id|escape:html}</td>
    <td>{$entry.category|escape:html}</td>
    <td>{$entry.title|escape:html}</td>
    <td>{$entry.comment|escape:html}</td>
    <td>{$entry.time|date_format:"%Y-%m-%d"}</td>
  </tr>
  {foreachelse}
  <tr>
    <td colspan="5">データなし</td>
  </tr>
  {/foreach}
  </table>


  <div id="navi">
  {if $pagerDto->firstPageHref}
  <a href="{$pagerDto->firstPageHref}">&lt;&lt;先頭へ</a>
  {else}
  &lt;&lt;先頭へ
  {/if}

  {if $pagerDto->previousPageHref}
  <a href="{$pagerDto->previousPageHref}">&lt;前へ</a>
  {else}
  &lt;前へ
  {/if}

  {html_options
      name="pageID"
      options=$pageOptions
      selected=$pagerDto->currentPageID
      onchange="let url = new window.URL(document.location.href); url.searchParams.set('pageID', this.value); document.location.href = url.href;"
  }
  {$pagerDto->links}

  {if $pagerDto->nextPageHref}
  <a href="{$pagerDto->nextPageHref}">次へ&gt;</a>
  {else}
  次へ&gt;
  {/if}


  {if $pagerDto->lastPageHref}
  <a href="{$pagerDto->lastPageHref}">最後へ&gt;&gt;</a>
  {else}
  最後へ&gt;&gt;
  {/if}

  {$pagerDto->currentPageID}/{$pagerDto->numPages}ページ
  </div>{* id="navi" *}
{/block}
