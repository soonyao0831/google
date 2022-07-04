<fieldset class="layui-field-title" style="margin-top: 20px;">
	<legend>首页</legend>
</fieldset>点击即可复制

<!--     <div id="controls">
  		<button id="recordButton">Record</button>
  		<button id="pauseButton" disabled>Pause</button>
  		<button id="stopButton" disabled>Stop</button>
    </div>
    <div id="formats">Format: start recording to see sample rate</div>
  	<p><strong>Recordings:</strong></p>
  	<ol id="recordingsList"></ol>
<audio src="/public/1656386532.wav" controls controlsList="nodownload"></audio> -->


<hr class="layui-border-black">
<div class="layui-bg-gray" style="padding: 30px;">
	<div class="layui-row layui-col-space15" id="otpPanel">

	</div>
</div>
<script type="text/javascript">
	layui.use(['element', 'layer', 'util', 'laydate'], function(){
	    var element = layui.element, layer = layui.layer, util = layui.util, $ = layui.$;
	    var laydate = layui.laydate;

	    //webkitURL is deprecated but nevertheless
		// URL = window.URL || window.webkitURL;

		// var gumStream; 						//stream from getUserMedia()
		// var rec; 							//Recorder.js object
		// var input; 							//MediaStreamAudioSourceNode we'll be recording

		// shim for AudioContext when it's not avb.
		// var AudioContext = window.AudioContext || window.webkitAudioContext;
		// var audioContext;

		// var recordButton = document.getElementById("recordButton");
		// var stopButton = document.getElementById("stopButton");
		// var pauseButton = document.getElementById("pauseButton");

		//add events to those 2 buttons
		// recordButton.addEventListener("click", startRecording);
		// stopButton.addEventListener("click", stopRecording);
		// pauseButton.addEventListener("click", pauseRecording);

		$('#otpPanel').html();
		loading = layer.load(1, {shade: [0.1,'#fff']});
		$.post("/get/otp/list", {username:"<?=$username?>"}, function (res) {
	        layer.close(loading);
	        if (res.success) {
	        	var html = '';
	            $.each( res.data , function( key, value ) {
				  	html += `<div class="layui-col-md6">
								<div class="layui-card">
									<div class="layui-card-header"><b>`+value.display_name+`</b></div>
									<hr class="layui-border-blue">
									<div class="layui-card-body">
										<button class="copybtn layui-btn layui-btn-normal otpClickLog" data-clipboard-text="`+value.secret+`" data-name="`+value.display_name+`">
											<label id="`+value.account+`">Click Me Copy OTP</label>
										</button>
									</div>
									<div class="layui-card-body">
										<div class="d-flex align-items-center">
										  	<strong>Loading...</strong>
										  	<div class="spinner-border ms-auto" role="status" aria-hidden="true"></div>
										</div>
									</div>
								</div>
							</div>`;
				});
				$('#otpPanel').html(html);
	        }
	    }).fail((error) => {
	    	layer.close(loading);
	    	console.log(error);
        });

		let countStart = false;
		let width = 100;
		loopRefresh = setInterval(function(){
			if(countStart){
				width -= 1*3.33;//(time*3.33);
				$('.layui-progress-bar').attr('lay-percent', width + "%");
				$('.layui-progress-bar').attr('style',"width:" + width +"%;");
			}
	        $.post("/otp/refresh/status", [], function(res) {
	        	if(typeof res == 'object'){
	        		if(res.data.isRefresh){
				  		$.post("/get/otp/list", {username:"<?=$username?>"}, function( res ) {
							var html = '';
				            $.each( res.data , function( key, value ) {
							  	html += `<div class="layui-col-md6">
											<div class="layui-card">
												<div class="layui-card-header"><b>`+value.display_name+`</b></div>
												<hr class="layui-border-blue">
												<div class="layui-card-body">
													<button class="copybtn layui-btn layui-btn-normal otpClickLog" data-clipboard-text="`+value.secret+`" data-name="`+value.display_name+`">
														<label>Click Me Copy OTP</label>
													</button>
												</div>
												<div class="layui-card-body">
													<div class="layui-progress layui-progress-big">
													  	<div class="layui-progress-bar layui-bg-blue" lay-percent="100%" style="width:100%;"></div>
													</div>
												</div>
											</div>
										</div>`;
							});
							$('#otpPanel').html(html);
							countStart = true;
							width = 100;
						});
				  	}
	        	}else{
	        		clearInterval(loopRefresh);
	        		layer.open({
					  	content: '登录已过期, 请重新登录。',btn: ['确定'],
					  	yes: function(index, layero){
					  		location.reload();
					  	}
					});
	        	}
	        }).fail((error) => {
	        	clearInterval(loopRefresh);
		    	console.log(error);
	        });
	    },1000);

	    var clipboard = new ClipboardJS('.copybtn');
        clipboard.on('success', function(e) {
            layer.msg("复制成功");
            e.clearSelection();
        });
        clipboard.on('error', function(e) {
            layer.msg("复制失败,请手动复制");
        });

        $(document).on('click','.otpClickLog',function(){
			$.post("/save/otp/click/log", {otp_name:$(this).data("name")}, function( res ) {

			});
		});

    });
</script>