// noinspection JSUnusedGlobalSymbols tplでimportしています
/**
 * スライドショーギャラリー管理クラス
 */
export class SmartyPG {
  /**
   * @param {string[]} images 画像パスの配列
   * @param {string} slideFlag スライドショー初期状態 ('on' | 'off')
   * @param {number} slideTerm 切り替え間隔（ミリ秒）
   */
  constructor(images, slideFlag, slideTerm) {
    /** @type {HTMLElement | null} */
    this.mainDiv = document.getElementById('pg_main');
    /** @type {HTMLElement | null} */
    this.thumbDiv = document.getElementById('pg_thumb');
    /** @type {HTMLElement | null} */
    this.controllerDiv = document.getElementById('pg_controller');

    this.mainImgIdName = 'mainImgBox';
    this.controllerIdName = 'controllerBox';
    this.thumbAreaIdName = 'thumbArea';

    /** @type {HTMLElement | null} */
    this.mainImg = null;
    /** @type {HTMLElement | null} */
    this.thumbArea = null;

    /** @type {HTMLImageElement[]} */
    this.imgArray = [];
    this.nowNum = 0;
    this.imgs = images;
    this.imgsLength = images.length;
    this.nLoaded = 0;
    this.slideFlag = slideFlag;
    this.slideTerm = slideTerm;

    /** @type {ReturnType<typeof setTimeout> | null} */
    this.timer = null;
    this.nowOpa = 0;

    if (!this.mainDiv) return;

    if (images.length > 0) {
      this.mainDiv.innerHTML = 'Now Loading...';
      this.preloadImg();
    } else {
      this.mainDiv.innerHTML = 'There is no image.';
    }
  }

  /** 画像のプリロード */
  preloadImg() {
    if (this.timer) clearTimeout(this.timer);
    this.timer = setTimeout(() => {
      if (this.mainDiv) this.mainDiv.innerHTML = 'Timeout.';
    }, 5000);

    const images = this.imgs;
    const imagesLength = this.imgsLength;
    const imgArray = this.imgArray;

    for (let i = 0; i < imagesLength; i++) {
      imgArray[i] = new Image();
      imgArray[i].onload = () => {
        this.checkImgLoading();
      };
      imgArray[i].src = images[i];
    }
  }

  /** 画像ロードのチェック */
  checkImgLoading() {
    if (++this.nLoaded >= this.imgsLength) {
      if (this.timer) clearTimeout(this.timer);
      this.createThumbImg();
      this.createController();
      if (this.mainDiv) {
        this.mainDiv.innerHTML = '';
        this.createMainImg();
      }
      this.fadein(1);
    }
  }

  /** サムネイル作成 */
  createThumbImg() {
    if (!this.thumbDiv) return;

    const imagesLength = this.imgsLength;
    const imgArray = this.imgArray;

    const thumbArea = document.createElement('div');
    thumbArea.setAttribute('id', this.thumbAreaIdName);
    thumbArea.setAttribute('class', 'clearfix');

    this.thumbDiv.appendChild(thumbArea);
    this.thumbArea = thumbArea;

    for (let i = 0; i < imagesLength; i++) {
      const thumbBox = document.createElement('div');
      thumbBox.className = 'thumb thumbOff';
      thumbBox.onmouseover = function () {
        thumbBox.className = thumbBox.className + ' thumbOver';
      };
      thumbBox.onmouseout = function () {
        thumbBox.className = thumbBox.className.split('thumbOver')[0];
      };
      thumbArea.appendChild(thumbBox);

      const thumbAnchor = document.createElement('a');
      thumbAnchor.setAttribute('href', 'javascript:void(0);');

      // カスタムプロパティへの代入を JSDoc で型付け
      const anchorElement = /** @type {HTMLAnchorElement & { num: number }} */ (thumbAnchor);
      anchorElement.num = i;

      anchorElement.onclick = (e) => {
        const target = /** @type {HTMLAnchorElement & { num: number }} */ (e.currentTarget);
        SmartyPG.changeOpacity(target, 100);
        if (this.timer) clearTimeout(this.timer);
        this.changeActiveThumb(this.nowNum, target.num);
        this.changeImg(target.num);
        this.nowNum = target.num;
        if (this.slideFlag === 'on') this.fadein(1);
      };
      thumbBox.appendChild(anchorElement);

      const defaultView = document.defaultView;
      if (!defaultView) continue;

      const thumbAStyle = defaultView.getComputedStyle(anchorElement, '');
      const thumbAW = parseFloat(thumbAStyle.width) || 0;
      const thumbAH = parseFloat(thumbAStyle.height) || 0;

      const thumbObjW = thumbAW * 3;
      const thumbObjH = thumbAH * 3;

      const thumbObj = imgArray[i];
      const aspect = thumbObj.height / thumbObj.width;

      if (aspect <= 0) {
        thumbObj.width = thumbObjW;
        thumbObj.height = thumbObjW * aspect;
      } else {
        thumbObj.height = thumbObjH;
        thumbObj.width = thumbObjH / aspect;
      }

      thumbObj.style.top = `${Math.floor((thumbAH - thumbObj.height) / 2)}px`;
      thumbObj.style.left = `${Math.floor((thumbAW - thumbObj.width) / 2)}px`;

      anchorElement.appendChild(thumbObj);
    }
    this.changeActiveThumb(this.nowNum, 0);
  }

  /** コントロールボタン作成 */
  createController() {
    if (!this.controllerDiv) return;

    const controllerBox = document.createElement('div');
    controllerBox.setAttribute('id', this.controllerIdName);

    const controllerObj = document.createElement('a');
    controllerObj.setAttribute('href', 'javascript:void(0);');
    controllerObj.setAttribute('id', this.slideFlag);

    const textObj = document.createTextNode(`SLIDE SHOW : ${this.slideFlag}`);
    controllerObj.appendChild(textObj);
    controllerBox.appendChild(controllerObj);

    controllerObj.onclick = (e) => {
      const target = /** @type {HTMLAnchorElement} */ (e.currentTarget);
      if (this.timer) clearTimeout(this.timer);

      if (this.slideFlag === 'on') {
        this.slideFlag = 'off';
        textObj.nodeValue = 'SLIDE SHOW : off';
        target.id = 'off';
      } else {
        this.slideFlag = 'on';
        textObj.nodeValue = 'SLIDE SHOW : on';
        target.id = 'on';
        this.fadeout(this.nowOpa);
      }
    };

    this.controllerDiv.appendChild(controllerBox);
  }

  /** メインイメージ作成 */
  createMainImg() {
    if (!this.mainDiv) return;

    const mainImg = document.createElement('div');
    mainImg.setAttribute('id', this.mainImgIdName);
    this.mainDiv.appendChild(mainImg);
    this.mainImg = mainImg;

    SmartyPG.changeOpacity(mainImg, 0);
    this.changeImg(0);
  }

  /**
   * メインイメージ変更
   * @param {number} num
   */
  changeImg(num) {
    if (this.mainImg) {
      this.mainImg.style.backgroundImage = `url(${this.imgs[num]})`;
    }
  }

  /**
   * アクティブサムネイル変更
   * @param {number} oldNum
   * @param {number} newNum
   */
  changeActiveThumb(oldNum, newNum) {
    if (!this.thumbArea) return;
    const thumbBoxes = this.thumbArea.childNodes;
    if (thumbBoxes[oldNum]) {
      // noinspection JSUndefinedPropertyAssignment,JSValidateTypes
      /** @type {HTMLElement} */ (thumbBoxes[oldNum]).className = 'thumb thumbOff';
    }
    if (thumbBoxes[newNum]) {
      // noinspection JSUndefinedPropertyAssignment,JSValidateTypes
      /** @type {HTMLElement} */ (thumbBoxes[newNum]).className = 'thumb thumbOn';
    }
  }

  /**
   * フェードイン
   * @param {number} opa
   */
  fadein(opa) {
    if (this.timer) clearTimeout(this.timer);

    if (opa < 95) {
      opa = Math.ceil(opa * 1.1);
      SmartyPG.changeOpacity(this.mainImg, opa);
      this.nowOpa = opa;
      this.timer = setTimeout(() => {
        this.fadein(opa);
      }, 1);
    } else {
      this.nowOpa = 100;
      SmartyPG.changeOpacity(this.mainImg, 100);
      this.timer = setTimeout(() => {
        this.fadeout(100);
      }, this.slideTerm);
    }
  }

  /**
   * フェードアウト
   * @param {number} opa
   */
  fadeout(opa) {
    if (this.timer) clearTimeout(this.timer);

    if (opa > 5) {
      opa = Math.floor((opa / 10) * 9);
      SmartyPG.changeOpacity(this.mainImg, opa);
      this.nowOpa = opa;
      this.timer = setTimeout(() => {
        this.fadeout(opa);
      }, 1);
    } else {
      const newNum = this.nowNum < this.imgsLength - 1 ? this.nowNum + 1 : 0;
      this.nowOpa = 0;
      this.changeActiveThumb(this.nowNum, newNum);
      this.changeImg(newNum);
      this.fadein(1);
      this.nowNum = newNum;
    }
  }

  /**
   * 透明度変更（スタティックメソッド）
   * @param {HTMLElement | string | null} e
   * @param {number} opacity
   */
  static changeOpacity(e, opacity) {
    if (!e) return;
    /** @type {CSSStyleDeclaration | null} */
    let style = null;

    if (typeof e === 'string') {
      const elem = document.getElementById(e);
      if (elem) style = elem.style;
    } else if (typeof e === 'object' && 'style' in e) {
      style = e.style;
    }

    if (style) {
      style.opacity = String(opacity / 100);
    }
  }
}
