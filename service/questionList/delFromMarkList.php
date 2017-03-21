<?php
	
	include_once("../../common/include/common.inc");
	include_once("../../common/class/baseDatabase.inc");
	include_once("../../common/class/baseTable.inc");
	include_once("../../common/class/user.inc");
	include_once("../../common/class/error.inc");
	include_once("../../common/class/question_mark.inc");
	

	$Uid = isset($_POST["Uid"]) ? (int) $_POST['Uid'] : 0;
	$Qid = isset($_POST["Qid"]) ? (int) $_POST['Qid'] : 0;
	
	$question_markObj = new question_mark();
	
	if(!$question_markObj->createConnect()){
		$errorObj=$question_markObj->getError();
		$errorObj->showErrors($show_sql_flag=false);
	}
	
	$question_markObj -> s_Search( $Uid , $Qid );
	$count = $question_markObj -> getRecordCount();
	
	$question_markObj -> setCondition( "Uid" , $Uid );
	$question_markObj -> setCondition( "Qid" , $Qid );
	
	$flag = $question_markObj -> deleteRecorded()  ;
	if(!$flag){
		$errorObj=$question_markObj->getError();
		$errorObj->showErrors($show_sql_flag=false);
	}
	$return_arr = array(
		'ResCode' => $flag ? 100 : 200
	); 

	echo  json_encode($return_arr);
?>
