<?php
	
	include_once("../../common/include/common.inc");
	include_once("../../common/class/baseDatabase.inc");
	include_once("../../common/class/baseTable.inc");
	include_once("../../common/class/user.inc");
	include_once("../../common/class/error.inc");
	include_once("../../common/class/question.inc");
	
	
	if( isset($_POST["Qid"]) )
		$Qid = (int) $_POST['Qid'];
	else 
		$Qid = 0;
	
	$questionObj = new question();
	
	if(!$questionObj->createConnect()){
		$errorObj=$questionObj->getError();
		$errorObj->showErrors($show_sql_flag=false);
	}
	
	$questionObj -> s_Search( $Qid );
	$questionObj -> getOneRecord();
	
	
	$return_arr = array(
		'ID' => (int) $questionObj -> getQid(),
		'Type' => (int)$questionObj -> getType(),
		'Detail' => $questionObj -> getDetail() ,
		'Ans' =>  $questionObj -> getAns() ,
		'Tips' =>   $questionObj -> getTips() 
	);  
	echo json_encode($return_arr);
?>
