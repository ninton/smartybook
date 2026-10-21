<div id="menuBox">
<h4>MENU</h4>

{* メニューhtml。現在アクセスしているメニューIDによって、アクティブ表示やサブメニュー展開する *}
<ul>
<li><a href="index.php" {if $currentPage == 'index'}aria-current="page" class="active"{/if}>INDEX</a>
  <ul>
  <li><a href="cate1.php" {if $currentPage == 'cate1'}aria-current="page" class="active"{/if}>PRESS TRICK</a>
      <ul>
      <li><a href="page1.php" {if $currentPage == 'page1'}aria-current="page" class="active"{/if}>NOSE PRESS</a></li>
      <li><a href="page2.php" {if $currentPage == 'page2'}aria-current="page" class="active"{/if}>TAIL PRESS</a></li>
      </ul>
  </li>
  
  <li><a href="cate2.php" {if $currentPage == 'cate2'}aria-current="page" class="active"{/if}>SPIN TRICK</a>
      <ul>
      <li><a href="page3.php" {if $currentPage == 'page3'}aria-current="page" class="active"{/if}>FRONTSIDE 180</a></li>
      <li><a href="page4.php" {if $currentPage == 'page4'}aria-current="page" class="active"{/if}>BACKSIDE 180</a></li>
      </ul>
  </li>
  </ul>
</li>
</ul>

</div>
