<div class="container">
    <div class="row">
        <div class="col-sm-9 col-md-7 col-lg-5 mx-auto">
            <div class="card card-signin my-5">
                <div class="card-body">
                    <h5 class="card-title text-center">奶酪OTP</h5>
                    <br>
                    <form class="layui-form" id="loginForm" method="POST">
                        <div class="layui-form-item">
                            <label class="layui-form-label">账户</label>
                            <div class="layui-input-block">
                                <input type="text" name="username" required lay-verify="required" placeholder="请输入标题" autocomplete="off" class="layui-input">
                            </div>
                        </div>
                        <div class="layui-form-item">
                            <label class="layui-form-label">密码</label>
                            <div class="layui-input-block">
                                <input type="password" name="password" required lay-verify="required" placeholder="请输入标题" autocomplete="off" class="layui-input">
                            </div>
                        </div>
                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <button class="layui-btn" lay-submit lay-filter="submitBtn" id="loginBtn">立即提交</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    layui.use('form', function(){
        var form = layui.form;
        //监听提交
        form.on('submit(submitBtn)', function(data){
            loading = layer.load(1, {shade: [0.1,'#fff']});
            $.post("/auth/login", data.field, function (res) {
                layer.close(loading);
                if (res.success) {
                    layer.msg(res.message, {time: 1500, icon: 1}, function () {
                        window.location.href = "/web/home";
                    });
                } else {
                    layer.msg(res.message, {time: 1500, icon: 2});
                }
                return false;
            });
            return false;
        });

        // $('#loginForm').keypress(function(e){
        //     if(e.which == 13){
        //         $('#loginBtn').click();
        //     }
        // });
    });
</script>