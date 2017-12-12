<!DOCTYPE html><html><head><meta http-equiv="content-type" content="text/html;charset=utf-8"/>
<title>资金管理</title><meta name="keywords" content="关键词"><meta name="description" content="描述"><meta content="width=device-width,initial-scale=1.0,minimum-scale=1.0,maximum-scale=1.0,user-scalable=0" name="viewport">
<link href="<?php echo env('APP_URL'); ?>/css/weixin/style.css" type="text/css" rel="stylesheet">
<script type="text/javascript" src="<?php echo env('APP_URL'); ?>/js/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo env('APP_URL'); ?>/js/weixin/mobile.js"></script>
<link href="<?php echo env('APP_URL'); ?>/css/font-awesome.min.css" type="text/css" rel="stylesheet"></head><body>
<div class="classreturn loginsignup">
    <div class="ds-in-bl return"><a href="javascript:history.back(-1);"><img src="<?php echo env('APP_URL'); ?>/images/weixin/return.png" alt="返回"></a></div>
    <div class="ds-in-bl tit center"><span>资金管理</span></div>
    <div class="ds-in-bl nav_menu"><a href="<?php echo route('weixin_user_money_list'); ?>">余额明细</a></div>
</div>

<style>
.account{text-align:center;margin-top:30px;}
.account .icon{color:#FFCC00;font-size:100px;}
.account .money{color:#353535;font-size:36px;}
.account .tit{color:#000;font-size:18px;}
.bottoma{display:block;font-size:18px;padding:10px;border-radius:2px;}
</style>
<div class="floor account">
    <div class="icon"><i class="fa fa-diamond"></i></div>
    <div class="tit">我的余额</div>
    <div class="money"><small>￥</small><?php echo $user_info['money']; ?></div>
    <br>
    <a style="margin:10px;background-color:#1aad19;text-align:center;color:white;border:1px solid #179e16;" class="bottoma" href="<?php echo route('weixin_user_recharge'); ?>">充值</a>
    <a style="margin:0 10px 10px 10px;background-color:#f1f1f1;text-align:center;color:#000;border:1px solid #bfbfbf;" class="bottoma" href="<?php echo route('weixin_user_withdraw'); ?>">提现</a>
</div>

<script type="text/javascript" src="<?php echo env('APP_URL'); ?>/js/layer/mobile/layer.js"></script>
<script>
function tixian()
{
    //页面层
    layer.open({
        type: 1
        ,content: '<div style="padding:15px;"><a style="margin-bottom:10px;background-color:#1aad19;text-align:center;color:white;border:1px solid #179e16;" class="bottoma" onclick="layer.closeAll();" href="javascript:;">银行提现</a><a style="margin-bottom:10px;background-color:#ea5a3d;text-align:center;color:white;border:1px solid #dd2727;" class="bottoma" onclick="layer.closeAll();" href="javascript:;">微信提现</a><a style="background-color:#f1f1f1;text-align:center;color:#000;border:1px solid #bfbfbf;" class="bottoma" onclick="layer.closeAll();" href="javascript:;">取消</a></div>'
        ,anim: 'up'
        ,style: 'position:fixed;bottom:0;left:0;width:100%;border:none;'
    });
}
</script>
@include('weixin.common.footer')
</body></html>