﻿<?php
	
	include_once("../../common/include/common.inc");
	include_once("../../common/class/baseDatabase.inc");
	include_once("../../common/class/baseTable.inc");
	include_once("../../common/class/user.inc");
	include_once("../../common/class/error.inc");
	include_once("../../common/class/sub.inc");
	
	$title = isset($_POST["title"]) ?  $_POST["title"] : "无";
	$description = isset($_POST["description"]) ?  $_POST["description"] : "无";
	
	
	//写入数据库
	$subObj = new sub();
	$subObj -> setName( urlencode( $title )  );
	$subObj -> setDescription( urlencode( $description )  );
	
	
	//写入数据库
	if(!$subObj->createConnect()){
		$errorObj=$subObj->getError();
		$errorObj->showErrors($show_sql_flag=false);
	}
	$flag = $subObj -> addRecorded();
	if( !$flag ){
		$result = "添加学科失败";
		$more = "";
	}
	else{
		$id = $subObj -> getInsertId();
		$result = "添加学科成功,学科ID为$id";
	}
		
	
	
?>

<html>
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta title="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
		<title>添加学科</title>
		<link rel="stylesheet" href="../../admin/plugins/layui/css/layui.css" media="all" />
		<link rel="stylesheet" href="../../admin/css/result.css" />
	</head>

	<body class="beg-login-bg" onload="toast()">
		<div class="beg-login-box">
			<header>
				<h1><?php echo $result ?> </h1>
			</header>
			<div class="beg-login-main">
						<button class="layui-btn layui-btn-primary"  onClick="location.href='../../admin/sub/addSub.html'">
							<i class="layui-icon">&#xe650;</i> 继续添加
			</div>
		</div>
	
	</body>
</html>
