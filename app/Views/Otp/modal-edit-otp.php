<form class="layui-form layui-form-pane" action="POST" id="addUserForm" enctype="multipart/form-data">
	<input type="hidden" name="id" id="id" lay-verify="required" autocomplete="off" placeholder="" class="layui-input">
	<div class="layui-form-item">
		<label class="layui-form-label">账号</label>
		<div class="layui-input-inline">
			<input type="text" name="account" id="account" disabled lay-verify="required" autocomplete="off" placeholder="请输账号" class="layui-input">
		</div>
	</div>
	<div class="layui-form-item">
		<label class="layui-form-label">名称</label>
		<div class="layui-input-inline">
			<input type="text" name="display_name" id="display_name" lay-verify="required" placeholder="用户名称" autocomplete="off" class="layui-input">
		</div>
	</div>
	<div class="layui-form-item">
		<label class="layui-form-label">密码</label>
		<div class="layui-input-block">
			<input type="text" name="secret" id="secret" lay-verify="required" placeholder="密钥" autocomplete="off" class="layui-input">
		</div>
	</div>
	<div class="layui-form-item">
        <div class="layui-input-block">
            <button type="button" class="btn btn-label btn-primary" lay-submit="" lay-filter="submit"><label><i class="mdi mdi-checkbox-marked-circle-outline"></i></label> 编辑</button>
        </div>
    </div>
</form>
<script type="text/javascript">
	layui.use(function(){
	  	//得到各种内置组件
	  	var layer = layui.layer, element = layui.element, $ = layui.$; //下拉菜单
	  	var form = layui.form;

	  	$('#id').val("<?=$id?>");

	  	$.post("/get/otp/by/id", {id: "<?=$id?>"}, function (res) {
            console.log(res);
            if (res.success) {
		     	$('#account').val(res.data.account);
		     	$('#display_name').val(res.data.display_name);
		     	$('#secret').val(res.data.secret);
            }
        }).fail((error) => {
	    	console.log(error);
        });

		form.on('submit(submit)', function (data) {
            loading =layer.load(1, {shade: [0.1,'#fff']});

            $.post("/edit/otp", data.field, function (res) {
            	console.log(res);
                layer.close(loading);
                if (res.success) {
                    layer.msg(res.message, {time: 1500, icon: 1}, function () {
                        var index = parent.layer.getFrameIndex(window.name);
                        window.parent.location.reload();
                        parent.layer.close(index);
                    });
                } else {
                    layer.msg(res.message, {time: 1500, icon: 2});
                }
            }).fail((error) => {
            	layer.close(loading);
		    	console.log(error);
	        });
        });

        $("#account").on({
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