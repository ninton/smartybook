{* メニュー項目がアクティブのときのスタイル *}
{capture assign=active}class="active"{/capture}

{* ページとメニューIDの対応表、メニューIDは階層構造を反映している *}
{assign var=u value=$smarty.server.REQUEST_URI}
{if     preg_match('/\bindex\.php\b/',$u)}{assign var=menu_id value='1'	}
{elseif preg_match('/\/$/'           ,$u)}{assign var=menu_id value='1'	}
{elseif preg_match('/\bcate1\.php\b/',$u)}{assign var=menu_id value='1-1'	}
{elseif preg_match('/\bpage1\.php\b/',$u)}{assign var=menu_id value='1-1-1'}
{elseif preg_match('/\bpage2\.php\b/',$u)}{assign var=menu_id value='1-1-2'}
{elseif preg_match('/\bcate2\.php\b/',$u)}{assign var=menu_id value='1-2'	}
{elseif preg_match('/\bpage3\.php\b/',$u)}{assign var=menu_id value='1-2-1'}
{elseif preg_match('/\bpage4\.php\b/',$u)}{assign var=menu_id value='1-2-2'}
{/if}

<div id="menuBox">
<h4>MENU</h4>

{* メニューhtml。現在アクセスしているメニューIDによって、アクティブ表示やサブメニュー展開する *}
{capture name=menubox}
<ul>
<li><a href="index.php" {if $menu_id == '1'}{$active}{/if}>INDEX</a>
  <ul>
  <li><a href="cate1.php" {if $menu_id == '1-1'}{$active}{/if}>PRESS TRICK</a>
    {if preg_match('/^1-1\b/',$menu_id)}
      <ul>
      <li><a href="page1.php" {if $menu_id == '1-1-1'}{$active}{/if}>NOSE PRESS</a></li>
      <li><a href="page2.php" {if $menu_id == '1-1-2'}{$active}{/if}>TAIL PRESS</a></li>
      </ul>
    {/if}
  </li>
  
  <li><a href="cate2.php" {if $menu_id == '1-2'}{$active}{/if}>SPIN TRICK</a>
    {if preg_match('/^1-2\b/',$menu_id)}
      <ul>
      <li><a href="page3.php" {if $menu_id == '1-2-1'}{$active}{/if}>FRONTSIDE 180</a></li>
      <li><a href="page4.php" {if $menu_id == '1-2-2'}{$active}{/if}>BACKSIDE 180</a></li>
      </ul>
    {/if}
  </li>
  </ul>
</li>
</ul>
{/capture}
{$smarty.capture.menubox|regex_replace:"/<a(.*?)href=\".*?\"(.*?$active.*?)>(.*?)<\/a>/":'<a$1$2>$3</a>'}

</div>
