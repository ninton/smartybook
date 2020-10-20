/**
 * 文字の表示エフェクト
 *
 * @description    文字を表示させます。
 * @author　　　 kara_d
 * @version        0.1[2008/01/23]
 * @see            
 */

package {
	//import類
	import flash.events.Event;
	import flash.display.*;
	//class記述
	public class DisplayTextAS3 {
		//メンバ宣言
		var target:MovieClip;
		var target_txt:String;
		var sText:String;
		var i:Number = 0;
		var sDisplayText:String = "";
		/**
		 * コンストラクタ
		 * @param
		 */
		function DisplayTextAS3 () {
		}
		/**
		 * htmlTextを「_」付きで順に表示する
		 * @param
		 */
		public function slowlyDisplayText (_target_mc:MovieClip, _target_txt:String, _sText:String) {
			//初期化
			target = _target_mc;
			target_txt = _target_txt;
			sText = _sText;
			i = 0;
			sDisplayText = "";
			//表示
			target.addEventListener ( Event.ENTER_FRAME, onEnterFrameHandler );
		}
		/**
		 * EnterFrame イベントのハンドラを定義
		 * @param
		 */
		public function onEnterFrameHandler ( event:Event ):void {
			if (i <= sText.length) {
				sDisplayText += sText.charAt(i);
				target[target_txt].text = "" + sDisplayText + "_";
				i++;
			} else {
				target[target_txt].text = "" + sDisplayText + "";
				target.removeEventListener (Event.ENTER_FRAME, onEnterFrameHandler);
			}
		}
	}

}