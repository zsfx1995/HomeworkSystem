<?php
	
	include_once("../../common/include/common.inc");
	include_once("../../common/class/baseDatabase.inc");
	include_once("../../common/class/baseTable.inc");
	include_once("../../common/class/user.inc");
	include_once("../../common/class/error.inc");
	
	$uid = isset( $_POST['uid'] ) ?  (int) $_POST['uid'] : 0 ;
	$userName = isset( $_POST['userName'] ) ?  $_POST['userName'] : "" ;
	$mail = isset( $_POST['mail'] ) ?  $_POST['mail'] : "" ;
	$phoneNum = isset( $_POST['phone'] ) ?  $_POST['phone'] : "" ;
	$password = isset( $_POST['password'] ) ?  $_POST['password'] : "" ;
	

	$userObj = new user();
	$temp_userObj = new user();
	
	if(!$userObj->createConnect()){
		$errorObj=$userObj->getError();
		$errorObj->showErrors($show_sql_flag=false);
	}
	if(!$temp_userObj->createConnect()){
		$errorObj=$userObj->getError();
		$errorObj->showErrors($show_sql_flag=false);
	}
	
	$userObj -> s_Search( $uid );
	$count = $userObj -> getRecordCount();
	$RespCode = 200;
	if( $count < 1 )
		$RespCode = 201;
	else{
		$userObj -> getOneRecord();
		$temp_userObj -> setCondition( 'Uid' , $uid);
		$temp_userObj-> setUserName ( $userName == '' ?  $userObj -> getUserName() : $userName );
		$temp_userObj-> setMail ( $mail == '' ?  $userObj -> getMail() : $mail );
		$temp_userObj-> setPhone ( $phoneNum == '' ?  $userObj -> getPhone() : $phoneNum );
		$temp_userObj-> setPassword ( $password == '' ?  $userObj -> getPassword() : $password);
		
		
		$temp_userObj -> updateRecord();
		$RespCode = 100;
	}
	
	
	$return_arr = array(
		'RespCode' => $RespCode
		);  
	echo json_encode($return_arr);
	
	include_once("../../common/include/log.inc");
	$manager = new logManager();
	$manager -> httpLog(json_encode($return_arr));

?>
