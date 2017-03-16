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
	$paperRecordObj -> getOneRecord();
	
	$return_arr = array(
		'ResCode' => $count > 0 ? 100 : 200,
		'Ans' => $paperRecordObj -> getAns(),
		'TimePassed' => $paperRecordObj -> getTimePassed(),
		'Data_lastchange_time' => $paperRecordObj -> getData_lastchange_time()
	);  
	echo  json_encode($return_arr);
?>
