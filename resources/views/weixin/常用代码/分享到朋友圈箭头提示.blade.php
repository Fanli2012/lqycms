<!DOCTYPE html><html><head><meta http-equiv="content-type" content="text/html;charset=utf-8"/>
<title>分享到朋友圈提示</title><meta content="width=device-width,initial-scale=1.0,minimum-scale=1.0,maximum-scale=1.0,user-scalable=0" name="viewport">
<link href="<?php echo env('APP_URL'); ?>/css/weixin/style.css" type="text/css" rel="stylesheet">
<script type="text/javascript" src="<?php echo env('APP_URL'); ?>/js/jquery.min.js"></script>
<meta name="keywords" content="关键词"><meta name="description" content="描述"></head><body>
<!-- 分享到朋友圈提示-start --><a href="javascript:;" onclick="document.getElementById('sharewxtip').style.display='block';">分享给朋友</a>
<div id="sharewxtip" onclick="document.getElementById('sharewxtip').style.display='';" style="display:none;">
     <img src="<?php echo env('APP_URL'); ?>/images/weixin/wxguide.png">
</div>
<style>
#sharewxtip {position: fixed;top: 0;left: 0;width: 100%;height: 100%;background: rgba(0, 0, 0, 0.7);display: none;z-index: 20000;}
#sharewxtip img {position: fixed;right: 18px;top: 5px;width: 260px;height: 180px;z-index: 999;}
</style>
<!-- 分享到朋友圈提示-end -->
</body></html>