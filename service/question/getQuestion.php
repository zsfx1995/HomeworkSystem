<?php
	
	include_once("../../common/include/common.inc");
	include_once("../../common/class/baseDatabase.inc");
	include_once("../../common/class/baseTable.inc");
	include_once("../../common/class/user.inc");
	include_once("../../common/class/error.inc");
	include_once("../../common/class/question.inc");
	
	//$Uid = (int) $_POST['Uid'];
	if( isset($_POST["Aid"]) )
		$Aid = (int) $_POST['Aid'];
	else 
		$Aid = 0;
	if( isset($_POST["Sid"]) )
		$Sid = (int) $_POST['Sid'];
	else 
		$Sid = 0;
	if( isset($_POST["Pid"]) )
		$Pid = (int) $_POST['Pid'];
	else 
		$Pid = 0;
	
	$questionObj = new question();
	
	if(!$questionObj->createConnect()){
		$errorObj=$questionObj->getError();
		$errorObj->showErrors($show_sql_flag=false);
	}
	
	$questionObj -> a_Search( $Aid , $Sid , $Pid );
	$count = $questionObj -> getRecordCount();
	
	//循环将学科读出
	$QuestionList = array();
	$questionObj -> moveFirst();
	for( $i = 1 ; $i <= $count ; $i ++ ){
		$questionObj -> getOneRecord();
		$QuestionList[$i - 1 ] = new stdClass();
		$QuestionList[$i - 1 ]-> Qid = (int) $questionObj -> getQid(); 
		
	
		$questionObj -> moveNext();
	}
	
	$return_arr = array(
		'question' => $QuestionList
	);  
	echo urldecode( json_encode($return_arr));
?>
