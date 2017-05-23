<?php
	include_once("../../common/include/common.inc");
	include_once("../../common/class/baseDatabase.inc");
	include_once("../../common/class/baseTable.inc");
	include_once("../../common/class/user.inc");
	include_once("../../common/class/error.inc");
	include_once("../../common/class/activity.inc");
	include_once("../../common/class/sub.inc");
	include_once("../../common/class/r_user_sub.inc");
	$respCode = 200;
	
	$uid = isset( $_POST['Uid']) ? (int) $_POST['Uid'] : 0;
	$sid = isset( $_POST['Sid']) ? (int) $_POST['Sid'] : 0;
	$op = isset( $_POST['Operation']) ? (int) $_POST['Operation'] : 1;
	
//	echo "$uid $sid $op";
	
	if( $uid > 0 && $sid > 0 ){
		$r_user_subObj = new r_user_sub();
		if(!$r_user_subObj->createConnect()){
			$errorObj=$r_user_subObj->getError();
			$errorObj->showErrors($show_sql_flag=false);
		}
		$r_user_subObj -> setCondition("Uid" , $uid );
		$r_user_subObj -> setCondition("Sid" , $sid );
		$r_user_subObj -> setUid( $uid );
		$r_user_subObj -> setSid( $sid );
		$flag = ( $op == 1 ? $r_user_subObj -> addRecorded() : $r_user_subObj -> deleteRecorded() );
		$respCode = ( $flag == 1 ? 100 : 101 ) ;
	}else{
		$respCode = 101;
		
		
	}
	
	
	
	$return_arr = array(
		'RespCode' => $respCode
	);  
	echo ( json_encode($return_arr));
	
	include_once("../../common/include/log.inc");
	$manager = new logManager();
	$manager -> httpLog(json_encode($return_arr));
?>

