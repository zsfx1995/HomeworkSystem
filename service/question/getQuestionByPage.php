<?php
	
	include_once("../../common/include/common.inc");
	include_once("../../common/class/baseDatabase.inc");
	include_once("../../common/class/baseTable.inc");
	include_once("../../common/class/user.inc");
	include_once("../../common/class/error.inc");
	include_once("../../common/class/question.inc");
	

	$aid= isset($_POST["Aid"]) ? (int) $_POST['Aid'] : 0 ;
	$sid = isset($_POST["Sid"]) ? (int) $_POST['Sid'] : 0 ;
	$pid = isset($_POST["Pid"]) ? (int) $_POST['Pid'] : 0 ;
	$page_get = isset( $_POST['PageID']) ? (int)$_POST['PageID'] : -1;
	
	$questionObj = new question();
	
	if(!$questionObj->createConnect()){
		$errorObj=$questionObj->getError();
		$errorObj->showErrors($show_sql_flag=false);
	}
	
	$questionObj -> a_Search( $aid , $sid , $pid  );
	$count = $questionObj -> getRecordCount();
	$allPage = ceil( $count / NUM_OF_ONE_PAGE_QUESTION ) ;
	
	$questionObj -> a_Search( $aid , $sid , $pid , $page_get );
	$count = $questionObj -> getRecordCount();
	
	//ѭ����ѧ�ƶ���
	$QuestionList = array();
	$questionObj -> moveFirst();
	for( $i = 1 ; $i <= $count ; $i ++ ){
		$questionObj -> getOneRecord();
		$QuestionList[$i - 1 ] = new stdClass();
		$QuestionList[$i - 1 ]-> ID = (int) $questionObj -> getQid(); 
		$QuestionList[$i - 1 ]-> Type = (int)$questionObj -> getType();
		$QuestionList[$i - 1 ]-> Detail = $questionObj -> getDetail();
		$QuestionList[$i - 1 ]-> Ans =  $questionObj -> getAns();
		$QuestionList[$i - 1 ]-> Tips =  $questionObj -> getTips() ;
	
		$questionObj -> moveNext();
	}
	
	$return_arr = array(
		'AllPage' =>  $allPage,
		'QuestionList' => $QuestionList
	);  
	echo json_encode($return_arr);
?>
