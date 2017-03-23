<?php
	
	include_once("../../common/include/common.inc");
	include_once("../../common/class/baseDatabase.inc");
	include_once("../../common/class/baseTable.inc");
	include_once("../../common/class/user.inc");
	include_once("../../common/class/error.inc");
	include_once("../../common/class/sub.inc");
	include_once("../../common/class/sub.inc");
	include_once("../../common/class/r_sub_paper.inc");
	include_once("../../common/class/r_act_sub.inc");
	
	$sid = isset($_POST["Sid"]) ?  (int) $_POST["Sid"] : 0;
	
	$subObj = new sub();
	$subObj -> setCondition( 'Sid' , $sid );
	$r_sub_paperObj = new r_sub_paper();
	$r_sub_paperObj -> setCondition( 'Sid' , $sid );
	
	if(!$subObj->createConnect()){
		$errorObj=$subObj->getError();
		$errorObj->showErrors($show_sql_flag=false);
	}
	$flag = $subObj -> deleteRecord();
	echo $flag ? "删除学科成功" : "删除学科失败";
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
				
				var result = "删除成功";
				if( !flag )
					result = "删除失败";
				layer.open({
				  title : result
					  ,btn: ['确认']
				 ,yes: function(index, layero){
					// alert("fxxk");
					var url = "<?php echo P_HOMEPAGE_URL ?>" + "admin/sub/subList.php";
					window.location.href = url ; 
					}
				 ,cancel: function(){
					 var url = "<?php echo P_HOMEPAGE_URL ?>" + "admin/sub/subList.php";
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