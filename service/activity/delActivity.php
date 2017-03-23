<?php
	
	include_once("../../common/include/common.inc");
	include_once("../../common/class/baseDatabase.inc");
	include_once("../../common/class/baseTable.inc");
	include_once("../../common/class/user.inc");
	include_once("../../common/class/error.inc");
	include_once("../../common/class/activity.inc");
	include_once("../../common/class/r_act_sub.inc");
	
	$aid = isset($_POST["Aid"]) ?  (int) $_POST["Aid"] : 0;
	
	$activityObj = new activity();
	$activityObj -> setCondition( 'Aid' , $aid );
	$r_act_subObj = new r_act_sub();
	$r_act_subObj -> setCondition( 'Aid' , $aid );
	
	if(!$activityObj->createConnect()){
		$errorObj=$activityObj->getError();
		$errorObj->showErrors($show_sql_flag=false);
	}
	$flag = $activityObj -> deleteRecord();
	echo $flag ? "删除活动成功" : "删除活动失败";
	
?>


<html>
	<body onload = "showResult()">
		<script type="text/javascript" src="../../admin/plugins/layui/layui.js"></script>
		<script>
			layui.config({
				base: '../../admin/plugins/layui/modules/'
			});
		
			function showResult(){
				//alert ("ffff");
				var flag = "<?php echo $flag ?>";
				
				var result = "删除成功";
				if( !flag )
					result = "删除失败";
				layer.open({
				  title : result
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