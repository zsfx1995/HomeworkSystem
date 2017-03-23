<?php
	
	include_once("../../common/include/common.inc");
	include_once("../../common/class/baseDatabase.inc");
	include_once("../../common/class/baseTable.inc");
	include_once("../../common/class/user.inc");
	include_once("../../common/class/error.inc");
	include_once("../../common/class/paper.inc");
	
	//$Uid = (int) $_POST['Uid'];
	if( isset($_POST["Aid"]) )
		$Aid = (int) $_POST['Aid'];
	else 
		$Aid = 0;
	if( isset($_POST["Sid"]) )
		$Sid = (int) $_POST['Sid'];
	else 
		$Sid = 0;
	
	$paperObj = new paper();
	
	if(!$paperObj->createConnect()){
		$errorObj=$paperObj->getError();
		$errorObj->showErrors($show_sql_flag=false);
	}
	
	$paperObj -> a_Search( $Aid , $Sid );
	$count = $paperObj -> getRecordCount();
	
	//ѭ����ѧ�ƶ���
	$PaperList = array();
	$paperObj -> moveFirst();
	for( $i = 1 ; $i <= $count ; $i ++ ){
		$paperObj -> getOneRecord();
		$PaperList[$i - 1 ] = new stdClass();
		$PaperList[$i - 1 ]-> ID = (int) $paperObj -> getPid(); 
		$PaperList[$i - 1 ]-> Pname = ($paperObj -> getPname());
		$PaperList[$i - 1 ]-> Description = ($paperObj -> getDescription());
		$PaperList[$i - 1 ]-> LimitTime = $paperObj -> getLimitTime();
	
		$paperObj -> moveNext();
	}
	
	$return_arr = array(
		'paper' => $PaperList
	);  
	echo  json_encode($PaperList);
?>
