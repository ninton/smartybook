<?php
/*
	image_resize( $i_src_path, $i_dst_path, $i_maxW = 640, $i_maxH = 640, $i_quality = 75 )
�@	1�Ԗڂ̈����́A�R�s�[���̃t�@�C���p�X�ł��B
�@	2�Ԗڂ̈����́A�R�s�[��̃t�@�C���p�X�ł��B
�@	3�ԖځA4�Ԗڂ̓R�s�[��摜�̍ő�g�̕��ƍ����ŁA
�@	���̍ő�g�Ɏ��܂�悤�ɁA�R�s�[���摜�̕��ƍ����̔䗦���ێ������܂܏k�����܂��B
�@	���Ƃ��Ǝ��܂�ꍇ�́A�����T�C�Y�̂܂܃R�s�[���܂��B
*/
/*
	$type
	1. �������������Ă���
	2. ���������������Ă���
	3. ���E�����Ƃ��ɒ����Ă��āA�������ɏk�߂�K�v������
	4. ���E�����Ƃ��ɒ����Ă��āA�c�����ɏk�߂�K�v������
*/

function image_resize( $i_src_path, $i_dst_path, $i_maxW = 640, $i_maxH = 640, $i_quality = 75 )
{
	$srcW	= 0;
	$srcH	= 0;
	$type	= 0;
	$dstW	= 0;
	$dstH	= 0;
	$src_im	= null;
	$dst_im	= null;
	$rc		= 0;
	
	list($srcW, $srcH) = getimagesize($i_src_path);
	if ( ($srcW <= $i_maxW) && ($srcH <= $i_maxH) ) {
		$type = 0;
	} else if ( ($i_maxW < $srcW) && ($srcH <= $i_maxH) ) {
		$type = 1;
	}
	else if ( ($srcW <= $i_maxW) && ($i_maxH < $srcH) ) {
		$type = 2;
	}
	else if ( $srcH/$i_maxH <= $srcW/$i_maxW ) {
		$type = 3;
	}
	else if ( $srcW/$i_maxW <  $srcH/$i_maxH ) {
		$type = 4;
	}
	else {
		assert( 0 );
		exit();
	}
	
	switch ( $type ) {
	case 0:
		$dstW = $srcW;
		$dstH = $srcH;
		break;

	case 1:
	case 3:
		$dstW = $i_maxW;
		$dstH = $srcH * $dstW / $srcW;
		break;
	
	case 2:
	case 4:
		$dstH = $i_maxH;
		$dstW = $srcW * $dstH / $srcH;
		break;
	
	default:
		assert( 0 );
		exit();
	}
	// printf( "type: %d\n", $type );
	// printf( "dstW: %d, dstH: %d\n", $dstW, $dstH );

	$pi = pathinfo($i_src_path);
	switch ( strtolower($pi['extension']) ) {
	case 'jpg':
		$src_im = imagecreatefromjpeg( $i_src_path );
		break;
	case 'gif':
		$src_im = imagecreatefromgif( $i_src_path );
		break;
	case 'png':
		$src_im = imagecreatefrompng( $i_src_path );
		break;
	default:
		die();
	}	
	
	$dst_im = imagecreatetruecolor( $dstW, $dstH );
	
	$rc = imagecopyresized( $dst_im, $src_im, 0, 0, 0, 0, $dstW, $dstH, $srcW, $srcH );
	imagejpeg ( $dst_im, $i_dst_path, $i_quality );
	
	imagedestroy( $dst_im );
	imagedestroy( $src_im );
	
	return $rc;
}

?>