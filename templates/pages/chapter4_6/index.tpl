{extends file="layouts/chapter4_6/base.tpl"}

{block name="content"}
  <h1>Smarty for Designers</h1>

  <div id="info">
  <form action="{$smarty.server.SCRIPT_NAME}" name="perPage">
  <input type="hidden" name="sort_key"  value="{$sortKey}" />
  <input type="hidden" name="sort_direction" value="{$sortDirection}" />
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
  {* サーバー側からは静的な構造と初期データ属性のみを出力 *}
  <tr id="sortable-header" data-script-name="{$smarty.server.SCRIPT_NAME}" data-current-sort="{$sortKey|escape}" data-current-dir="{$sortDirection|escape}">
    <th data-sort-key="id">
      ID<br />
      <span class="sort-buttons">
        <a href="#" data-direction="asc" title="昇順"><img src="images/btn_asc.gif" alt="" /></a>
        <a href="#" data-direction="desc" title="降順"><img src="images/btn_desc.gif" alt="" /></a>
      </span>
    </th>
    <th data-sort-key="category">
      カテゴリ<br />
      <span class="sort-buttons">
        <a href="#" data-direction="asc" title="昇順"><img src="images/btn_asc.gif" alt="" /></a>
        <a href="#" data-direction="desc" title="降順"><img src="images/btn_desc.gif" alt="" /></a>
      </span>
    </th>
    <th data-sort-key="title">
      タイトル<br />
      <span class="sort-buttons">
        <a href="#" data-direction="asc" title="昇順"><img src="images/btn_asc.gif" alt="" /></a>
        <a href="#" data-direction="desc" title="降順"><img src="images/btn_desc.gif" alt="" /></a>
      </span>
    </th>
    <th class="comment" data-sort-key="comment">
      コメント<br />
      <span class="sort-buttons">
        <a href="#" data-direction="asc" title="昇順"><img src="images/btn_asc.gif" alt="" /></a>
        <a href="#" data-direction="desc" title="降順"><img src="images/btn_desc.gif" alt="" /></a>
      </span>
    </th>
    <th data-sort-key="time">
      日付<br />
      <span class="sort-buttons">
        <a href="#" data-direction="asc" title="昇順"><img src="images/btn_asc.gif" alt="" /></a>
        <a href="#" data-direction="desc" title="降順"><img src="images/btn_desc.gif" alt="" /></a>
      </span>
    </th>
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
