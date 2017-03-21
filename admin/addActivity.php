<!DOCTYPE html>
<html>

	<head>
		<meta charset="utf-8">
		<title>新增活动</title>
		<meta name="renderer" content="webkit">
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
		<meta name="apple-mobile-web-app-status-bar-style" content="black">
		<meta name="apple-mobile-web-app-capable" content="yes">
		<meta name="format-detection" content="telephone=no">

		<link rel="stylesheet" href="plugins/layui/css/layui.css" media="all" />
		<link rel="stylesheet" href="plugins/font-awesome/css/font-awesome.min.css">
	</head>

	<body>
		<div style="margin: 15px;">
			<fieldset class="layui-elem-field layui-field-title" style="margin-top: 20px;">
				<legend>新增活动</legend>
			</fieldset>

			<form class="layui-form" action="">
				<div class="layui-form-item">
					<label class="layui-form-label">活动名称</label>
					<div class="layui-input-block">
						<input type="text" name="title" lay-verify="title" autocomplete="off" placeholder="请输入活动名称" class="layui-input">
					</div>
				</div>
				<div class="layui-form-item layui-form-text">
					<label class="layui-form-label">活动说明</label>
					<div class="layui-input-block">
						<textarea placeholder="请输入内容" class="layui-textarea"></textarea>
					</div>
				</div>
				<div class="layui-form-item">
					<label class="layui-form-label">下属科目</label>
					<div class="layui-input-block">
						<input type="checkbox" name="like[write]" title="写v发v地方v发的v发v作">
						<input type="checkbox" name="like[read]" title="阅读" checked="">
						<input type="checkbox" name="like[game]" title="游戏">
					</div>
				<div class="layui-form-item">
					<div class="layui-input-block">
						<button class="layui-btn" lay-submit="" lay-filter="demo1">立即提交</button>
						<button type="reset" class="layui-btn layui-btn-primary">重置</button>
					</div>
				</div>
			</form>
		</div>
		<script type="text/javascript" src="plugins/layui/layui.js"></script>
		<script>
			layui.use(['form', 'layedit', 'laydate'], function() {
				var form = layui.form(),
					layer = layui.layer,
					layedit = layui.layedit,
					laydate = layui.laydate;

				//创建一个编辑器
				var editIndex = layedit.build('LAY_demo_editor');
				//自定义验证规则
				form.verify({
					title: function(value) {
						if(value.length < 5) {
							return '标题至少得5个字符啊';
						}
					},
					pass: [/(.+){6,12}$/, '密码必须6到12位'],
					content: function(value) {
						layedit.sync(editIndex);
					}
				});

				//监听提交
				form.on('submit(demo1)', function(data) {
					layer.alert(JSON.stringify(data.field), {
						title: '最终的提交信息'
					})
					return false;
				});
			});
		</script>
	</body>

</html>