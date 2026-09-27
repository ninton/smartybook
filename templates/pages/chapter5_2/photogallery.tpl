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
/**
 * フォトギャラリークラス
 *
 * @version 1.1
 * @author  Ryo Kawanobe
 */
var SmartyPG = function(imgs, slideFlag, slideTerm) {
    this.mainDiv = document.getElementById("pg_main");
    this.thumbDiv = document.getElementById("pg_thumb");
    this.controllerDiv = document.getElementById("pg_controller");
    this.mainImgIdName = "mainImgBox";
    this.controllerIdName = "controllerBox";
    this.thumbAreaIdName = "thumbArea";
    this.mainImg;
    this.thumbArea;
    this.imgArray = new Array();
    this.nowNum = 0;
    this.imgs = imgs;
    this.imgsLength = imgs.length;
    this.nLoaded = 0;
    this.slideFlag = slideFlag;
    this.slideTerm = slideTerm;
    this.timer;
    this.nowOpa;
    if(imgs.length > 0) {
        this.mainDiv.innerHTML = "Now Loading...";
        this.preloadImg();
    } else {
        this.mainDiv.innerHTML = "There is no image.";
    }
}
// 画像のプリロード
SmartyPG.prototype.preloadImg = function() {
    var thisObj = this;
    this.timer = setTimeout(
                                      function(){
                                          thisObj.mainDiv.innerHTML = "Timeout.";
                                      },
                                      5000
                        );
    var imgs = thisObj.imgs;
    var imgsLength = thisObj.imgsLength;
    var imgArray = thisObj.imgArray;
    for(var i = 0; i < imgsLength; i++) {
        imgArray[i] = new Image();
        imgArray[i].onload = function(){ thisObj.checkImgLoading(); };
        imgArray[i].src = imgs[i];
    }
}
// 画像ロードのチェック
SmartyPG.prototype.checkImgLoading = function() {
    var thisObj = this;
    // 全ての画像の読み込みを完了したらスタート
    if(++thisObj.nLoaded >= thisObj.imgsLength) {
        clearTimeout(thisObj.timer);
        thisObj.createThumbImg();
        thisObj.createController();
        thisObj.mainDiv.innerHTML = "";
        thisObj.createMainImg();
        thisObj.fadein(1);
    }
}
// サムネイル作成
SmartyPG.prototype.createThumbImg = function() {
    var thisObj = this;
    var imgsLength = thisObj.imgsLength;
    var imgs = thisObj.imgs;
    var imgArray = thisObj.imgArray;
    
    var thumbArea = document.createElement("div");
    thumbArea.setAttribute("id", thisObj.thumbAreaIdName);
    thumbArea.setAttribute("class", "clearfix");
	
    thisObj.thumbDiv.appendChild(thumbArea);
    thisObj.thumbArea = thumbArea;
    
    // 画像数分サムネイルを作成
    for(var i = 0; i < imgsLength; i++) {
        var thumbBox = document.createElement("div");
        thumbBox.className = "thumb thumbOff";
        thumbBox.onmouseover = function(){this.className = this.className + " thumbOver";};
        thumbBox.onmouseout = function(){this.className = this.className.split("thumbOver")[0];};
        thumbArea.appendChild(thumbBox);
        
        var thumbAnchor = document.createElement("a");
        thumbAnchor.setAttribute("href", "javascript:void(0);");
        thumbAnchor.num = i;
        thumbAnchor.onclick = function(){
            // サムネイルをクリックしたときの処理
            SmartyPG.changeOpacity(this, 100);
            clearTimeout(thisObj.timer);
            thisObj.changeActiveThumb(thisObj.nowNum, this.num);
            thisObj.changeImg(this.num);
            thisObj.nowNum = this.num;
            if(thisObj.slideFlag == "on") thisObj.fadein(1);
        };
        thumbBox.appendChild(thumbAnchor);
        
        // サムネイルのサイズをCSSから取得
        var thumbAStyle = thumbAnchor.currentStyle || document.defaultView.getComputedStyle(thumbAnchor, '');
        var thumbAW = thumbAStyle.width.split("px")[0];
        var thumbAH = thumbAStyle.height.split("px")[0];
        // サムネイルの画像のサイズを少し大きめにとる（cssのoverflow:hiddenではみ出した部分は後でカットする）
        var thumbObjW = thumbAW * 3;
        var thumbObjH = thumbAH * 3;
        
        var thumbObj = imgArray[i];
        var aspect = thumbObj.height / thumbObj.width;
        // 縦横比を維持したサムネイル画像のサイズを指定
        if(aspect <= 0) {
            thumbObj.width = thumbObjW;
            thumbObj.height = thumbObjW * aspect;
        } else {
            thumbObj.height = thumbObjH;
            thumbObj.width = thumbObjH / aspect;
        }
        // サムネイル画像の位置を指定
        thumbObj.style.top = Math.floor((thumbAH - thumbObj.height) / 2) + "px";
        thumbObj.style.left = Math.floor((thumbAW - thumbObj.width) / 2) + "px";
        
        // サムネイルを表示
        thumbAnchor.appendChild(thumbObj);
    }
    thisObj.changeActiveThumb(thisObj.nowNum, 0);
}
// コントロールボタン作成
SmartyPG.prototype.createController = function() {
	var thisObj = this;
    var controllerBox = document.createElement("div");
    controllerBox.setAttribute("id", thisObj.controllerIdName);
    var controllerObj = document.createElement("a");
    controllerObj.setAttribute("href", "javascript:void(0);");
    controllerObj.setAttribute("id", thisObj.slideFlag);
    var textObj = document.createTextNode("SLIDE SHOW : " + thisObj.slideFlag);
    controllerObj.appendChild(textObj);
    controllerBox.appendChild(controllerObj);
    controllerObj.onclick = function() {
        // スライドショーon/offスイッチをクリックしたときの処理
        clearTimeout(thisObj.timer);
        if(thisObj.slideFlag == "on") {
            thisObj.slideFlag = "off";
            textObj.nodeValue = "SLIDE SHOW : off";
            this.id = "off";
        } else {
            thisObj.slideFlag = "on";
            textObj.nodeValue = "SLIDE SHOW : on";
            this.id = "on";
            thisObj.fadeout(thisObj.nowOpa);
        }
    };
    thisObj.controllerDiv.appendChild(controllerBox);
}
// メインイメージ作成
SmartyPG.prototype.createMainImg = function() {
    var thisObj = this;
    var mainImg = document.createElement("div");
    mainImg.setAttribute("id", thisObj.mainImgIdName);
    thisObj.mainDiv.appendChild(mainImg);
    thisObj.mainImg = mainImg;
    SmartyPG.changeOpacity(mainImg, 0);
    thisObj.changeImg(0);
}
// メインイメージ変更
SmartyPG.prototype.changeImg = function(num) {
    this.mainImg.style.backgroundImage = "url(" + this.imgs[num] + ")";
}
// アクティブサムネイル変更
SmartyPG.prototype.changeActiveThumb = function(oldNum, newNum) {
    var thumbBoxs = this.thumbArea.childNodes;
    thumbBoxs[oldNum].className = "thumb thumbOff";
    thumbBoxs[newNum].className = "thumb thumbOn";
}
// フェードイン
SmartyPG.prototype.fadein = function(opa) {
    var thisObj = this;
    clearTimeout(thisObj.timer);
    if(opa < 95) {
        opa = Math.ceil(opa * 1.1);
        SmartyPG.changeOpacity(thisObj.mainImg, opa);
        thisObj.nowOpa = opa;
        thisObj.timer = setTimeout(function(){thisObj.fadein(opa);}, 1);
    } else {
        thisObj.nowOpa = 100;
        SmartyPG.changeOpacity(thisObj.mainImg, 100);
        thisObj.timer = setTimeout(function(){thisObj.fadeout(100);}, thisObj.slideTerm);
    }
}
// フェードアウト
SmartyPG.prototype.fadeout = function(opa) {
    var thisObj = this;
    clearTimeout(thisObj.timer);
    if(opa > 5) {
        opa = Math.floor(opa / 10 * 9);
        SmartyPG.changeOpacity(thisObj.mainImg, opa);
        thisObj.nowOpa = opa;
        thisObj.timer = setTimeout(function(){thisObj.fadeout(opa);}, 1);
    } else {
        var newNum;
        if(thisObj.nowNum < thisObj.imgsLength - 1) newNum = thisObj.nowNum + 1;
        else newNum = 0;
        thisObj.nowOpa = 0;
        thisObj.changeActiveThumb(thisObj.nowNum, newNum);
        thisObj.changeImg(newNum);
        thisObj.fadein(1);
        thisObj.nowNum = newNum;
    }
}
// 透明度変更
SmartyPG.changeOpacity = function(e, opacity) {
    if(typeof e == "string") var obj = document.getElementById(e).style;
    else if(typeof e == "object") var obj = e.style;
    obj.opacity = (opacity / 100);                 // Safari1.2
    obj.MozOpacity = (opacity / 100);              // Mozilla
    obj.KhtmlOpacity = (opacity / 100);            // Safari1.1
    obj.filter = "alpha(opacity=" + opacity + ")"; // IE
}

//------------------------------------------------------
// 画像表示の処理の開始
try {
    window.addEventListener("load", createSmartyPG, false);
} catch(e) {
    window.attachEvent("onload", createSmartyPG);
}