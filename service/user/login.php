<?php
	
	include_once("../../common/include/common.inc");
	include_once("../../common/class/baseDatabase.inc");
	include_once("../../common/class/baseTable.inc");
	include_once("../../common/class/user.inc");
	include_once("../../common/class/error.inc");
	
	$Code = 200;
	$Uid = 0;
	
	$type = (int) $_POST['type'];
	$password =  $_POST['password'];
	$phone = $_POST['phone'];
	$mail = $_POST['mail'];
	
	$userObj = new user();
	if(!$userObj->createConnect()){
		$errorObj=$userObj->getError();
		$errorObj->showErrors($show_sql_flag=false);
	}
	$userObj->CheckNewUserID( $type, $mail , $phone );
	$recount = $userObj -> getRecordCount();

	if( $recount > 0 ){
		
		$userObj -> getOneRecord();
		if( strcmp( $userObj -> getPassword(), $password ) == 0 ){
			$Code = 100;
			$Uid = $userObj -> getUid();
		}
			
		else{
			$Code = 101;
		}
	}
	else
		$Code = 102; // 未注册
	

	$return_arr = array(
		'RespCode' => $Code,
		'Uid' => $Uid
	);  
	echo json_encode($return_arr);

?>
