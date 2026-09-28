{*
	image=
	width=
	height=
*}
{strip}
{if $image}
  {if $width  eq ''}{assign var=width  value=$image.Width._content }{/if}
  {if $height eq ''}{assign var=height value=$image.Height._content}{/if}

  {if $image.Width._content < $image.Height._content }
    {assign  var=h  value=$height}
    {math assign=w  equation="floor(`$h` * `$image.Width._content` / `$image.Height._content`)"}
    {assign  var=pT value=0}
    {assign  var=pB value=0}
    {math assign=pL equation="floor((`$width` - `$w`) / 2)"}
    {math assign=pR equation="`$width` - `$w` - `$pL`"}
  {else}
    {assign  var=w  value=$width}
    {math assign=h  equation="floor(`$w` * `$image.Height._content` / `$image.Width._content`)"}
    {math assign=pT equation="floor((`$height` - `$h`) / 2)"}
    {math assign=pB equation="`$height` - `$h` - `$pT`"}
    {assign  var=pL value=0}
    {assign  var=pR value=0}
  {/if}
  
  <img src="{$image.URL|escape:html}"
    width="{$w|escape:html}"
    height="{$h|escape:html}"
    style="padding:{$pT|escape:html}px {$pR|escape:html}px {$pB|escape:html}px {$pL|escape:html}px"
    />
{/if}
{/strip}