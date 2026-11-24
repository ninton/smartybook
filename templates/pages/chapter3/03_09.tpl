オリジナル：{$text}<br>

{*
 * html: <&>"'はエンティティ化、café・©・日本語はそのまま
 * 主な用途: HTMLエスケープ
 * 出力イメージ: htmlspecialchars
 * @see https://github.com/smarty-php/smarty/blob/37cf86ab808ece0551c2bec285e7162c9a236f31/src/Compile/Modifier/EscapeModifierCompiler.php#L26-L33
 *}
パラメータなし：{$text|escape}<br>
html：{$text|escape:"html"}<br>

{*
 * htmlall: <&>"'に加えて café(é) や © などもHTMLエンティティ化
 * 主な用途: 文字コードや出力仕様の都合で、記号・アクセント文字までエンティティ化したいとき
 * 使い分け: 通常は html（または escape_html = true）で十分。文字コード不整合や出力肥大化を避けるため、明確な理由がない限り htmlall は使わない
 * 出力イメージ: htmlentities
 * @see https://github.com/smarty-php/smarty/blob/37cf86ab808ece0551c2bec285e7162c9a236f31/src/Compile/Modifier/EscapeModifierCompiler.php#L35-L39
 *}
htmlall：{$text|escape:"htmlall"}<br>

<hr>

{*
 * url: 半角スペースは %20 に変換
 * 主な用途: クエリパラメータ
 * 出力イメージ: rawurlencode
 * @see https://github.com/smarty-php/smarty/blob/37cf86ab808ece0551c2bec285e7162c9a236f31/src/Compile/Modifier/EscapeModifierCompiler.php#L41-L43
 *}
url：<a href="/search?q={$keyword|escape:"url"}">{$keyword|escape:"html"}</a><br>

{*
 * urlpathinfo: 半角スペースは %20 に変換
 * 主な用途: URLパスセグメント
 * 出力イメージ: rawurlencode後に `%2F` を `/` に戻す
 * @see https://github.com/smarty-php/smarty/blob/37cf86ab808ece0551c2bec285e7162c9a236f31/src/Compile/Modifier/EscapeModifierCompiler.php#L44-L46
 *}
urlpathinfo：<a href="/files/{$fileName|escape:"urlpathinfo"}">{$fileName|escape:"html"}</a><br>

<hr>
{* 以下、実際の利用場面は限定的 *}

{*
 * mail: @ や . を [AT] / [DOT] などに置換して簡易難読化
 * 主な用途: メールアドレスの簡易難読化
 * 出力イメージ: user [AT] example [DOT] com になり、そのまま mailto: 等には使いにくい形式
 *}
mail：{$email|escape:"mail"}<br>

{*
 * quotes: クォーテーション文字中心の簡易エスケープ（改行などは対象外）
 * 主な用途: クォート文字の簡易エスケープ
 * 出力イメージ: クォート崩れは抑えられるが、改行や制御文字を含むJS文字列には不向き
 *}
quotes：{$quoteText|escape:"quotes"}<br>

{*
 * javascript: JS文字列リテラル向けにクォート・改行・記号などをエスケープ
 * 主な用途: JS文字列リテラルへの安全な埋め込み
 * 出力イメージ: \n や ' や </script> による構文破壊を防ぎつつJS文字列へ渡せる（構造化データは json_encode も検討）
 * 現在は、HTMLタグのデータ属性にjson_encode化して埋め込むか、API経由で渡すほうが主流です
 *}
javascript：<script>const jsText = '{$jsText|escape:"javascript"}';</script><br>

{*
 * hex: 文字を16進数文字列に変換
 * 主な用途: 文字列の16進数化（用途は限定的）
 * 出力イメージ: `%41%42` のような16進文字列の並びになる（そのまま表示すると16進数が見える）
 * JSまたは受け取った側で 16進数をデコード／パースすることを想定している（実際の利用場面はかなり限定的）
 *}
hex：{$hexText|escape:"hex"}<br>

{*
 * hexentity: 文字列を16進数値文字参照（&#x...;）に変換する修飾子。
 * 主な用途: メールアドレス等の難読化・エンティティ化。
 * 出力イメージ: &#x41; のような16進数値文字参照になる
 * XSS対策としての成立条件・文脈依存性（hrefのjavascript:やJS文脈など）は escape:"html" と同じ。
 * 通常のHTMLエスケープ目的では escape:"html"（または escape_html = true）を使う。
 *}
hexentity：{$email|escape:"hexentity"}<br>
