<?php

/**
 *	$_SERVER�ϐ����U�����āA
 *	PEAR::Net_UserAgent_Mobile�ŁA
 *	softbank�̃E�F�u�R���e���c�r���[�A�̒[������������悤�ɂ���
 */
foreach ( $_SERVER as $key => $value ) {
	if ( preg_match('/^HTTP_X_EMULATOR_/', $key) ) {
		$jhone_key = preg_replace('/^HTTP_X_EMULATOR_/', 'HTTP_X_JPHONE_', $key);
		$_SERVER[$jhone_key] = $_SERVER[$key];
	}
}

// Net_UserAgent_Mobile-0.31.0 ����s�v
// if ( preg_match('/^Vemulator/', $_SERVER['HTTP_USER_AGENT']) ) {
//	$_SERVER['HTTP_USER_AGENT'] = preg_replace('/^Vemulator/', 'Vodafone', $_SERVER['HTTP_USER_AGENT']);
// }
// if ( preg_match('/^Semulator/', $_SERVER['HTTP_USER_AGENT']) ) {
//	$_SERVER['HTTP_USER_AGENT'] = preg_replace('/^Semulator/', 'Softbank', $_SERVER['HTTP_USER_AGENT']);
// }

?>