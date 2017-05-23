<?php
	
	include_once("../../common/include/common.inc");
	include_once("../../common/class/baseDatabase.inc");
	include_once("../../common/class/baseTable.inc");
	include_once("../../common/class/user.inc");
	include_once("../../common/class/error.inc");
	include_once("../../common/class/question_wrong.inc");
	

	$Uid = isset($_POST["Uid"]) ? (int) $_POST['Uid'] : 0;
	
	$question_wrongObj = new question_wrong();
	
	if(!$question_wrongObj->createConnect()){
		$errorObj=$question_wrongObj->getError();
		$errorObj->showErrors($show_sql_flag=false);
	}
	
	$question_wrongObj -> s_Search( $Uid , 0 );
	$count = $question_wrongObj -> getRecordCount();
	
	//循环将题目读出
	$QuestionList = array();
	$question_wrongObj -> moveFirst();
	for( $i = 1 ; $i <= $count ; $i ++ ){
		$question_wrongObj -> getOneRecord();
		$QuestionList[$i - 1 ] = new stdClass();
		$QuestionList[$i - 1 ]-> Qid = (int) $question_wrongObj -> getQid(); 
		
		$question_wrongObj -> moveNext();
	}
	
	$return_arr = array(
		'question' => $QuestionList
	); 

	echo  json_encode($return_arr);
	
	include_once("../../common/include/log.inc");
	$manager = new logManager();
	$manager -> httpLog(json_encode($return_arr));
?>
