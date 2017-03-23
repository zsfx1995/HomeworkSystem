<?php
	
	include_once("../../common/include/common.inc");
	include_once("../../common/class/baseDatabase.inc");
	include_once("../../common/class/baseTable.inc");
	include_once("../../common/class/user.inc");
	include_once("../../common/class/error.inc");
	include_once("../../common/class/sub.inc");
	include_once("../../common/class/paper.inc");
	include_once("../../common/class/r_sub_paper.inc");
	include_once("../../common/class/r_act_sub.inc");
	
	$pid = isset($_POST["Pid"]) ?  (int) $_POST["Pid"] : 0;
	
	$paperObj = new paper();
	$paperObj -> setCondition( 'Pid' , $pid );
	
	if(!$paperObj->createConnect()){
		$errorObj=$paperObj->getError();
		$errorObj->showErrors($show_sql_flag=false);
	}
	$flag = $paperObj -> deleteRecord();
	echo $flag ? "删除试卷成功" : "删除试卷失败";
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
				
				var result = "删除试卷成功";
				if( !flag )
					result = "删除试卷失败";
				layer.open({
				  title : result
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