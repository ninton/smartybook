import SmartyPG from './js/smarty-pg.js';

// 画像ファイルの配列をSmartyでJSON文字列化して安全かつシンプルに渡す
const images = {{$images|json_encode}};
const slideFlag = "{{$slideFlag}}";
const slideTerm = {{$slideTerm}};

new SmartyPG(images, slideFlag, slideTerm);
