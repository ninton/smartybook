<html>
<head>
<meta http-equiv="Content-type" content="text/html; charset=UTF-8" />
<title>Smarty for Designers</title>

{literal}
<script>
var viewer_win = null;

function viewer_open( i_path ) {
	if ( viewer_win == null || viewer_win.closed ) {
		viewer_win = window.open( '', '_blank', 'width=240,height=240,status=1,menubar=1,toolbar=1,location=1,resizable=1' );
	}
	viewer_win.location = i_path;
}

function viewer_show( i_path ) {
	if ( viewer_win != null && !viewer_win.closed ) {
		viewer_win.location = i_path;
	}
}
</script>
{/literal}

</head>
<body>
<h1>Smarty for Designers</h1>

<h2>image size converter</h2>

<table border="1" cellspacing="0">
<tr>
  <th>&nbsp;</th>
  <th>Filename</th>
  <th>Original</th>
  <th>120/</th>
  <th>240/</th>
  <th>480/</th>
  <th>Convert</th>
</tr>
{assign var=w value=48}
{assign var=h value=48}

{foreach name=f from=$rcd_arr key=i item=rcd}
<tr class="row-{$i}">
  <td align="center">{$smarty.foreach.f.iteration|escape:html}</td>

  <td>{$rcd.fname|escape:html}</td>

  {strip}
  <td align="center" valign="top"  class="width-original">
    <a href="{$rcd.src.path|escape:html}"
      onclick="viewer_open('{$rcd.src.path|escape:javascript|escape:html}'); return false;"
      onmouseover="viewer_show('{$rcd.src.path|escape:javascript|escape:html}')">
    {html_image file=$rcd.src.path width=$w height=$h border=1 alt="Show full size"}
    </a><br />
    <small>{$rcd.src.width|escape:html} x {$rcd.src.height|escape:html}</smalL>
  </td>
  {/strip}

  {foreach from=$rcd.dst key=width item=dst}
  {strip}
  <td align="center" valign="top" class="width-{$width}">
    <a href="{$dst.path|escape:html}"
      onclick="viewer_open('{$dst.path|escape:javascript|escape:html}'); return false;"
      onmouseover="viewer_show('{$dst.path|escape:javascript|escape:html}')">
    {html_image file=$dst.path width=$w height=$h border=1 alt="Show full size"}
    </a><br />
    <small>{$dst.width|escape:html} x {$dst.height|escape:html}</small>
  </td>
  {/strip}
  {/foreach}

  <td valign="middle" align="center">
    <form action="{$smarty.server.SCRIPT_NAME|escape:html}" method="post">
    <input type="hidden" name="fname" value="{$rcd.fname|escape:html}" />
    <input type="submit" value="Convert" />
    </form>
  </td>
</tr>
{/foreach}

</table>

<address>copyright 2007 Smarty for Designers All rights reserved.</address>

</body>
</html>
