<?php
	
	include_once("../../common/include/common.inc");
	include_once("../../common/class/baseDatabase.inc");
	include_once("../../common/class/baseTable.inc");
	include_once("../../common/class/user.inc");
	include_once("../../common/class/error.inc");
	include_once("../../common/class/sub.inc");
	
	//$Uid = (int) $_POST['Uid'];
	$uid = isset($_POST["Uid"]) ? (int) $_POST['Uid'] : 0;
	$aid = isset($_POST["Aid"]) ? (int) $_POST['Aid'] : 0;
	$page_get = isset( $_POST['PageID']) ? (int)$_POST['PageID'] : -1;
	
	$subObj = new sub();
	
	if(!$subObj->createConnect()){
		$errorObj=$subObj->getError();
		$errorObj->showErrors($show_sql_flag=false);
	}
	
	//根据uid或者Aid查询学科列表
	$uid <= 0 ? $subObj -> a_Search( $aid ) : $subObj -> u_Search( $uid );
	$count = $subObj -> getRecordCount();
	$allPage = ceil( $count / NUM_OF_ONE_PAGE_SUB ) ;
	
	$uid <= 0 ? $subObj -> a_Search( $aid , $page_get ) : $subObj -> u_Search( $uid , $page_get );
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
		$SubList[$i - 1 ]-> PicUrl = ($subObj -> getPicUrl());
		$subObj -> moveNext();
	}
	
	$return_arr = array(
		'AllPage' => $allPage,
		'SubList' => $SubList
	);  
	echo ( json_encode($return_arr));
?>
