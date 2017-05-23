<?php
	
	include_once("../../common/include/common.inc");
	include_once("../../common/class/baseDatabase.inc");
	include_once("../../common/class/baseTable.inc");
	include_once("../../common/class/user.inc");
	include_once("../../common/class/error.inc");
	include_once("../../common/class/question_wrong.inc");
	

	$Uid = isset($_POST["Uid"]) ? (int) $_POST['Uid'] : 0;
	$Qid = isset($_POST["Qid"]) ? (int) $_POST['Qid'] : 0;
	
	$question_wrongObj = new question_wrong();
	
	if(!$question_wrongObj->createConnect()){
		$errorObj=$question_wrongObj->getError();
		$errorObj->showErrors($show_sql_flag=false);
	}
	
	$question_wrongObj -> s_Search( $Uid , $Qid );
	$count = $question_wrongObj -> getRecordCount();
	
	$question_wrongObj -> setUid( $Uid );
	$question_wrongObj -> setQid( $Qid );
	
	$question_wrongObj -> setCondition( "Uid" , $Uid );
	$question_wrongObj -> setCondition( "Qid" , $Qid );
	/*
		²åÈë´íÌâ±í
	*/
	$flag = $count > 0 ? 1 : $question_wrongObj -> addRecorded() ;
	if(!$flag){
		$errorObj=$question_wrongObj->getError();
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
