<?php
	
	include_once("../../common/include/common.inc");
	include_once("../../common/class/baseDatabase.inc");
	include_once("../../common/class/baseTable.inc");
	include_once("../../common/class/user.inc");
	include_once("../../common/class/error.inc");
	include_once("../../common/class/activity.inc");
	include_once("../../common/class/sub.inc");
	
		
	$actObj = new activity();
	
	if(!$actObj->createConnect()){
		$errorObj=$actObj->getError();
		$errorObj->showErrors($show_sql_flag=false);
	}
	//查出所有的活动
	$actObj -> a_Search();
	$count = $actObj -> getRecordCount();
	
	
	
?>

<html>

	<head>
		<meta charset="UTF-8">
		<title>所有活动</title>
		<link rel="stylesheet" href="../plugins/layui/css/layui.css" media="all" />
		<link rel="stylesheet" href="../css/global.css" media="all">
		<link rel="stylesheet" href="../plugins/font-awesome/css/font-awesome.min.css">
		<link rel="stylesheet" href="../css/table.css" />
	</head>
	<body>
		<div class="admin-main">
			<fieldset class="layui-elem-field">
				<legend>活动列表</legend>
				<div class="layui-field-box">
					<table class="site-table table-hover">
						
						<thead>
							<tr>
								<th>活动ID</th>
								<th>活动名称</th>
								<th>描述</th>
								<th>创建时间</th>
								<th>下属学科列表</th>
								<th>操作</th>
							</tr>
						</thead>
						<tbody>
							<?php
								$actObj -> moveFirst();
								for( $i = 1 ; $i <= $count ; $i ++ ){
									$actObj -> getOneRecord();
									$subObj = new sub();
									if(!$subObj->createConnect()){
										$errorObj=$subObj->getError();
										$errorObj->showErrors($show_sql_flag=false);
									}
									$subObj -> a_Search( (int)$actObj->getAid() );
									
									$count1 = $subObj -> getRecordCount();
									$str = $count1 > 0 ? "" : "没有下属学科";
									$subObj -> moveFirst();
									for( $j = 1 ; $j <= $count1 ; $j ++ ){
										$subObj -> getOneRecord();
										$str .= $j < $count1 ? $subObj -> getSid() ."," :
											$subObj -> getSid();
										$subObj -> moveNext();
									}
									
							?>
							<tr>
								<td><?php echo $actObj -> getAid(); ?> </td>
								<td>
									<?php echo urldecode ( $actObj -> getAName() ); ?>
								</td>
								<td>
									<?php echo urldecode ( $actObj -> getDescription() ); ?>
								</td>
								<td><?php echo  ( $actObj -> getDataCreateTime() ); ?></td>
								<td><?php echo  ( $str );?></td>
								<td>
									<a  class="layui-btn layui-btn-normal layui-btn-mini" onclick = "editActivity();">编辑</a>
									<a  class="layui-btn layui-btn-mini" onclick = "manageSub( <?php echo ( $actObj -> getAid() ); ?> )">管理学科</a>
									<a   class="layui-btn layui-btn-danger layui-btn-mini" onclick = "delActivity( <?php echo $actObj -> getAid(); ?>)">删除</a>
								</td>
							</tr>
							<?php
								$actObj -> moveNext();
								}
							?>
								
						</tbody>
					</table>

				</div>
			</fieldset>
			
		</div>
		<script type="text/javascript" src="../plugins/layui/layui.js"></script>
		<script>
			layui.config({
				base: '../plugins/layui/modules/'
			});
		
			function editActivity(){
				
				alert("尚未实现");
			}
			function manageSub( v ){
				/*
				var url = "<?php echo P_HOMEPAGE_URL ?>" + "admin/activity/editSubOfAct.php" + "?Aid=" ;
				//alert( url );
				layer.open({
					type : 2 ,
					title : "编辑下属学科" ,
					area: ['800px', '300px'] ,
					scrollbar: false ,
					content: url + v
				});
				*/
				//按钮【确认】的回调
					var temp = document.createElement("form");      
					temp.action = "<?php echo P_HOMEPAGE_URL ?>" + "admin/activity/editSubOfAct.php";
					temp.method = "GET";        
					temp.style.display = "none";        
					var opt = document.createElement("textarea");        
					opt.name = "Aid";        
					opt.value = v;        
					temp.appendChild(opt);             
					document.body.appendChild(temp);        
					temp.submit();        
			}
			function delActivity( v ){
				
				layer.open({
				  title : '确认删除',
				  content: '确认删除该活动(活动ID：' + v + ')?'
				  ,btn: ['确定', '取消']
				  ,yes: function(index, layero){
					//按钮【确认】的回调
					var temp = document.createElement("form");      
					
					temp.action = "<?php echo P_HOMEPAGE_URL ?>" + "service/activity/delActivity.php";
					temp.method = "post";        
					temp.style.display = "none";        
					var opt = document.createElement("textarea");        
					opt.name = "Aid";        
					opt.value = v;        
					temp.appendChild(opt);             
					document.body.appendChild(temp);        
					temp.submit();        
				  }
				  ,btn2: function(index, layero){
					//按钮【按钮二】的回调
					
					//return false 开启该代码可禁止点击该按钮关闭
				  }
				  ,cancel: function(){ 
					//右上角关闭回调
					
					//return false 开启该代码可禁止点击该按钮关闭
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