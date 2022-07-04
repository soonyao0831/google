<html>
<head>
    <title>Chesse OTP</title>
    <link rel="stylesheet" href="/public/static/css/bootstrap.min.css?v=<?=time()?>">
    <script src="/public/static/js/jquery-3.2.1.min.js?v=<?=time()?>"></script>
    <link rel="stylesheet" href="/public/static/layui/css/layui.css?v=<?=time()?>">
    <script src="/public/static/layui/layui.js?v=<?=time()?>"></script>
    <script src="/public/static/common.js?v=<?=time()?>"></script>
    <script src="/public/static/clipboard/dist/clipboard.min.js?v=<?=time()?>"></script>
	<script src="/public/static/demo-recorder/js/recorder.js?v=<?=time()?>"></script>
	<script src="/public/static/demo-recorder/js/app.js?v=<?=time()?>"></script>
</head>
<body style="height: 100%;">
	<div class="layui-layout layui-layout-admin">
	    <div class="layui-header">
	        <div class="layui-logo layui-hide-xs layui-bg-black">奶酪OTP</div>
	        <!-- 头部区域（可配合layui 已有的水平导航） -->
	        <ul class="layui-nav layui-layout-left">
	            <!-- 移动端显示 -->
	            <li class="layui-nav-item layui-show-xs-inline-block layui-hide-sm" lay-header-event="menuLeft">
	                <i class="layui-icon layui-icon-spread-left"></i>
	            </li>
	            <li class="layui-nav-item layui-hide-xs">
	            	<input type="text" class="layui-input layui-hide" id="currentDate">
	            	<span id="showDate"></span>
	            </li>
	        </ul>
	        <ul class="layui-nav layui-layout-right">
	            <li class="layui-nav-item layui-hide layui-show-md-inline-block">
	                <a href="javascript:;">
	                    <img src="/public/static/image/profile_img.PNG" class="layui-nav-img" id="profile_img">
	                    <label id="profile_name"><?=$username?></label>
	                </a>
	                <dl class="layui-nav-child">
	                    <dd><a href="#">个人档案</a></dd>
	                    <dd><a href="">设置</a></dd>
	                    <dd><a href="#" id="logoutBtn">退出</a></dd>
	                </dl>
	            </li>
	            <li class="layui-nav-item" lay-header-event="menuRight" lay-unselect>
	                <a href="javascript:;">
	                    <i class="layui-icon layui-icon-more-vertical"></i>
	                </a>
	            </li>
	        </ul>
	    </div>

	    <div class="layui-side layui-bg-black">
	        <div class="layui-side-scroll">
	            <!-- 左侧导航区域（可配合layui已有的垂直导航） -->
	            <ul class="layui-nav layui-nav-tree" lay-filter="test" id="menuList">

	            </ul>
	        </div>
	    </div>

	    <div class="layui-body">
	        <!-- 内容主体区域 -->
	        <div style="padding: 15px;"><?=$content?></div>
	    </div>

	    <div class="layui-footer">
	        <!-- 底部固定区域 -->
	        底部啥也没有
	    </div>
	</div>
	<script>
	//JS
	layui.use(['element', 'layer', 'util', 'laydate'], function(){
	    var element = layui.element, layer = layui.layer, util = layui.util, $ = layui.$;
	    var laydate = layui.laydate;

		//执行一个laydate实例
		interval = setInterval(function(){
			laydate.render({
			    elem: '#currentDate',
			    type: 'datetime',
			    value: new Date(),
			});
			$('#showDate').html($('#currentDate').val());
			readOtpLog();
		},1000);

		$('#logoutBtn').click(function(){
			loading = layer.load(1, {shade: [0.1,'#fff']});
			$.post("/auth/logout", [], function (res) {
                layer.close(loading);
                if (res.success) {
                    layer.msg(res.message, {time: 1500, icon: 1}, function () {
                        window.location.href = "/web/login";
                    });
                } else {
                    layer.msg(res.message, {time: 1500, icon: 2});
                }
                return false;
            });
		});

		$(document).ready(function(){
			getProfileData();
			getMenuList();
			setOtpSession();
		});

		function getProfileData(){
			var username = "<?=$username?>";
			$.post("/get/user/profile", {"username":username}, function (res) {
                if (res.success) {
                	$('#profile_img').attr('src',res.data.profile_pic);
                	$('#profile_name').html(res.data.display_name);
                } else {
                	$.post("/auth/logout", [], function (res) {
		                window.location.href = "/web/login";
		            });
                }
            });
		}

		function getMenuList(){
			var username = "<?=$username?>";
			$.post("/get/menu/list", {"username":username}, function (res) {
				console.log(res);
                if (res.success) {
                	var html = '';
                	$.each( res.data , function( key, value ) {
					  	html += `<li class="layui-nav-item"><a href="`+value.menu_path+`">`+value.menu_name+`</a></li>`
					});
                	$('#menuList').html(html);
                }
            }).fail(function(error){
            	console.log(error);
            });
		}

		function setOtpSession(){
			$.post("/set/otp/session", [], function (res) {
            });
		}

		function readOtpLog(){
			$.post("/list/all/otp/log", {}, function( res ) {
				var html = '';
				$.each( res.data , function( key, value ) {
					html += `<div class="layui-font-12"><b>`+value.log_time+`</b> IP (`+value.log_ip+`)</div>`;
					html += `<div class="layui-font-14">`+value.username+` : `+ value.log +`</div><br>`;
				});
				//头部事件
				util.event('lay-header-event', {
					//左侧菜单事件
					menuLeft: function(othis){
					    layer.msg('展开左侧菜单的操作', {icon: 0});
					},
					menuRight: function(){
					    layer.open({
					        type: 1,
					        content: `<div style="padding: 15px;">
		    							`+html+`
		    						</div>`,
					        area: ['400px', '100%'],
					        offset: 'rt', //右上角
					        anim: 5,
					        shadeClose: true
						});
					}
				});
			});
		}
	});
	</script>
</body>
</html>