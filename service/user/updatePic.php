<?php

	include_once("../../common/include/common.inc");
	include_once("../../common/class/baseDatabase.inc");
	include_once("../../common/class/baseTable.inc");
	include_once("../../common/class/user.inc");
	include_once("../../common/class/error.inc");
	
	$uid = isset( $_POST['Uid'] ) ?  (int) $_POST['Uid'] : 0 ;
	
	$userObj = new user();
	if(!$userObj->createConnect()){
		$errorObj=$userObj->getError();
		$errorObj->showErrors($show_sql_flag=false);
	}
	$userObj -> s_Search( $uid );
	$count = $userObj -> getRecordCount();
	$RespCode = 200;
	if( $count < 1 )
		$RespCode = 201;
	else{
		if ($_FILES["Pic"]["error"] > 0)
			$RespCode = 203;
		else{
			move_uploaded_file($_FILES["Pic"]["tmp_name"],
			"../../image/user/" . $uid . '.jpg');
			$userObj -> setCondition('Uid' , $uid );
			$userObj -> setPicUrl ( P_HOMEPAGE_URL . "image/user/$uid.jpg");
			$userObj -> updateRecord();
			$RespCode = 100;
		}
	}
	
  $return_arr = array(
		'RespCode' => $RespCode,
		'PicUrl' =>  P_HOMEPAGE_URL . "image/user/$uid.jpg"
	);  
	echo json_encode($return_arr);
?>