﻿<?php
	
	include_once("../../common/include/common.inc");
	include_once("../../common/class/baseDatabase.inc");
	include_once("../../common/class/baseTable.inc");
	include_once("../../common/class/user.inc");
	include_once("../../common/class/error.inc");
	include_once("../../common/class/activity.inc");
	include_once("../../common/class/sub.inc");
	include_once("../../common/class/paper.inc");
	
	$Sid = isset ( $_GET['Sid'] ) ? (int) $_GET['Sid'] : 0;
	
	$subObj = new sub();
	$paperObj = new paper();
	
	if(!$subObj->createConnect()){
		$errorObj=$subObj->getError();
		$errorObj->showErrors($show_sql_flag=false);
	}
	
	$subObj -> s_Search( $Sid );
	$subObj -> getOneRecord();
	$sname = $subObj -> getSname();
	//查出所有活动下属学科ID
	if(!$paperObj->createConnect()){
		$errorObj=$paperObj->getError();
		$errorObj->showErrors($show_sql_flag=false);
	}
	
	$paperObj -> a_Search( 0 , $Sid );
	$count = $paperObj -> getRecordCount();
	$list = "";
	$paperObj -> moveFirst();
	for( $i = 1 ; $i <= $count ; $i ++ ){
		$paperObj -> getOneRecord();
		$list .= $i < $count ? $paperObj -> getPid() ."," : $paperObj -> getPid();
		$paperObj ->moveNext();
	}
	
?>
<html>
	<head>
		<meta charset="utf-8">
		<title>编辑下属试卷</title>
		<meta name="renderer" content="webkit">
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
		<meta name="apple-mobile-web-app-status-bar-style" content="black">
		<meta name="apple-mobile-web-app-capable" content="yes">
		<meta name="format-detection" content="telephone=no">

		<link rel="stylesheet" href="../plugins/layui/css/layui.css" media="all" />
		<link rel="stylesheet" href="../plugins/font-awesome/css/font-awesome.min.css">
	</head>

	<body>
		<div style="margin: 15px;">
			
			<form class="layui-form" method="post" action = "../../service/sub/setPaper.php" >
				<fieldset  class="layui-elem-field layui-field-title" style="margin-top: 20px;">
					<legend>编辑下属试卷</legend>
				</fieldset>
				<input hidden type="text" id = "Sid" name="Sid" value = "<?php echo $Sid ; ?>">
				<div class="layui-form-item layui-form-text">
					<label class="layui-form-label">学科<?php echo "$Sid :  " ?> </label>
					<label class="layui-form-label"><?php echo urldecode( "$sname") ?>  </label>
					
				</div>
				<div class="layui-form-item layui-form-text">
					<label class="layui-form-label">试卷id：</label>
					<div   class="layui-input-block"  >
						<input type="text" id = "List" name="List" lay-verify="list" autocomplete="off" value="<?php echo $list ?>"  class="layui-input">
						<font color="#FF0000">多个试卷ID用英文逗号隔开</font> 
						</input>
					</div>
				</div>
				
				
				<div class="layui-form-item">
						<div class="layui-input-block">
							<button class="layui-btn" lay-submit="" lay-filter="submit">保存</button>
							<button type="reset" class="layui-btn layui-btn-primary">重置</button>
						</div>
				</div>
			</form>
	</div>
		<script type="text/javascript" src="../plugins/layui/layui.js"></script>
		<script>
			layui.use(['form', 'layedit', 'laydate'], function() {
				var form = layui.form(),
					layer = layui.layer,
					layedit = layui.layedit,
					laydate = layui.laydate;
				
				//创建一个编辑器
				var editIndex = layedit.build('LAY_demo_editor');
				
				//验证列表
				form.verify({
				  list: function(value){
					if (!(/^[0-9\,]+$/.test(value))) {
						return '只能输入数字和英文逗号';
					}
					if (!(/[0-9]/.test(value))) {
						return '至少输入一个ID';
					}
				  }
				});  
				//监听提交
				form.on('submit(submit)', function(data) {
					layer.alert(JSON.stringify(data.field), {
						title: '最终的提交信息'
					})
					
					//return false;
				});
			});
			
		</script>
	</body>

</html>