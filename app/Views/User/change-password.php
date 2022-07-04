<fieldset class="layui-field-title" style="margin-top: 20px;">
	<legend>用户密码</legend>
</fieldset>
<form class="layui-form layui-form-pane" method="POST" id="changePasswordForm">
	<div class="layui-form-item">
		<label class="layui-form-label">当前密码</label>
		<div class="layui-input-inline">
			<input type="text" name="current_password" lay-verify="required" autocomplete="off" placeholder="请输当前密码" class="layui-input">
		</div>
	</div>
	<div class="layui-form-item">
		<label class="layui-form-label">新密码</label>
		<div class="layui-input-inline">
			<input type="text" name="new_password" lay-verify="required" placeholder="请输新密码" autocomplete="off" class="layui-input">
		</div>
	</div>
	<div class="layui-form-item">
        <div class="layui-input-block">
            <button type="button" class="layui-btn" lay-submit="" lay-filter="submit">提交</button>
        </div>
    </div>
</form>
<script type="text/javascript">
	layui.use(function(){
        //得到各种内置组件
        var layer = layui.layer, element = layui.element;//下拉菜单
        var form = layui.form;

        form.on('submit(submit)', function (data) {
            loading = layer.load(1, {shade: [0.1,'#fff']});

            $.post("/change/user/password", data.field, function (res) {
            	console.log(res);
                layer.close(loading);
                if (res.success) {
                    layer.msg(res.message, {time: 1500, icon: 1}, function () {
                        location.reload();
                    });
                } else {
                    layer.msg(res.message, {time: 1500, icon: 2});
                }
            }).fail((error) => {
            	layer.close(loading);
		    	console.log(error);
	        });
        });
    });
</script>