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
	$userObj -> getOneRecord();
	
	$return_arr = array(
		'UserName' => $userObj -> getUserName(),
		'Mail' => $userObj -> getMail(),
		'PhoneNum' => $userObj -> getPhoneNum(),
		'SubList' => $userObj -> getSubList(),
		'PicUrl' => $userObj -> getPicUrl(),
		'Score' => $userObj -> getScore()
		);  
	echo json_encode($return_arr);
	
	include_once("../../common/include/log.inc");
	$manager = new logManager();
	$manager -> httpLog(json_encode($return_arr));

?>
