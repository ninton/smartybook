<?php
require_once( './_read/inc.php' );

if ( empty($_REQUEST['ListId']) ) {
	$_REQUEST['ListId'] = 1;
}
$mylistmgr = new MyListManager( $CFG['max_items'], $CFG['mylist_dir'] );
$mylist = $mylistmgr->read($_REQUEST['ListId']);

$appAmazon = new AppAmazon( $CFG['access_key_id'], $CFG['associate_id'], $CFG['aws_cache_dir'] );
$options['ResponseGroup'] = 'Medium';
$message = $appAmazon->ItemLookup( $mylist->getASINs(), $options, $Item_arr );
$mylist->setItems( $Item_arr );

$smarty = new AppSmarty();
$smarty->assign( "CFG"    ,  $CFG     );
$smarty->assign( "message",  $message );
$smarty->assign( "mylist", $mylist );
$smarty->display( 'view.tpl' );
