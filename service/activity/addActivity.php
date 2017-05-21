<?php
	
	include_once("../../common/include/common.inc");
	include_once("../../common/class/baseDatabase.inc");
	include_once("../../common/class/baseTable.inc");
	include_once("../../common/class/user.inc");
	include_once("../../common/class/error.inc");
	include_once("../../common/class/activity.inc");
	
	$title = isset($_POST["title"]) ?  $_POST["title"] : "无";
	$description = isset($_POST["description"]) ?  $_POST["description"] : "无";
	
	$filePath = P_HOMEPAGE_URL . "image/activity/" . date('YmdHis') . '.jpg' ;
	move_uploaded_file($_FILES["pic"]["tmp_name"], "../../image/activity/" .  date('YmdHis') . '.jpg' );
			
	//写入数据库
	$activityObj = new activity();
	$activityObj -> setAName( urlencode( $title )  );
	$activityObj -> setDescription( urlencode( $description )  );
	if ($_FILES["pic"]["error"] <= 0 )
		$activityObj -> setPicUrl( $filePath );
	
	//写入数据库
	if(!$activityObj->createConnect()){
		$errorObj=$activityObj->getError();
		$errorObj->showErrors($show_sql_flag=false);
	}
	$flag = $activityObj -> addRecorded();
	if( !$flag ){
		$result = "添加活动失败";
		$more = "";
	}
	else{
		$id = $activityObj -> getInsertId();
		$result = "添加活动成功,活动ID为$id";
	}
		
	
	
?>

<html>
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta title="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
		<title>添加活动</title>
		<link rel="stylesheet" href="../../admin/plugins/layui/css/layui.css" media="all" />
		<link rel="stylesheet" href="../../admin/css/result.css" />
	</head>

	<body class="beg-login-bg" onload="toast()">
		<div class="beg-login-box">
			<header>
				<h1><?php echo $result ?> </h1>
			</header>
			<div class="beg-login-main">
						<button class="layui-btn layui-btn-primary"  onClick="location.href='../../admin/activity/addActivity.html'">
							<i class="layui-icon">&#xe650;</i> 继续添加
			</div>
		</div>
	
	</body>
</html>
