オリジナル：{$text}<br>
{* html: <&>"'はエンティティ化、café・©・日本語はそのまま *}
パラメータなし：{$text|escape}<br>
html：{$text|escape:"html"}<br>
{* htmlall: <&>"'に加えて café(é) や © などもHTMLエンティティ化 *}
htmlall：{$text|escape:"htmlall"}<br>
<hr>
{* url: 半角スペースは %20 に変換（クエリパラメータ向け） *}
url：<a href="/search?q={$keyword|escape:"url"}">{$keyword|escape:"html"}</a><br>
{* urlpathinfo: 半角スペースは %20 に変換（URLパスセグメント向け） *}
urlpathinfo：<a href="/files/{$fileName|escape:"urlpathinfo"}">{$fileName|escape:"html"}</a><br>
<hr>
{* 以下の用途は限定的 *}

{* mail: @ や . を [AT] / [DOT] などに置換して簡易難読化
 * 出力イメージのポイント: user [AT] example [DOT] com になり、そのまま mailto: 等には使いにくい形式 *}
mail：{$email|escape:"mail"}<br>

{* quotes: クォーテーション文字中心の簡易エスケープ（改行などは対象外）
 * 出力イメージのポイント: クォート崩れは抑えられるが、改行や制御文字を含むJS文字列には不向き *}
quotes：{$quoteText|escape:"quotes"}<br>

{* javascript: JS文字列リテラル向けにクォート・改行・記号などをエスケープ
 * 出力イメージのポイント: \n や ' や </script> による構文破壊を防ぎつつJS文字列へ渡せる（構造化データは json_encode も検討）
 * 現在は、HTMLタグのデータ属性に埋め込むか、API経由で渡すほうが主流です *}
javascript：<script>const jsText = '{$jsText|escape:"javascript"}';</script><br>

{* hex: 文字を16進数文字列に変換
 * 出力イメージのポイント: 4142 のような16進文字列の並びになる（そのまま表示すると16進数が見える）
 * JSまたは受け取った側で 16進数をデコード／パースすることを想定している（実際の利用場面はかなり限定的） *}
hex：{$hexText|escape:"hex"}<br>

{* hexentity: 16進数のHTML数値文字参照（&#x..;）に変換しHTMLとして描画
 * 出力イメージのポイント: ソース上は &#x41;&#x26;&#x42; になり、ブラウザ上では A&B と描画される（XSS対策の代替にはならない） *}
hexentity：{$hexEntityText|escape:"hexentity"}<br>
