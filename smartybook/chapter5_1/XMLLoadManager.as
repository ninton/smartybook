/**
 * XMLのロードマネージャー
 *
 * @description		XMLを読み込んでXMLオブジェクトを返します。
 * @author			kara_d
 * @version			0.1[2008/01/24]
 * @see            
 */

package {
	//import類
	import flash.events.Event;
	import flash.net.URLLoader;
	import flash.net.URLLoaderDataFormat;
	import flash.net.URLRequest;
	import flash.events.Event;
	//class記述
	public class XMLLoadManager {
		//メンバ宣言
		var urlLoader:URLLoader;
		var xml:XML;
		var url:String;
		var fCallback:Function;
		/**
		 * コンストラクタ
		 * @param
		 */ 
		public function XMLLoadManager() {
			
		}
		/**
		 * XMLのロード：コールバック関数を登録
		 * @param	_sXmlUrl:String, _fCallback:Function
		 */
		public function loadXML (_sUrl:String, _fCallback:Function):void {
			url = _sUrl;
			fCallback = _fCallback;
			urlLoader = new URLLoader();
			urlLoader.dataFormat = URLLoaderDataFormat.TEXT;
			urlLoader.addEventListener(Event.COMPLETE, onXmlLoaded);
			var urlReq:URLRequest = new URLRequest(url);
			urlLoader.load(urlReq);
		}
		/**
		 * XMLのロード後実行
		 * @param	event:Event
		 */
		private function onXmlLoaded(event:Event):void {
			try {
				xml = new XML(urlLoader.data);
				//登録されたコールバック関数を実行
				fCallback(xml);
			} catch (error:TypeError) {
				trace(error.message);
			}
		}
	}
}

