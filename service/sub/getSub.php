<?php
	
	include_once("../../common/include/common.inc");
	include_once("../../common/class/baseDatabase.inc");
	include_once("../../common/class/baseTable.inc");
	include_once("../../common/class/user.inc");
	include_once("../../common/class/error.inc");
	include_once("../../common/class/sub.inc");
	
	//$Uid = (int) $_POST['Uid'];
	if( isset($_POST["Aid"]) )
		$Aid = (int) $_POST['Aid'];
	else 
		$Aid = 0;
	
	$subObj = new sub();
	
	if(!$subObj->createConnect()){
		$errorObj=$subObj->getError();
		$errorObj->showErrors($show_sql_flag=false);
	}
	
	$subObj -> a_Search( $Aid );
	$count = $subObj -> getRecordCount();
	
	//循环将学科读出
	$SubList = array();
	$subObj -> moveFirst();
	for( $i = 1 ; $i <= $count ; $i ++ ){
		$subObj -> getOneRecord();
		$SubList[$i - 1 ] = new stdClass();
		$SubList[$i - 1 ]-> Sid = (int) $subObj -> getSid(); 
		$SubList[$i - 1 ]-> Sname = urlencode($subObj -> getSname());
	
		$subObj -> moveNext();
	}
	
	$return_arr = array(
		'sub' => $SubList
	);  
	echo urldecode( json_encode($return_arr));
?>
