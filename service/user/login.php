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
	$userObj->CheckNewUserID( $type, $mail , $phone );
	$recount = $userObj -> getRecordCount();

	if( $recount > 0 ){
		
		$userObj -> getOneRecord();
		if( strcmp( $userObj -> getPassword(), $password ) == 0 ){
			$Code = 100;
			$Uid = $userObj -> getUid();
			session_start();
			if( isset($_SESSION['sess_user_id']) )
				unset($_SESSION['sess_user_id']);
			$_SESSION['sess_user_id']= $Uid;
		}
			
		else{
			$Code = 101;
		}
	}
	else
		$Code = 102; // 未注册
	

	$return_arr = array(
		'RespCode' => $Code,
		'ID' => $Uid
		
	);  
	echo json_encode($return_arr);

?>
