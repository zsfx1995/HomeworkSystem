<?php
	include_once("../../common/include/common.inc");
	include_once("../../common/class/baseDatabase.inc");
	include_once("../../common/class/baseTable.inc");
	include_once("../../common/class/user.inc");
	include_once("../../common/class/error.inc");
	include_once("../../common/class/activity.inc");
	include_once("../../common/class/sub.inc");
	include_once("../../common/class/r_act_sub.inc");
	
	$aid = isset( $_POST['Aid']) ? (int) $_POST['Aid'] : 0;
	$list = isset( $_POST['List']) ?  $_POST['List'] : "";

	$list = explode(',',$list); 
	$subObj = new sub();
	$existedSub = "";
	if(!$subObj->createConnect()){
		$errorObj=$subObj->getError();
		$errorObj->showErrors($show_sql_flag=false);
	}
	
	$r_act_subObj = new r_act_sub();
	if(!$r_act_subObj->createConnect()){
		$errorObj=$r_act_subObj->getError();
		$errorObj->showErrors($show_sql_flag=false);
	}
	//先把原来的关联记录都删除掉
	$r_act_subObj -> setCondition("Aid" , $aid );
	$r_act_subObj -> deleteRecord();
	//逐个检查学科是否存在，如果存在插入关联表
	for($i=0;$i<count($list);$i++) 
	{
		$subObj -> s_Search( (int) $list[$i]);
		$count = $subObj -> getRecordCount();
		if( $count >0 ){
			$existedSub .= "$list[$i],";
			$r_act_subObj -> setAid( $aid );
			$r_act_subObj -> setSid( (int) $list[$i] );
			$r_act_subObj -> addRecord();
		}
	}
	
	$r_act_subObj -> s_Search( $aid );
	$count = $r_act_subObj -> getRecordCount();
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
				var flag = "<?php echo $flag ?>";
				
				var result = "修改成功";
				if( !flag )
					result = "修改失败";
				var c = "修改后该活动下属学科数量为：" + "<?php echo $count ?>";
				layer.open({
					title : result,
					content : c
					,btn: ['确认']
				 ,yes: function(index, layero){
					// alert("fxxk");
					var url = "<?php echo P_HOMEPAGE_URL ?>" + "admin/activity/activityList.php";
					window.location.href = url ; 
					}
				 ,cancel: function(){
					 var url = "<?php echo P_HOMEPAGE_URL ?>" + "admin/activity/activityList.php";
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
