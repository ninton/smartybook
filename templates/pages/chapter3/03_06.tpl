サイトタイトル：{$bookmark->title|escape:'html'}<br />
URL：<a href="{$bookmark->url|escape:'html'}">{$bookmark->url|escape:'html'}</a><br />
ブックマークした日付：{$bookmark->date|escape:'html'}<br />
{$bookmark->getAgo()|escape:'html'}日前にブックマーク
