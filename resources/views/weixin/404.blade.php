<!DOCTYPE html><html><head><meta http-equiv="content-type" content="text/html;charset=utf-8"/>
<title>您访问的页面不存在或已被删除！</title><meta content="width=device-width,initial-scale=1.0,minimum-scale=1.0,maximum-scale=1.0,user-scalable=0" name="viewport">
<link href="<?php echo env('APP_URL'); ?>/css/weixin/style.css" type="text/css" rel="stylesheet">
<meta name="keywords" content="系统提示"><meta name="description" content="系统提示"></head><body>
<style>
.successsystem{text-align:center;padding:30px 0}
.successsystem img{width:100px;height:100px}
.prompt_s{font-size:16px;color:#999999;text-align:center}
.systemprompt{text-align:center;margin-top:30px}
.systemprompt a{display:inline-block;width:40%;height:36px;line-height:36px;background:#f23030;text-align:center;color:white;border-radius:3px;margin:0 10px;font-size:16px;}
</style>
<div class="classreturn loginsignup">
    <div class="ds-in-bl return"><a href="javascript:history.back(-1);"><img src="<?php echo env('APP_URL'); ?>/images/weixin/return.png" alt="返回"></a></div>
    <div class="ds-in-bl tit center"><span>系统提示</span></div>
</div>
<div class="successsystem">
    <img src="<?php echo env('APP_URL'); ?>/images/weixin/icogantanhao-sb.png">
</div>
<p class="prompt_s">
    您访问的页面不存在或已被删除！，等待时间：<b id="wait">3</b>
</p>
<div class="systemprompt">
    <a href="<?php if(isset($_SERVER["HTTP_REFERER"])){echo $_SERVER['HTTP_REFERER'];}else{echo route('weixin');} ?>" id="href">返回上一页</a>
    <a href="<?php echo route('weixin'); ?>">返回首页</a>
</div>
<script type="text/javascript">
(function(){
var wait = document.getElementById('wait'),href = document.getElementById('href').href;
var interval = setInterval(function(){
	var time = --wait.innerHTML;
	if(time <= 0)
    {
		location.href = href;
		clearInterval(interval);
	};
}, 1000);
})();
</script>
</body></html>