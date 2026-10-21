{* 再帰レンダリング用の Smarty 関数定義 *}
{function name=render_menu items=[]}
  <ul>
  {foreach $items as $item}
    {assign var="is_current" value=($item.url == $currentPage)}
    <li>
      <a href="{$item.url|escape}" {if $is_current}aria-current="page" class="active"{/if}>{$item.title|escape}</a>

    {* 子要素が存在する場合は再帰呼び出し *}
    {if !empty($item.children)}
      {render_menu items=$item.children}
    {/if}
    </li>
  {/foreach}
  </ul>
{/function}

<div id="menuBox">
  <h4>MENU</h4>

{* ルートの呼び出し *}
{render_menu items=$menuTree}
</div>
