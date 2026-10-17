import SmartyPG from './js/smarty-pg.js';

// 画像ファイルの配列をSmartyを使って生成
var imgs = new Array(
    {{foreach from=$images item="item" name="images"}}
        "{{$item}}"
        {{if !$smarty.foreach.images.last}},{{/if}}
    {{/foreach}}
    );
var slideFlag = "{{$slideFlag}}";
var slideTerm = {{$slideTerm}};
new SmartyPG(imgs, slideFlag, slideTerm);
