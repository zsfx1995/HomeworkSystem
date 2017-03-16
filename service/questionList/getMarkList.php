<?php
	
	include_once("../../common/include/common.inc");
	include_once("../../common/class/baseDatabase.inc");
	include_once("../../common/class/baseTable.inc");
	include_once("../../common/class/user.inc");
	include_once("../../common/class/error.inc");
	include_once("../../common/class/question_mark.inc");
	

	$Uid = isset($_POST["Uid"]) ? (int) $_POST['Uid'] : 0;
	
	$question_markObj = new question_mark();
	
	if(!$question_markObj->createConnect()){
		$errorObj=$question_markObj->getError();
		$errorObj->showErrors($show_sql_flag=false);
	}
	
	$question_markObj -> s_Search( $Uid , 0 );
	$count = $question_markObj -> getRecordCount();
	
	//循环将题目读出
	$QuestionList = array();
	$question_markObj -> moveFirst();
	for( $i = 1 ; $i <= $count ; $i ++ ){
		$question_markObj -> getOneRecord();
		$QuestionList[$i - 1 ] = new stdClass();
		$QuestionList[$i - 1 ]-> Qid = (int) $question_markObj -> getQid(); 
		$QuestionList[$i - 1 ]-> Remark =  urldecode( $question_markObj -> getRemark()); 
		
		$question_markObj -> moveNext();
	}
	
	$return_arr = array(
		'question' => $QuestionList
	); 

	echo  json_encode($return_arr);
?>
