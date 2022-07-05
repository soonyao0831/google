<fieldset class="layui-field-title" style="margin-top: 20px;">
	<legend>白名单IP</legend>
</fieldset>
<form class="layui-form layui-form-pane" method="POST" id="changePasswordForm">
	<div class="layui-form-item">
		<label class="layui-form-label">当前IP</label>
		<div class="layui-input-block">
			 <textarea placeholder="多个IP (0.0.0.0,1.1.1.1)" class="layui-textarea" name="ip_list" id="ip_list"></textarea>
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

            $.post("/add/ip", data.field, function (res) {
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

        $.post("/get/ip/list", {}, function(res){
        	$("#ip_list").val(res.data);
        }).fail((error) => {
        	console.log(error);
        });

        $("#ip_list").on({
		  	keydown: function(e) {
		    	if (e.which === 32)
		      		return false;
		  	},
		  	change: function() {
		    	this.value = this.value.replace(/\s/g, "");
		  	}
		});
    });
</script>