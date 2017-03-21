<?php
	
	include_once("../common/include/common.inc");
	include_once("../common/class/baseDatabase.inc");
	include_once("../common/class/baseTable.inc");
	include_once("../common/class/admin_user.inc");
	include_once("../common/class/error.inc");
	
	$password =  isset( $_POST['password'] ) ? $_POST['password'] : "";
	$username =  isset( $_POST['username'] ) ? $_POST['username'] : "";
	//echo $username .":" .$password;
	
	$admin_userObj = new admin_user();
	if(!$admin_userObj->createConnect()){
		$errorObj=$admin_userObj->getError();
		$errorObj->showErrors($show_sql_flag=false);
		
	}
	$admin_userObj->checkID( $username , $password );
	$recount = $admin_userObj -> getRecordCount();

	if( $recount > 0 ){
		header("location:main.html");
		//echo "³É¹¦";
	}
		
	else
	{
		echo "Ê§°Ü";
		header("location:index.html");
	}
		
		
?>
