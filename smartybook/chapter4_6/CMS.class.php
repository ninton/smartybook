<?php
require_once( 'DB.php' );

/**
 *	テーブルCMSの読み出し操作
 */
class CMS {
	var	$db;
	
	/**
	 *	@param	string
	 *	@param	array
	 *	@return void
	 */
	function CMS ($i_dsn, $i_options = null) {
		$this->db = DB::connect($i_dsn, $i_options);
		if ( PEAR::isError($this->db) ) {
			die( $this->db->getMessage() );
		}
		$this->db->query( 'SET NAMES UTF8' );
	}

	/**
	 *	@return	integer
	 */
	function getCount () {
		$row = $this->db->getOne('SELECT COUNT(id) FROM cms');
		return $row[0];
	}

	/**
	 *	@param	integer
	 *	@param	integer
	 *	@param	string
	 *	@param	string
	 *	@return	array
	 */
	function getAll ( $i_offset, $i_limit, $i_sort, $i_order ) {
		// 安全な値かどうかをチェックする
		switch( $i_sort ){
		case 'id':
		case 'category':
		case 'title':
		case 'comment':
		case 'time':
			break;
		default:
			die();
		}

		switch( $i_order ){
		case 'asc':
		case 'desc':
			break;
		default:
			die();
		}

		$sort  = addslashes( $i_sort );
		$order = addslashes( $i_order );
		$offset= 0 + (int)$i_offset;
		$limit = 0 + (int)$i_limit;

		$data = array();
		$query = "SELECT * FROM cms ORDER BY $sort $order LIMIT $offset, $limit";
		$rcd_arr = $this->db->getAll($query, $data, DB_FETCHMODE_ASSOC);
		return $rcd_arr;
	}
}

?>