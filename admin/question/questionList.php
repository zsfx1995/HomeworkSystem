<?php
	
	include_once("../../common/include/common.inc");
	include_once("../../common/class/baseDatabase.inc");
	include_once("../../common/class/baseTable.inc");
	include_once("../../common/class/user.inc");
	include_once("../../common/class/error.inc");
	include_once("../../common/class/sub.inc");
	include_once("../../common/class/paper.inc");
	include_once("../../common/class/question.inc");
	
		
	$questionObj = new question();
	
	if(!$questionObj->createConnect()){
		$errorObj=$questionObj->getError();
		$errorObj->showErrors($show_sql_flag=false);
	}
	//查出所有的题目
	$questionObj -> a_Search();
	$count = $questionObj -> getRecordCount();
	
?>

<html>

	<head>
		<meta charset="UTF-8">
		<title>所有题目</title>
		<link rel="stylesheet" href="../plugins/layui/css/layui.css" media="all" />
		<link rel="stylesheet" href="../css/global.css" media="all">
		<link rel="stylesheet" href="../plugins/font-awesome/css/font-awesome.min.css">
		<link rel="stylesheet" href="../css/table.css" />
	</head>
	<body>
		<div class="admin-main">
			<fieldset class="layui-elem-field">
				<legend>题目列表</legend>
				<div class="layui-field-box">
					<table class="site-table table-hover">
						
						<thead>
							<tr>
								<th>题目ID</th>
								<th>题目类型</th>
								<th>题干</th>
								<th>答案</th>
								<th>创建时间</th>
								<th>操作</th>
							</tr>
						</thead>
						<tbody>
							<?php
								$questionObj -> moveFirst();
								for( $i = 1 ; $i <= $count ; $i ++ ){
									$questionObj -> getOneRecord();
									$qid =  (int) $questionObj -> getQid(); 
								switch( (int) $questionObj -> getType() ){
									case 1:
										$type = "单选题";
										break;
									case 2:
										$type = "多选题";
										break;
									case 3:
										$type = "判断题";
										break;
									default:
										$type = "单选题";
										
								}
									$detail = urldecode ( $questionObj -> getDetail() );
									$dataCreateTime = $questionObj -> getData_Create_time();
									$ans = $questionObj -> getAns() ;
									$ansObj = json_decode ( $ans );
									$ansDetail ="解析失败"; 
									if( (int) $questionObj -> getType() == 3 )
										$ansDetail = $ans == 'T' ? "正确" : "错误";
									
									else{
										$ansDetail = "";
										for( $j = 0 ; $j < 4 ; $j ++ ){
											
											 $ansDetail .= ( urldecode ( $ansObj[$j] -> content ) . "--" . ( $ansObj[$j] -> right == "T" ? "正确" : "错误") ) ."<br>" ;
										}
									}
							?>
							<tr>
								<td><?php echo $qid; ?> </td>
								<td>
									<?php echo $type; ?>
								</td>
								<td>
									<?php echo $detail; ?>
								</td>
								<td>
									<?php echo $ansDetail; ?>
								</td>
								
								<td><?php echo  $dataCreateTime; ?></td>
								<td>
									<a  class="layui-btn layui-btn-normal layui-btn-mini" onclick = "editQuestion();">编辑</a>
									<a   class="layui-btn layui-btn-danger layui-btn-mini" onclick = "delQuestion( <?php echo $qid; ?> )">删除</a>
								</td>
							</tr>
							<?php
								$questionObj -> moveNext();
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
		
			function editQuestion(){
				
				alert("尚未实现");
			}
			
			function delQuestion( v ){
				
				layer.open({
				  title : '删除题目',
				  content: '确认删除该题目(ID：' + v + ')?'
				  ,btn: ['确定', '取消']
				  ,yes: function(index, layero){
					//按钮【确认】的回调
					var temp = document.createElement("form");      
					
					temp.action = "<?php echo P_HOMEPAGE_URL ?>" + "service/question/delQuestion.php";
					temp.method = "post";        
					temp.style.display = "none";        
					var opt = document.createElement("textarea");        
					opt.name = "Qid";        
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