<?php
	include_once("../../common/include/common.inc");
	include_once("../../common/class/baseDatabase.inc");
	include_once("../../common/class/baseTable.inc");
	include_once("../../common/class/user.inc");
	include_once("../../common/class/error.inc");
	include_once("../../common/class/activity.inc");
	include_once("../../common/class/paper.inc");
	include_once("../../common/class/r_sub_paper.inc");
	
	$sid = isset( $_POST['Sid']) ? (int) $_POST['Sid'] : 0;
	$list = isset( $_POST['List']) ?  $_POST['List'] : "";

	$list = explode(',',$list); 
	$paperObj = new paper();
	$existedSub = "";
	if(!$paperObj->createConnect()){
		$errorObj=$paperObj->getError();
		$errorObj->showErrors($show_sql_flag=false);
	}
	
	$r_sub_paperObj = new r_sub_paper();
	if(!$r_sub_paperObj->createConnect()){
		$errorObj=$r_sub_paperObj->getError();
		$errorObj->showErrors($show_sql_flag=false);
	}
	//先把原来的关联记录都删除掉
	$r_sub_paperObj -> setCondition("Sid" , $sid );
	$r_sub_paperObj -> deleteRecord();
	//逐个检查学科是否存在，如果存在插入关联表
	for($i=0;$i<count($list);$i++) 
	{
		$paperObj -> s_Search( (int) $list[$i]);
		$count = $paperObj -> getRecordCount();
		if( $count >0 ){
			$existedSub .= "$list[$i],";
			$r_sub_paperObj -> setSid( $sid );
			$r_sub_paperObj -> setPid( (int) $list[$i] );
			$r_sub_paperObj -> addRecord();
		}
	}
	
	$r_sub_paperObj -> s_Search( $sid );
	$count = $r_sub_paperObj -> getRecordCount();
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
