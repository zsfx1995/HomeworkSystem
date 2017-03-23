<?php
	
	include_once("../../common/include/common.inc");
	include_once("../../common/class/baseDatabase.inc");
	include_once("../../common/class/baseTable.inc");
	include_once("../../common/class/user.inc");
	include_once("../../common/class/error.inc");
	include_once("../../common/class/paper.inc");
	
	$title = isset($_POST["title"]) ?  $_POST["title"] : "无";
	$description = isset($_POST["description"]) ?  $_POST["description"] : "无";
	$time = isset($_POST["time"]) ? (int) $_POST["time"] : 0;
	
	
	//写入数据库
	$paperObj = new paper();
	$paperObj -> setPname( urlencode( $title )  );
	$paperObj -> setDescription( urlencode( $description )  );
	$paperObj -> setLimitTime(  $time   );
	
	
	//写入数据库
	if(!$paperObj->createConnect()){
		$errorObj=$paperObj->getError();
		$errorObj->showErrors($show_sql_flag=false);
	}
	$flag = $paperObj -> addRecorded();
	if( !$flag ){
		$result = "添加试卷失败";
		$more = "";
	}
	else{
		$id = $paperObj -> getInsertId();
		$result = "添加试卷成功,试卷ID为$id";
	}
		
	
	
?>

<html>
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta title="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
		<title>添加试卷</title>
		<link rel="stylesheet" href="../../admin/plugins/layui/css/layui.css" media="all" />
		<link rel="stylesheet" href="../../admin/css/result.css" />
	</head>

	<body class="beg-login-bg" onload="toast()">
		<div class="beg-login-box">
			<header>
				<h1><?php echo $result ?> </h1>
			</header>
			<div class="beg-login-main">
						<button class="layui-btn layui-btn-primary"  onClick="location.href='../../admin/paper/addPaper.html'">
							<i class="layui-icon">&#xe650;</i> 继续添加
			</div>
		</div>
	
	</body>
</html>
