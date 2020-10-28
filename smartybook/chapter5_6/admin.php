<?php
//	GET show=
//	GET show=form
//	GET show=preview
//	POST cmdPreview=
//	POST cmdSave
//	POST cmdForm=
//	POST cmdLoad=
require_once( './_read/inc.php' );

$show = '';
if (isset($_GET['show'])) {
    $show = $_GET['show'];
}

switch ( strtolower($_SERVER['REQUEST_METHOD']) ) {
case 'get':
	switch ( $show ) {
	case '':
	case 'preview':
		if ( empty($_REQUEST['ListId']) ) {
			$_REQUEST['ListId'] = 1;
		}
		$mylistmgr =& new MyListManager( $CFG['max_items'], $CFG['mylist_dir'] );
		$mylist =& $mylistmgr->read($_REQUEST['ListId']);
		
		$appAmazon = &new AppAmazon( $CFG['access_key_id'], $CFG['associate_id'], $CFG['aws_cache_dir'] );
		$options['ResponseGroup'] = 'Medium';
		$message = $appAmazon->ItemLookup( $mylist->getASINs(), $options, $Item_arr );
		$mylist->setItems( $Item_arr );
		
		$smarty = new AppSmarty();
		$smarty->assign( "CFG"    ,  $CFG     );
		$smarty->assign( "message",  $message );
		$smarty->assign( "mylist",   $mylist  );
		$smarty->display( 'admin_preview.tpl' );
		break;
		
	case 'form':
	    $message = '';
		$mylistmgr =& new MyListManager( $CFG['max_items'], $CFG['mylist_dir'] );
		$mylist =& $mylistmgr->read($_REQUEST['ListId']);

		$smarty = new AppSmarty();
		$smarty->assign( "CFG"    ,  $CFG     );
		$smarty->assign( "message",  $message );
		$smarty->assign( "mylist",   $mylist  );
		$smarty->display( 'admin_form.tpl' );
		break;

	default:
		break;
	}
	break; // case 'get':

case 'post':
	switch ( App::get_cmd() ) {
	case 'cmdSave':
		$mylistmgr =& new MyListManager( $CFG['max_items'], $CFG['mylist_dir'] );
		$mylist =& $mylistmgr->read($_REQUEST['ListId']);
		$mylist->input( $_POST );

		$appAmazon = &new AppAmazon( $CFG['access_key_id'], $CFG['associate_id'], $CFG['aws_cache_dir'] );
		$options['ResponseGroup'] = 'Small';
		$message = $appAmazon->ItemLookup( $mylist->getASINs(), $options, $item_arr );
		$mylist->setItems( $item_arr );
		
		if ( $message != '' ) {
			$smarty = new AppSmarty();
			$smarty->assign( "CFG"    ,  $CFG     );
			$smarty->assign( "message",  $message );
			$smarty->assign( "mylist",   $mylist  );
			$smarty->display( 'admin_form.tpl' );
		} else {
			$mylistmgr->write($mylist);
			App::redirect( '?show=preview&ListId=' . $_REQUEST['ListId']);
		}
		break;

	case 'cmdCancel':
		App::redirect( '?show=preview&ListId=' . $_REQUEST['ListId'] );
		break;
		
	default:
		break;
	}
	break; // case 'post':

default:
	break;
}
