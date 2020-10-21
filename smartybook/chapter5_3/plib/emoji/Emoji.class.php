<?php
/*

	例
	----------	----------	----------	----------	----------
		emoji_output_setting( 'i_uni16', 's_webcode' );
		emoji_output_setting( 's_uni16', 's_webcode' );
		ob_start( "emoji_output_handler" );
	----------	----------	----------	----------	----------
		$buf = emoji_convert( $buf, 'i_uni16', 's_webcode' );
	----------	----------	----------	----------	----------

*/
$emoji_output_setting_arr = array();

function emoji_convert_variables( &$io_vars, $i_from_encode, $i_to_encode ) {

	$emoji = Emoji::singleton( $i_from_encode, $i_to_encode );
	$emoji->convert_variables( $io_vars );
}

function emoji_output_setting( $i_from_encode = '', $i_to_encode = '') {
	global	$emoji_output_setting_arr;

	if ( '' == $i_from_encode ) {
		$emoji_output_setting_arr = array();
	} else {
		$setting = array(
			'from' => $i_from_encode,
			'to'   => $i_to_encode
			);
		$emoji_output_setting_arr[] = $setting;
	}
}

function emoji_output_handler( $i_buf ) {
	global	$emoji_output_setting_arr;

	$buf = $i_buf;
	foreach ( $emoji_output_setting_arr as $i => $setting ) {
		$buf = emoji_convert( $buf, $setting['from'], $setting['to'] );
	}
	
	return $buf;
}

function emoji_convert( $i_buf, $i_from_encode, $i_to_encode  ) {
	$emoji = Emoji::singleton( $i_from_encode, $i_to_encode );
	$buf = $emoji->convert( $i_buf );
	return $buf;
}

class Emoji {
	var $from_encode;
	var	$to_encode;
	var	$regex;
	var	$map;
	
	function Emoji ( $i_from_encode, $i_to_encode ) {
		$this->from_encode  = $i_from_encode;
		$this->to_encode    = $i_to_encode;

		$regex_arr = $this->get_regex_arr();
		$this->regex = $regex_arr[$i_from_encode];
		
		$this->load();
	}
	
	function singleton( $i_from_encode, $i_to_encode ) {
		static $instance;
		if ( ! isset($instance[$i_from_encode][$i_to_encode]) ) {
			$instance[$i_from_encode][$i_to_encode] = new Emoji( $i_from_encode, $i_to_encode );
		}
		return $instance[$i_from_encode][$i_to_encode];
	}
	
	function get_regex_arr () {
		return array(
			'i_sjisbin'		=> '/(\xF8[\x90-\xFF]|\xF9[\x40-\xFF])/e'			,
			'i_sjis10'		=> '/(&#63[678][0-9][0-9];)/ie'						,
			'i_sjis16'		=> '/(&#x(F8[9A-F]|F9[4-9A-F])[0-9A-F];)/ie'		,
			'i_uni16'		=> '/(&#x(E6|E7)[0-9A-F]{2};)/ie'			,
			'i_unibin'		=> '/([\xE6\xE7].;)/e'			,
			'i_utf8'		=> '/\xEE[\x98-\x9D][\x80-\xBF]/e'					,

			'e_img_num'		=> '/<img .*?localsrc=[\"]?([0-9]+)".*?>/ie'		,
			'e_img_name'	=> '/<img .*?localsrc=[\"]?([0-9A-Z]+)[\"]?.*?>/ie'	,
			'e_icon_num'	=> '/<img .*?icon=[\"]?([0-9]+)[\"]?.*?>/ie'		,
			'e_icon_name'	=> '/<img .*?icon=[\"]?([0-9A-Z]+)[\"]?.*?>/ie'		,
			'e_sjis16'		=> '/(&#x(F3|F4|F6|F7)[0-9A-F]{2};)/ie'				,
			'e_sjisbin'		=> '/([\xF3\xF4\xF6\xF7].)/e'						,
			'e_uni16'		=> '/(&#x(E4|E5|EA|EB)[0-9A-F]{2};)/ie'				,
			'e_unibin'		=> '/([\xE4\xE5\xEA\xEB].)/'						,
			'e_utf8'		=> '/\xEE[\x91-\x97\xA0-\xAD][\x80-\xBF]/e'			,
			'e_email_jis16'	=> '/(&#x7[56789AB][0-9A-F]{2};)/ie'				,
			'e_email_sjis16'=> '/(&#x(EB|EC|ED|EE)[0-9A-F]{2};)/ie'				,
			'e_email_jisbin'=> '/([\x75-\x7B].)/e'								,
			'e_email_sjisbin'=>'/([\xEB-\xEE].)/e'								,

			's_uni16'		=> '/(&#x(E[0-5][0-9A-F]{2};)/ie'					,
			's_unibin'		=> '/([\xE0-\xE5].)/e'								,
			's_utf8'		=> '/\xEE[\x80-\x94][\x80-\xBF]/e'					,
			's_webcode'		=> '/\x1B\$[A-Z].\x0F/ie'							
		);
	}
	
	function get_encode_arr () {
		$arr = Emoji::get_regex_arr();
		return array_keys($arr);
	}
	
	function clear() {
		$this->map = array();
	}
	
	function load() {
		$path = $this->map_path();

		$this->map = array();
		$buf = @file_get_contents( $path );
		if ( '' == $buf ) {
			return;
		}
		$this->map = unserialize( $buf );
		if (0) {
			$arr = explode( "\n", $buf );
			foreach ( $arr as $i => $line ) {
				list($from, $to) = explode( "\t", $line );
				$this->map[$from] = $to;
			}
		}
	}
	
	function save() {
		if (0) {
			$arr = array();
			foreach ( $this->map as $from => $to ) {
				$arr[] = $from . "\t" . $to . "\t.\n";
			}
			$buf = join("", $arr);
		}
		$buf = serialize( $this->map );
		$path = $this->map_path();
		
		file_put_contents( $path, $buf );
	}

	function map_path() {
		$fname = "{$this->from_encode}.{$this->to_encode}.dat";
		$path = dirname( __FILE__ ) . "/map/$fname";
		return $path;
	}
	
	function add( $i_from, $i_to, $i_text = '' ) {
		switch ( $i_from ) {
		case '':
		case 'x':
		case '-':
			return;
		}
		
		$from = $this->modifier( $i_from, $this->from_encode );
		
		switch ( $i_to ) {
		case '':
		case 'x':
		case '-':
			$to = $i_text;
			break;
		
		default:
			$to   = $this->modifier( $i_to  , $this->to_encode   );
			break;
		}
		
		$this->map[ $from ] = $to;
//var_dump( $this->map );
	}
	
	function modifier( $i_buf, $i_encode ) {
		switch ( $i_encode ) {
		case 'i_uni16':
		case 'i_sjis16':
		case 'e_sjis16':
		case 'e_uni16':
		case 's_uni16':
			$buf = sprintf( '&#x%s;', $i_buf );
			break;

		case 'i_sjis10':
			$buf = sprintf( '&#%s;', $i_buf );
			break;

		case 'i_unibin':
		case 'i_sjisbin':
		case 'e_sjisbin':
		case 'e_unibin':
		case 'e_email_jisbin':
		case 'e_email_sjisbin':
		case 's_unibin':
			$buf = $this->pack_16_bin( $i_buf );
			break;
			
		case 'i_utf8':
		case 'e_utf8':
		case 's_utf8':
			$buf = $this->pack_16_bin( $i_buf );
			$buf = mb_convert_encoding( $buf, 'UTF-8', 'UCS2' );
			break;
			
		case 's_webcode':
			$buf = sprintf( "\x1B\$%s\x0F", $i_buf );
			break;
			
		case 'e_icon_num':
		case 'e_icon_name':
			$buf = sprintf( '<img icon="%s">', $i_buf );
			break;

		case 'e_img_name':
		case 'e_img_num':
			$buf = sprintf( '<img localsrc="%s" />', $i_buf );
			break;
			
		default:
			$buf = $i_buf;
			break;
		}
		
		return $buf;
	}

	function convert( $i_buf ) {
		$_GLOBALS['Emoji'] = $this;
		$buf = preg_replace( $this->regex, "\$_GLOBALS['Emoji']->mapping('\\1')", $i_buf );
		return $buf;
	}
	
	function mapping( $i_buf ) {
		switch ( $this->from_encode ) {
		case 'e_img_num':
		case 'e_img_name':
			$buf = $this->modifier( $i_buf, $this->from_encode );
			break;
			
		case 'e_icon_num':
		case 'e_icon_name':
			$buf = $this->modifier( $i_buf, $this->from_encode );
			break;
		
		default:
			$buf = $i_buf;
		}

		if ( isset($this->map[ $buf ]) ) {
			$buf = $this->map[ $buf ];
		}
		return "$buf";
	}
	
	function pack_16_bin( $i_buf ) {
		$buf = '';
		if ( preg_match('/^[0-9A-F]{4}$/i', $i_buf) ) {
			$buf = pack('H4', $i_buf );			
		}
		return $buf;
	}

	function convert_variables ( &$io_vars ) {
		foreach ( $io_vars as $key => $val ) {
			if ( is_array($val) ) {
				$this->convert_variables( $val );
			} else {
				$val = $this->convert( $val );
			}
			
			$io_vars[$key] = $val;
		}
	}
}



?>