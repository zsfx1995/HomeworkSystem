<?php
	 session_start();
	include_once("../../common/include/common.inc");
	include_once("../../common/class/baseDatabase.inc");
	include_once("../../common/class/baseTable.inc");
	include_once("../../common/class/admin_user.inc");
	include_once("../../common/class/error.inc");
	
	$password =  isset( $_POST['password'] ) ? $_POST['password'] : "";
	$username =  isset( $_POST['username'] ) ? $_POST['username'] : "";
	
	$admin_userObj = new admin_user();
	if(!$admin_userObj->createConnect()){
		$errorObj=$admin_userObj->getError();
		$errorObj->showErrors($show_sql_flag=false);
		
	}
	$admin_userObj->checkID( $username , $password );
	$recount = $admin_userObj -> getRecordCount();
	$admin_userObj -> getOneRecord();
	$uid = $admin_userObj -> getUid();
	
	if( $recount > 0 ){
		
		 if( isset($_SESSION['sess_user_id']) )
			unset($_SESSION['sess_user_id']);
		 $_SESSION['sess_user_id']= $uid;
		
		 header("location:" . P_HOMEPAGE_URL ."admin/");
	}
		
	else
	{
		echo "Ê§°Ü";
		header("location:" . P_HOMEPAGE_URL ."admin/login.html");
	}
		
		
?>
