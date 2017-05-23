<?php
	
	include_once("../../common/include/common.inc");
	include_once("../../common/class/baseDatabase.inc");
	include_once("../../common/class/baseTable.inc");
	include_once("../../common/class/user.inc");
	include_once("../../common/class/error.inc");
	include_once("../../common/class/activity.inc");
	
	$page_get = isset( $_POST['PageID']) ? ( (int)$_POST['PageID'] >= 1 ? (int)$_POST['PageID'] : 1 )  : 1;

	$actObj = new activity();
	
	if(!$actObj->createConnect()){
		$errorObj=$actObj->getError();
		$errorObj->showErrors($show_sql_flag=false);
	}
	
	$actObj -> a_Search( );
	$count = $actObj -> getRecordCount();
	$allPage = ceil( $count / NUM_OF_ONE_PAGE_ACTIVITY ) ;
	
	$actObj -> a_Search( $page_get );
	$count = $actObj -> getRecordCount();
	//循环将活动读出
	$ActList = array();
	$actObj -> moveFirst();
	for( $i = 1 ; $i <= $count ; $i ++ ){
		$actObj -> getOneRecord();
		$ActList[$i - 1 ] = new stdClass();
		$ActList[$i - 1 ]-> ID = (int) $actObj -> getAid(); 
		$ActList[$i - 1 ]-> Aname = ($actObj -> getAName());
		$ActList[$i - 1 ]-> Description = ($actObj -> getDescription());
		$ActList[$i - 1 ]-> PicUrl = ($actObj -> getPicUrl());
		
		$actObj -> moveNext();
	}
	
	$return_arr = array(
		'AllPage' => $allPage ,
		'Activity' => $ActList
	);  
	echo ( json_encode($ActList));
	
	include_once("../../common/include/log.inc");
	$manager = new logManager();
	$manager -> httpLog(json_encode($return_arr));
?>
