<?php
	
	include_once("../../common/include/common.inc");
	include_once("../../common/class/baseDatabase.inc");
	include_once("../../common/class/baseTable.inc");
	include_once("../../common/class/user.inc");
	include_once("../../common/class/error.inc");
	include_once("../../common/class/question.inc");
	
	$qType = isset($_POST["Qtype"]) ? (int) $_POST["Qtype"] : 1;
	$question = isset($_POST["question"]) ?  $_POST["question"] : "无";
	$tips = isset($_POST["tips"]) ?  $_POST["tips"] : "无";
	
	$rightAns = isset($_POST["RihtAns"]) ?  $_POST["RihtAns"] : "T";
	
	$aContent = isset($_POST["AContent"]) ?  $_POST["AContent"] : "无";
	$aRight = isset($_POST["ARight"]) ?  $_POST["ARight"] : "T";
	$bContent = isset($_POST["BContent"]) ?  $_POST["BContent"] : "无";
	$bRight = isset($_POST["BRight"]) ?  $_POST["BRight"] : "T";
	$cContent = isset($_POST["CContent"]) ?  $_POST["CContent"] : "无";
	$cRight = isset($_POST["CRight"]) ?  $_POST["CRight"] : "T";
	$dContent = isset($_POST["DContent"]) ?  $_POST["DContent"] : "无";
	$dRight = isset($_POST["DRight"]) ?  $_POST["DRight"] : "T";
	
	//写入数据库
	$questionObj = new question();
	$questionObj -> setType( $qType );
	$questionObj -> setDetail( urlencode( $question)  );
	$questionObj -> setTips( urlencode( $tips )  );
	
	$ans = "";
	if( $qType == 3 ){
		$ans = $rightAns;
	}else{
		$ansList = array();
		$ansList[0] = new stdClass();
		$ansList[0] -> content = urlencode( $aContent ) ;
		$ansList[0] -> right = $aRight;
		$ansList[1] = new stdClass();
		$ansList[1] -> content = urlencode( $bContent ) ;
		$ansList[1] -> right = $bRight;
		$ansList[2] = new stdClass();
		$ansList[2] -> content = urlencode( $cContent ) ;
		$ansList[2] -> right = $cRight;
		$ansList[3] = new stdClass();
		$ansList[3] -> content = urlencode( $dContent ) ;
		$ansList[3] -> right = $dRight;
		$ans =   ( json_encode($ansList) );
		//echo $ans;
	}
	$questionObj -> setAns( $ans );
	//写入数据库
	if(!$questionObj->createConnect()){
		$errorObj=$questionObj->getError();
		$errorObj->showErrors($show_sql_flag=false);
	}
	$flag = $questionObj -> addRecorded();
	if( !$flag ){
		$result = "新增题目失败";
		$more = "";
	}
	else{
		$Qid = $questionObj -> getInsertId();
		$result = "新增题目成功,题目ID为$Qid";
	}
		
	
	
?>

<html>
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
		<title>新增题目</title>
		<link rel="stylesheet" href="../../admin/plugins/layui/css/layui.css" media="all" />
		<link rel="stylesheet" href="../../admin/css/result.css" />
	</head>

	<body class="beg-login-bg" onload="toast()">
		<div class="beg-login-box">
			<header>
				<h1><?php echo $result ?> </h1>
			</header>
			<div class="beg-login-main">
						<button class="layui-btn layui-btn-primary"  onClick="location.href='../../admin/question/addQuestion.html'">
							<i class="layui-icon">&#xe650;</i> 继续添加
			</div>
		</div>
	
	</body>
</html>
