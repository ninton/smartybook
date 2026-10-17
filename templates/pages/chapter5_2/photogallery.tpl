import SmartyPG from './js/smarty-pg.js';

// SmartyPGオブジェクトの作成
function createSmartyPG() {
    // 画像ファイルの配列をSmartyを使って生成
    var imgs = new Array(
        {{foreach from=$images item="item" name="images"}}
            "{{$item}}"
            {{if !$smarty.foreach.images.last}},{{/if}}
        {{/foreach}}
        );
    var slideFlag = "{{$slideFlag}}";
    var slideTerm = {{$slideTerm}};
    mySmartyPG = new SmartyPG(imgs, slideFlag, slideTerm);
}

//------------------------------------------------------
// 画像表示の処理の開始
try {
    window.addEventListener("load", createSmartyPG, false);
} catch(e) {
    window.attachEvent("onload", createSmartyPG);
}
