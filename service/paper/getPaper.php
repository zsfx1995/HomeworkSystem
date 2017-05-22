<?php
	
	include_once("../../common/include/common.inc");
	include_once("../../common/class/baseDatabase.inc");
	include_once("../../common/class/baseTable.inc");
	include_once("../../common/class/user.inc");
	include_once("../../common/class/error.inc");
	include_once("../../common/class/paper.inc");
	
	//$Uid = (int) $_POST['Uid'];
	
	$aid= isset($_POST["Aid"]) ? (int) $_POST['Aid'] : 0 ;
	$sid = isset($_POST["Sid"]) ? (int) $_POST['Sid'] : 0 ;
	$page_get = isset( $_POST['PageID']) ? ( (int)$_POST['PageID'] >= 1 ? (int)$_POST['PageID'] : 1 )  : 1;
	
	$paperObj = new paper();
	
	if(!$paperObj->createConnect()){
		$errorObj=$paperObj->getError();
		$errorObj->showErrors($show_sql_flag=false);
	}
	
	$paperObj -> a_Search( $aid, $sid );
	$count = $paperObj -> getRecordCount();
	$allPage = ceil( $count / NUM_OF_ONE_PAGE_PAPER ) ;
	
	$paperObj -> a_Search( $aid, $sid , $page_get );
	$count = $paperObj -> getRecordCount();
	
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
		'AllPage' =>  $allPage ,
		'PaperList' => $PaperList
	);  
	echo  json_encode($PaperList);
?>
