<?php
	
	include_once("../../common/include/common.inc");
	include_once("../../common/class/baseDatabase.inc");
	include_once("../../common/class/baseTable.inc");
	include_once("../../common/class/user.inc");
	include_once("../../common/class/error.inc");
	include_once("../../common/class/paper_finished.inc");
	
	if( isset($_POST["Uid"]) )
		$Uid = (int) $_POST['Uid'];
	else 
		$Uid = 0;
	if( isset($_POST["Pid"]) )
		$Pid = (int) $_POST['Pid'];
	else 
		$Pid = 0;
	
	$paperFinishedObj = new paper_finished();
	
	if(!$paperFinishedObj->createConnect()){
		$errorObj=$paperFinishedObj->getError();
		$errorObj->showErrors($show_sql_flag=false);
	}
	
	$paperFinishedObj -> s_Search( $Uid , $Pid );
	$count = $paperFinishedObj -> getRecordCount();
	
	$paperFinishedObj -> setUid( isset($_POST["Uid"]) ?  (int) $_POST["Uid"] : 0 );
	$paperFinishedObj -> setPid( isset($_POST["Pid"]) ?  (int) $_POST["Pid"] : 0 );
	$paperFinishedObj -> setAllCount( isset($_POST["AllCount"]) ?  (int) $_POST["AllCount"] : 0 );
	$paperFinishedObj -> setFinishedCount( isset($_POST["FinishedCount"]) ?  (int) $_POST["FinishedCount"] : 0 );
	$paperFinishedObj -> setRightCount( isset($_POST["RightCount"]) ?  (int) $_POST["RightCount"] : 0 );
	$paperFinishedObj -> setTimeUsed( isset($_POST["TimeUsed"]) ?  (int) $_POST["TimeUsed"] : 0 );
	$paperFinishedObj -> setCondition( "Uid" , $Uid );
	$paperFinishedObj -> setCondition( "Pid" , $Pid );
	/*
		数据存在则更新
		数据不存在则插入
	*/
	$flag = $count > 0 ? $paperFinishedObj -> updateRecorded() : $paperFinishedObj -> addRecorded() ;
	if(!$flag){
		$errorObj=$paperFinishedObj->getError();
		$errorObj->showErrors($show_sql_flag=false);
	}
	$return_arr = array(
		'ResCode' => $flag ? 100 : 200
	);  
	echo  json_encode($return_arr);
?>
