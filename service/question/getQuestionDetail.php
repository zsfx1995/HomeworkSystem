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
	$ansStr = $questionObj -> getAns();
	
	$return_arr = array(
		'ID' => (int) $questionObj -> getQid(),
		'Type' => (int)$questionObj -> getType(),
		'Detail' => $questionObj -> getDetail() ,
		'Tips' =>   $questionObj -> getTips(),
		'Ans' => (int)$questionObj -> getType() < 3 ?  json_decode($ansStr, true) :
			array ( array( "content" => "he is lazy" , "right" => $ansStr ) ) 
	);  
	echo json_encode($return_arr);
?>
