<form class="layui-form layui-form-pane" action="POST" id="addUserForm" enctype="multipart/form-data">
	<div class="layui-form-item">
		<label class="layui-form-label">账号</label>
		<div class="layui-input-inline">
			<input type="text" name="username" lay-verify="required" autocomplete="off" placeholder="请输账号" class="layui-input">
		</div>
	</div>
	<div class="layui-form-item">
		<label class="layui-form-label">用户名称</label>
		<div class="layui-input-inline">
			<input type="text" name="display_name" lay-verify="required" placeholder="用户名称" autocomplete="off" class="layui-input">
		</div>
	</div>
	<div class="layui-form-item">
		<label class="layui-form-label">密码</label>
		<div class="layui-input-inline">
			<input type="text" name="password" lay-verify="required" placeholder="密码" autocomplete="off" class="layui-input">
		</div>
	</div>
	<div class="layui-form-item">
		<label class="layui-form-label">菜单权限</label>
	    <div class="layui-btn-container">
		  	<!-- <button type="button" class="layui-btn" lay-demotransferactive="getData">获取右侧数据</button>
		  	<button type="button" class="layui-btn" lay-demotransferactive="reload">重载实例</button> -->
		</div>
		<div id="menuListTransfer" class="demo-transfer"></div>
		<input type="hidden" name="menu_permission" id="menu_permission" value="" lay-verify="required" lay-reqtext="请选择至少一个菜单">
	</div>
	<div class="layui-form-item">
		<label class="layui-form-label">谷歌OTP权限</label>
		<div id="otpListTransfer" class="demo-transfer"></div>
		<input type="hidden" name="otp_permission" id="otp_permission" value="" lay-verify="required" lay-reqtext="请选择至少一个OTP">
	</div>
	<div class="layui-form-item">
		<label class="layui-form-label">头像上传</label>
		<input type="hidden" name="profile_pic" value="" id="profile_pic" class="layui-input">
		<div class="layui-upload-drag" id="imageUpload">
			<i class="layui-icon"></i>
			<p>点击上传，或将文件拖拽到此处</p>
			<div class="layui-hide" id="uploadDemoView">
			    <hr>
			    <img id="imgDisplay" alt="上传成功后渲染" style="max-width: 196px">
			</div>
		</div>
	</div>
	<div class="layui-form-item">
        <div class="layui-input-block">
            <button type="button" class="btn btn-label btn-primary" lay-submit="" lay-filter="submit"><label><i class="mdi mdi-checkbox-marked-circle-outline"></i></label> 添加</button>
        </div>
    </div>
</form>
<script type="text/javascript">
	layui.use(function(){
	  	//得到各种内置组件
	  	var layer = layui.layer, upload = layui.upload, element = layui.element, $ = layui.$; //下拉菜单
	  	var form = layui.form;
	  	var transfer = layui.transfer, util = layui.util;

		upload.render({
		    elem: '#imageUpload',
		    url: '/upload/user/profile/img',	//此处用的是第三方的 http 请求演示，实际使用时改成您自己的上传接口即可。
		    before: function(obj){
                obj.preview(function(index, file, result){
                    loading = layer.load(1, {shade: [0.1,'#fff']});
                    layui.$('#uploadDemoView').removeClass('layui-hide').find('img').attr('src', result);
                });
            },
		    done: function(res){
		    	layer.close(loading);
		      	layer.msg('上传成功');
		      	$('#profile_pic').val(res.data.filename);
		      	// console.log(res);
		    },
		    error: function(res){
		    	layer.close(loading);
		    	console.log(res);
		    }
		});

		form.on('submit(submit)', function (data) {
            loading =layer.load(1, {shade: [0.1,'#fff']});

            $.post("/add/user", data.field, function (res) {
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

		//get menu
        $.post("/get/json/menu/list", [], function (res) {
            transfer.render({
	    		elem: '#menuListTransfer',
	    		data: res.data,
	    		title: ['菜单', '给用户使用的菜单'],
	    		showSearch: true,
	    		id: 'menuListing',
	    		onchange: function(obj, index){
    				var getData = transfer.getData('menuListing'); //获取右侧数据
		      		getData = JSON.stringify(getData);
		      		$('#menu_permission').val(getData);
		      		if ($('#menu_permission').val() == "[]") {
		      			$('#menu_permission').val("");
		      		}
	    		}
	  		});
        }).fail((error) => {
	    	console.log(error);
        });

        //get otp
        $.post("/get/json/otp/list", [], function (res) {
            transfer.render({
	    		elem: '#otpListTransfer',
	    		data: res.data,
	    		title: ['菜单', '给用户使用的菜单'],
	    		showSearch: true,
	    		id: 'otpListing',
	    		onchange: function(obj, index){
    				var getData = transfer.getData('otpListing'); //获取右侧数据
		      		getData = JSON.stringify(getData);
		      		$('#otp_permission').val(getData);
		      		if ($('#otp_permission').val() == "[]") {
		      			$('#otp_permission').val("");
		      		}
	    		}
	  		});
        }).fail((error) => {
	    	console.log(error);
        });

    //     util.event('lay-demoTransferActive', {
	   //  	getData: function(othis){
	   //    		var getData = transfer.getData('menuListing'); //获取右侧数据
	   //    		getData = {"menu":JSON.stringify(getData)};
	   //    		console.log(getData);
	   //  	},
	   //  	reload:function(){
		  //     	//实例重载
		  //     	transfer.reload('menuListing', {
		  //       	title: ['菜单', '给用户使用的菜单'],
		  //       	value: [],
		  //       	showSearch: true
		  //    	})
	   //  	}
	  	// });
	});
</script>