<?php
	
	include_once("../../common/include/common.inc");
	include_once("../../common/class/baseDatabase.inc");
	include_once("../../common/class/baseTable.inc");
	include_once("../../common/class/user.inc");
	include_once("../../common/class/error.inc");
	
	$Code = 200;
	$Uid = 0;
	
	$type = isset( $_POST['type'] ) ?  (int) $_POST['type'] : 1 ;
	$password =   isset( $_POST['password'] ) ? $_POST['password'] : "";
	$phone = isset( $_POST['phone'] ) ? $_POST['phone'] : "";
	$mail = isset( $_POST['mail'] ) ? $_POST['mail'] : "";
	
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
			$userObj -> setPhone ( $phone );
		
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
	
	include_once("../../common/include/log.inc");
	$manager = new logManager();
	$manager -> httpLog(json_encode($return_arr));

?>
