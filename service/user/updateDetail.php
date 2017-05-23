<?php
	
	include_once("../../common/include/common.inc");
	include_once("../../common/class/baseDatabase.inc");
	include_once("../../common/class/baseTable.inc");
	include_once("../../common/class/user.inc");
	include_once("../../common/class/error.inc");
	
	$uid = isset( $_POST['Uid'] ) ?  (int) $_POST['Uid'] : 0 ;
	$userName = isset( $_POST['UserName'] ) ?  $_POST['UserName'] : "" ;
	$mail = isset( $_POST['Mail'] ) ?  $_POST['Mail'] : "" ;
	$phoneNum = isset( $_POST['PhoneNum'] ) ?  $_POST['PhoneNum'] : "" ;
	$subList= isset( $_POST['SubList'] ) ?  $_POST['SubList'] : "" ;

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
		$temp_userObj-> setPhoneNum ( $phoneNum == '' ?  $userObj -> getPhoneNum() : $phoneNum );
		$temp_userObj-> setSubList ( $subList== '' ?  $userObj -> getSubList() : $subList );
		
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
