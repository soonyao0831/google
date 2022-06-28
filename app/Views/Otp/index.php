<fieldset class="layui-field-title" style="margin-top: 20px;">
	<legend>OTP列表</legend>
</fieldset>
<hr class="layui-border-black">
<table class="layui-hide" id="userTable" lay-filter="userTableToolBar"></table>
<script type="text/html" id="actionTool">
	<a class="layui-btn layui-btn-primary layui-btn-xs" lay-event="edit" id="editBtn">编辑</a>
</script>
<script type="text/html" id="addTool">
	<a class="layui-btn layui-btn-primary layui-btn-xs" lay-event="add" id="addBtn" data-method="modalAddUser">添加</a>
</script>
<script type="text/javascript">
	layui.use(function(){
	  	//得到各种内置组件
	  	var layer = layui.layer, laypage = layui.laypage, laydate = layui.laydate, table = layui.table,
	  		upload = layui.upload, element = layui.element, dropdown = layui.dropdown //下拉菜单

	  	//执行一个 table 实例
	  	table.render({
	  		id:"userTable",
		  	elem: '#userTable',
		  	height: 500,
		  	url: '/list/otp',
		  	title: '用户表',
		  	method: 'POST',
		    page: true, //开启分页
		    toolbar: '#addTool', //开启工具栏，此处显示默认图标，可以自定义模板，详见文档
		    defaultToolbar: ['add','filter', 'exports', 'print'],
		    totalRow: true, //开启合计行
		    cols: [[ //表头
			    // {field: 'id', title: 'ID', width:80, sort: true, fixed: 'left'},
			    {type:'numbers'},
			    {field: 'account', title: '账户'},
			    {field: 'display_name', title: '名称'},
			    {field: 'secret', title: '密钥'},
			    {fixed: 'right', width: 150, align:'center', toolbar: '#actionTool'}
		    ]],
            limit: 50,
		    done: function(res, curr, count) {
		    	console.log(res);
		    },
		    error: function(res){
		    	console.log(res);
		    }
		});

	  	//监听头工具栏事件
	  	table.on('toolbar(userTableToolBar)', function(obj){
	  		switch(obj.event){
		    	case 'add':
			    	var othis = $(this);
			    	var method = othis.data('method');
		   			active[method] ? active[method].call(this, othis) : '';
		   		break;
	    	};
		});
	  	var active = {
	  		modalAddUser: function(othis){
			    layer.open({
			        type: 2,
			        area: ['700px', '620px'],
			        id: 'addBtn1', //防止重复弹出
			        content: "/web/modal/otp/add",
			        fixed: false,
			        maxmin: true,
			        // btn: ['添加', '关闭'],
			        shade: 0.5, //不显示遮罩
			        success: function(layero, index){

	        		}
			    });
		    }
	    };
	    table.on('tool(userTableToolBar)', function(obj) {
            var data = obj.data;
            if(obj.event === 'edit'){
                layer.open({
			        type: 2,
			        area: ['700px', '620px'],
			        id: 'editBtn2', //防止重复弹出
			        content: "/web/modal/otp/edit?id="+data.id,
			        fixed: false,
			        maxmin: true,
			        // btn: ['添加', '关闭'],
			        shade: 0.5, //不显示遮罩
			        success: function(layero, index){

	        		}
			    });
            }
        });
	});
</script>