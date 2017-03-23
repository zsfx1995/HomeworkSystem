<?php
	include_once("../../common/include/common.inc");
	include_once("../../common/class/baseDatabase.inc");
	include_once("../../common/class/baseTable.inc");
	include_once("../../common/class/user.inc");
	include_once("../../common/class/error.inc");
	include_once("../../common/class/activity.inc");
	include_once("../../common/class/question.inc");
	include_once("../../common/class/r_paper_ques.inc");
	include_once("../../common/class/r_paper_ques.inc");
	
	$pid = isset( $_POST['Pid']) ? (int) $_POST['Pid'] : 0;
	$list = isset( $_POST['List']) ?  $_POST['List'] : "";

	$list = explode(',',$list); 
	$questionObj = new question();
	$existedQuestion = "";
	if(!$questionObj->createConnect()){
		$errorObj=$questionObj->getError();
		$errorObj->showErrors($show_sql_flag=false);
	}
	
	$r_paper_quesObj = new r_paper_ques();
	if(!$r_paper_quesObj->createConnect()){
		$errorObj=$r_paper_quesObj->getError();
		$errorObj->showErrors($show_sql_flag=false);
	}
	//先把原来的关联记录都删除掉
	$r_paper_quesObj -> setCondition("Pid" , $pid );
	$r_paper_quesObj -> deleteRecord();
	//逐个检查题目是否存在，如果存在插入关联表
	for($i=0;$i<count($list);$i++) 
	{
		$questionObj -> s_Search( (int) $list[$i]);
		$count = $questionObj -> getRecordCount();
		if( $count >0 ){
			$existedQuestion .= "$list[$i],";
			$r_paper_quesObj -> setPid( $pid );
			$r_paper_quesObj -> setQid( (int) $list[$i] );
			$r_paper_quesObj -> addRecord();
		}
	}
	
	$r_paper_quesObj -> s_Search( $pid );
	$count = $r_paper_quesObj -> getRecordCount();
	$flag = 1;
?>


<html>
	<body onload = "showResult()">
		<script type="text/javascript" src="../../admin/plugins/layui/layui.js"></script>
		<script>
			layui.config({
				base: '../../admin/plugins/layui/modules/'
			});
		
			function showResult(){
				//alert ("fuck");
				var flag = "<?php echo $flag ?>";
				
				var result = "修改成功";
				if( !flag )
					result = "修改失败";
				var c = "修改后该学科下属试卷数量为：" + "<?php echo $count ?>";
				layer.open({
					title : result,
					content : c
					,btn: ['确认']
				 ,yes: function(index, layero){
					// alert("fxxk");
					var url = "<?php echo P_HOMEPAGE_URL ?>" + "admin/paper/paperList.php";
					window.location.href = url ; 
					}
				 ,cancel: function(){
					 var url = "<?php echo P_HOMEPAGE_URL ?>" + "admin/paper/paperList.php";
					window.location.href = url ;
				 }
				});
			
			}
			
			layui.use(['icheck', 'laypage','layer'], function() {
				var $ = layui.jquery,
					laypage = layui.laypage,
					layer = parent.layer === undefined ? layui.layer : parent.layer;
				$('input').iCheck({
					checkboxClass: 'icheckbox_flat-green'
				});


				$('.site-table tbody tr').on('click', function(event) {
					var $this = $(this);
					var $input = $this.children('td').eq(0).find('input');
					$input.on('ifChecked', function(e) {
						$this.css('background-color', '#EEEEEE');
					});
					$input.on('ifUnchecked', function(e) {
						$this.removeAttr('style');
					});
					$input.iCheck('toggle');
				}).find('input').each(function() {
					var $this = $(this);
					$this.on('ifChecked', function(e) {
						$this.parents('tr').css('background-color', '#EEEEEE');
					});
					$this.on('ifUnchecked', function(e) {
						$this.parents('tr').removeAttr('style');
					});
				});
				$('#selected-all').on('ifChanged', function(event) {
					var $input = $('.site-table tbody tr td').find('input');
					$input.iCheck(event.currentTarget.checked ? 'check' : 'uncheck');
				});
			});
		</script>
	</body>

</html>
