<?php
	
	include_once("../../common/include/common.inc");
	include_once("../../common/class/baseDatabase.inc");
	include_once("../../common/class/baseTable.inc");
	include_once("../../common/class/user.inc");
	include_once("../../common/class/error.inc");
	
	$Code = 200;
	$Uid = 0;
	
	$type = (int) $_POST['type'];
	$password = (int) $_POST['password'];
	$phone = $_POST['phone'];
	$mail = $_POST['mail'];
	
	$userObj = new user();
	if(!$userObj->createConnect()){
		$errorObj=$userObj->getError();
		$errorObj->showErrors($show_sql_flag=false);
	}
	$userObj->CheckNewUserID( $type,$mail , $phone );
	$recount = $userObj -> getRecordCount();
	if( $recount > 0 )
		$Code  = 101;
	else{
		if( $type == 1 )
			$userObj -> setMail($mail);
		else
			$userObj -> setPhoneNum ( $phone );
		
		$userObj -> setPassword ( $password );
		$user_flag=$userObj->addRecorded();
		if(!$user_flag){
			$Code  = 200;
			$errorObj=$userObj->getError();
			$errorObj->showErrors($show_sql_flag=false);
		}else{
			$Code =  100;
			$Uid = $userObj->getInsertId(); 
		}
	}
	
		
	
	$return_arr = array(
		'RespCode' => $Code,
		'ID' => $Uid
	);  
	echo json_encode($return_arr);

?>
