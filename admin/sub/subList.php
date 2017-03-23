<?php
	
	include_once("../../common/include/common.inc");
	include_once("../../common/class/baseDatabase.inc");
	include_once("../../common/class/baseTable.inc");
	include_once("../../common/class/user.inc");
	include_once("../../common/class/error.inc");
	include_once("../../common/class/sub.inc");
	include_once("../../common/class/paper.inc");
	
		
	$subObj = new sub();
	
	if(!$subObj->createConnect()){
		$errorObj=$subObj->getError();
		$errorObj->showErrors($show_sql_flag=false);
	}
	//查出所有的活动
	$subObj -> a_Search();
	$count = $subObj -> getRecordCount();
	
	
	
?>

<html>

	<head>
		<meta charset="UTF-8">
		<title>所有学科</title>
		<link rel="stylesheet" href="../plugins/layui/css/layui.css" media="all" />
		<link rel="stylesheet" href="../css/global.css" media="all">
		<link rel="stylesheet" href="../plugins/font-awesome/css/font-awesome.min.css">
		<link rel="stylesheet" href="../css/table.css" />
	</head>
	<body>
		<div class="admin-main">
			<fieldset class="layui-elem-field">
				<legend>学科列表</legend>
				<div class="layui-field-box">
					<table class="site-table table-hover">
						
						<thead>
							<tr>
								<th>学科ID</th>
								<th>学科名称</th>
								<th>描述</th>
								<th>创建时间</th>
								<th>下属学试卷列表</th>
								<th>操作</th>
							</tr>
						</thead>
						<tbody>
							<?php
								$subObj -> moveFirst();
								for( $i = 1 ; $i <= $count ; $i ++ ){
									$subObj -> getOneRecord();
									$paperObj = new paper();
									if(!$paperObj->createConnect()){
										$errorObj=$paperObj->getError();
										$errorObj->showErrors($show_sql_flag=false);
									}
									$paperObj -> a_Search( 0 , (int)$subObj->getSid() );
									
									$count1 = $paperObj -> getRecordCount();
									$str = $count1 > 0 ? "" : "没有下属试卷";
									$paperObj -> moveFirst();
									for( $j = 1 ; $j <= $count1 ; $j ++ ){
										$paperObj -> getOneRecord();
										$str .= $j < $count1 ? $paperObj -> getPid() ."," :
											$paperObj -> getPid();
										$paperObj -> moveNext();
									}
									
							?>
							<tr>
								<td><?php echo $subObj -> getSid(); ?> </td>
								<td>
									<?php echo urldecode ( $subObj -> getSname() ); ?>
								</td>
								<td>
									<?php echo urldecode ( $subObj -> getDescription() ); ?>
								</td>
								<td><?php echo  ( $subObj -> getDataCreateTime() ); ?></td>
								<td><?php echo  ( $str );?></td>
								<td>
									<a  class="layui-btn layui-btn-normal layui-btn-mini" onclick = "editSub();">编辑</a>
									<a  class="layui-btn layui-btn-mini" onclick = "managePaper( <?php echo ( $subObj -> getSid() ); ?> )">管理试卷</a>
									<a   class="layui-btn layui-btn-danger layui-btn-mini" onclick = "delSub( <?php echo $subObj -> getSid(); ?>)">删除</a>
								</td>
							</tr>
							<?php
								$subObj -> moveNext();
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
		
			function editSub(){
				
				alert("尚未实现");
			}
			function managePaper( v ){
				/*
				var url = "<?php echo P_HOMEPAGE_URL ?>" + "admin/sub/editSubOfAct.php" + "?Aid=" ;
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
					temp.action = "<?php echo P_HOMEPAGE_URL ?>" + "admin/sub/editPaperOfSub.php";
					temp.method = "GET";        
					temp.style.display = "none";        
					var opt = document.createElement("textarea");        
					opt.name = "Sid";        
					opt.value = v;        
					temp.appendChild(opt);             
					document.body.appendChild(temp);        
					temp.submit();        
			}
			function delSub( v ){
				
				layer.open({
				  title : '删除学科',
				  content: '确认删除该学科(ID：' + v + ')?'
				  ,btn: ['确定', '取消']
				  ,yes: function(index, layero){
					//按钮【确认】的回调
					var temp = document.createElement("form");      
					
					temp.action = "<?php echo P_HOMEPAGE_URL ?>" + "service/sub/delSub.php";
					temp.method = "post";        
					temp.style.display = "none";        
					var opt = document.createElement("textarea");        
					opt.name = "Sid";        
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