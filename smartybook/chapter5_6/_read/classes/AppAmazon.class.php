<?php
/**
 *	@author	MW web studio, Aoki Makoto, 2007-12
 */
require_once( 'Services/AmazonECS4.php' );

class AppAmazon {
	var	$amazon;
	
	/**
	 *	@param	string
	 *	@param	string
	 *	@param	string
	 *	@return	void
	 */
	function AppAmazon( $i_access_key_id, $i_associate_id, $i_cache_dir ) {
		$amazon = &new Services_AmazonECS4( $i_access_key_id, $i_associate_id );
		$amazon->setLocale( 'JP' );
		$amazon->setCache( 'file', array('cache_dir' => $i_cache_dir) );
		$amazon->setCacheExpire( 24 * 3600 );
		$this->amazon = $amazon;
	}
	
	/**
	 *	@param	string
	 *	@param	assoc
	 *	@param	array
	 *	@return	string	error message
	 */
	/*
	$ASINs = '12345,23456,34567';
	$options['ResponseGroup'] = 'Medium';
	$errmsg = $amazon->ItemLookup( $ASINs, $options, &$Item_arr ) {
	print_r( $Item_arr );

	$Item_arr[0]	ASIN�u12345�v��Item���
	$Item_arr[2]	ASIN�u23456�v��Item���
	$Item_arr[3]	ASIN�u34567�v��Item���
	*/
	function ItemLookup( $i_ASINs, $i_options, &$o_Item_arr ) {
		$ASIN_arr = split(',', $i_ASINs);

		// $ASIN_arr����10�Â⍇�킹���āA$o_Item_arr�ɒ~�ς���
		$o_Item_arr = array();
		for ( $i = 0; $i < count($ASIN_arr); $i += 10 ) {
			$ASINs = join(',', array_slice($ASIN_arr, $i, 10));
			if ( $ASINs != '' ) {
				$result = $this->amazon->ItemLookup( $ASINs, $i_options );
				if ( PEAR::isError($result) ) {
					return $result->message;
				}

				$o_Item_arr = array_merge( $o_Item_arr, $result['Item'] );
			}
		}
		return '';
	}
}
?>