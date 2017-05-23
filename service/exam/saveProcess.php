<?php
	
	include_once("../../common/include/common.inc");
	include_once("../../common/class/baseDatabase.inc");
	include_once("../../common/class/baseTable.inc");
	include_once("../../common/class/user.inc");
	include_once("../../common/class/error.inc");
	include_once("../../common/class/paper_record.inc");
	
	if( isset($_POST["Uid"]) )
		$Uid = (int) $_POST['Uid'];
	else 
		$Uid = 0;
	if( isset($_POST["Pid"]) )
		$Pid = (int) $_POST['Pid'];
	else 
		$Pid = 0;
	
	$paperRecordObj = new paper_record();
	
	if(!$paperRecordObj->createConnect()){
		$errorObj=$paperRecordObj->getError();
		$errorObj->showErrors($show_sql_flag=false);
	}
	
	$paperRecordObj -> s_Search( $Uid , $Pid );
	$count = $paperRecordObj -> getRecordCount();
	//TODO: 查询、计算本次保存的记录中答题数和总题数
	$AllCount = 1;
	$FinishedCount = 0;
	
	$paperRecordObj -> setUid( isset($_POST["Uid"]) ?  (int) $_POST["Uid"] : 0 );
	$paperRecordObj -> setPid( isset($_POST["Pid"]) ?  (int) $_POST["Pid"] : 0 );
	$paperRecordObj -> setAns( isset($_POST["Ans"]) ?   $_POST["Ans"] : 0 );
	//$paperRecordObj -> setAllCount( isset($_POST["AllCount"]) ?  (int) $_POST["AllCount"] : 0 );
	$paperRecordObj -> setAllCount( $AllCount );
	//$paperRecordObj -> setFinishedCount( isset($_POST["FinishedCount"]) ?  (int) $_POST["FinishedCount"] : 0 );
	$paperRecordObj -> setFinishedCount( $FinishedCount );
	$paperRecordObj -> setTimePassed( isset($_POST["TimePassed"]) ?  (int) $_POST["TimePassed"] : 0 );
	$paperRecordObj -> setCondition( "Uid" , $Uid );
	$paperRecordObj -> setCondition( "Pid" , $Pid );
	/*
		数据存在则更新
		数据不存在则插入
	*/
	
	$flag = $count > 0 ? $paperRecordObj -> updateRecorded() : $paperRecordObj -> addRecorded() ;
	if(!$flag){
		$errorObj=$paperRecordObj->getError();
		$errorObj->showErrors($show_sql_flag=false);
	}
	$return_arr = array(
		'ResCode' => $flag ? 100 : 200
	);  
	echo  json_encode($return_arr);
	
	include_once("../../common/include/log.inc");
	$manager = new logManager();
	$manager -> httpLog(json_encode($return_arr));
?>
