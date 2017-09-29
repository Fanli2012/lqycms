<!DOCTYPE html><html><head><meta http-equiv="content-type" content="text/html;charset=utf-8"/>
<title>系统提示</title><meta content="width=device-width,initial-scale=1.0,minimum-scale=1.0,maximum-scale=1.0,user-scalable=0" name="viewport">
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
<?php
/** 参数说明 
 * $_REQUEST['message']; //成功提示
 * $_REQUEST['error']; //失败提示
 * $_REQUEST['url']; //要跳转到哪里
 * $_REQUEST['time']; //几秒后跳转
 */
?>
<div class="successsystem">
    <?php if(isset($_REQUEST['message'])) {?>
        <img src="<?php echo env('APP_URL'); ?>/images/weixin/icogantanhao.png">
    <?php }else{ ?>
        <img src="<?php echo env('APP_URL'); ?>/images/weixin/icogantanhao-sb.png">
    <?php }?>
</div>
<p class="prompt_s">
    <?php if(isset($_REQUEST['message'])) { ?>
    <?php echo $_REQUEST['message']; ?>
    <?php }elseif(isset($_REQUEST['error'])){ ?>
    <?php echo $_REQUEST['error']; ?>
    <?php } ?>
    ，等待时间：<b id="wait"><?php if(isset($_REQUEST['time'])){ echo $_REQUEST['time']; } ?></b>
</p>
<div class="systemprompt">
    <a href="<?php if(isset($_REQUEST['url'])){ echo $_REQUEST['url']; } ?>" id="href">返回上一页</a>
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