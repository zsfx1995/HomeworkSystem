<?php
	
	include_once("../../common/include/common.inc");
	include_once("../../common/class/baseDatabase.inc");
	include_once("../../common/class/baseTable.inc");
	include_once("../../common/class/user.inc");
	include_once("../../common/class/error.inc");
	include_once("../../common/class/sub.inc");
	
	//$Uid = (int) $_POST['Uid'];
	$aid = isset($_POST["Aid"]) ? (int) $_POST['Aid'] : 0;
	$page_get = isset( $_POST['PageID']) ? (int)$_POST['PageID'] : -1;
	
	$subObj = new sub();
	
	if(!$subObj->createConnect()){
		$errorObj=$subObj->getError();
		$errorObj->showErrors($show_sql_flag=false);
	}
	
	$subObj -> a_Search( $aid );
	$count = $subObj -> getRecordCount();
	$allPage = ceil( $count / NUM_OF_ONE_PAGE_SUB ) ;
	
	$subObj -> a_Search( $aid , $page_get );
	$count = $subObj -> getRecordCount();
	
	
	//循环将学科读出
	$SubList = array();
	$subObj -> moveFirst();
	for( $i = 1 ; $i <= $count ; $i ++ ){
		$subObj -> getOneRecord();
		$SubList[$i - 1 ] = new stdClass();
		$SubList[$i - 1 ]-> ID = (int) $subObj -> getSid(); 
		$SubList[$i - 1 ]-> Sname = ($subObj -> getSname());
		$SubList[$i - 1 ]-> Description = ($subObj -> getDescription());
		
		$subObj -> moveNext();
	}
	
	$return_arr = array(
		'AllPage' => $allPage,
		'SubList' => $SubList
	);  
	echo ( json_encode($return_arr));
?>
