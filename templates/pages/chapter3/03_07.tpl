{* 予約変数 {$smarty} の利用方針サンプル
 *   ◯: $smarty.config（.conf設定）、$smarty.section / $smarty.foreach（ループ制御）
 *   △: $smarty.version / $smarty.template / $smarty.now（デバグ・簡易確認用途）
 *   ☓: $smarty.get / $smarty.post / $smarty.session 等、$smarty.const、$smarty.capture
 *}
{config_load file='pages/chapter3/03_07.conf'}
Smartyのバージョン：{$smarty.version}<br>
現在日時：{$smarty.now|date_format:"%Y-%m-%d %H:%M:%S"}<br>
テンプレートのパス：{$smarty.template}<br>
書籍名：{$smarty.config.name}<br>
