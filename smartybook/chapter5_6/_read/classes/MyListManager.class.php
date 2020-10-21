<?php

class MyListManager {
	var $max_items;
	var	$dir;

	function MyListManager ($i_max_items, $i_dir) {
		$this->max_items = $i_max_items;
		$this->dir = $i_dir;
	}
	
	function read( $i_ListId ) {
		$path = $this->getPath($i_ListId);
		
		if ( ! file_exists($path) ) {
			die();
		}
		
		$buf = file_get_contents($path);
		if ( $buf ) {
			$mylist = unserialize( $buf );
			$mylist->item_arr    = array_slice($mylist->item_arr, 0, $this->max_items);
		} else {
			$mylist = new MyList();
			$mylist->ListId = $i_ListId;
		}
		
		return $mylist;
	}

	function write( $i_MyList ) {
		$buf = serialize( $i_MyList );
		file_put_contents( $this->getPath($i_MyList->ListId), $buf );
	}
	
	function getPath($i_ListId) {
		if ( preg_match('/[^0-9A-Za-z]/', $i_ListId) ) {
			die();
		}
		
		return sprintf( '%s%s.txt', $this->dir, $i_ListId);
	}

	function create( &$io_MyList ) {
		// 未実装
	}

	function readList( $i_offset, $i_length ) {
		// 未実装
	}
	
	function delete( $i_ListId ) {
		// 未実装
	}
}

?>