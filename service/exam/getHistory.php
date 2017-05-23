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
	
	
	$paper_finishedObj = new paper_finished();
	
	if(!$paper_finishedObj->createConnect()){
		$errorObj=$paper_finishedObj->getError();
		$errorObj->showErrors($show_sql_flag=false);
	}
	
	$paper_finishedObj -> s_Search( $Uid , 0 );
	$count = $paper_finishedObj -> getRecordCount();
	
	
	//循环将活动读出
	$History = array();
	$paper_finishedObj -> moveFirst();
	for( $i = 1 ; $i <= $count ; $i ++ ){
		$paper_finishedObj -> getOneRecord();
		$History[$i - 1 ] = new stdClass();
		$History[$i - 1 ]-> Pid = (int) $paper_finishedObj -> getPid(); 
		$History[$i - 1 ]-> Data_lastchange_time = $paper_finishedObj -> getData_lastchange_time();
		$History[$i - 1 ]-> AllCount = (int)$paper_finishedObj -> getAllCount();
		$History[$i - 1 ]-> FinishedCount = (int)$paper_finishedObj -> getFinishedCount();
		$History[$i - 1 ]-> RightCount = (int)$paper_finishedObj -> getRightCount();
		$History[$i - 1 ]-> TimeUsed = (int)($paper_finishedObj -> getTimeUsed());
	
		$paper_finishedObj -> moveNext();
	}
	
	$return_arr = array(
		'HistoryList' => $History
	);  
	echo urldecode( json_encode($return_arr));
	
	include_once("../../common/include/log.inc");
	$manager = new logManager();
	$manager -> httpLog(json_encode($return_arr));
?>
