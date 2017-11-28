<!DOCTYPE html><html><head><meta http-equiv="content-type" content="text/html;charset=utf-8"/>
<title>订单支付</title><meta content="width=device-width,initial-scale=1.0,minimum-scale=1.0,maximum-scale=1.0,user-scalable=0" name="viewport">
<link href="<?php echo env('APP_URL'); ?>/css/weixin/style.css" type="text/css" rel="stylesheet">
<script type="text/javascript" src="<?php echo env('APP_URL'); ?>/js/jquery.min.js"></script><script type="text/javascript" src="<?php echo env('APP_URL'); ?>/js/weixin/mobile.js"></script>
<meta name="keywords" content="关键词"><meta name="description" content="描述"></head><body>
<div class="classreturn loginsignup">
    <div class="ds-in-bl return"><a href="javascript:history.back(-1);"><img src="<?php echo env('APP_URL'); ?>/images/weixin/return.png" alt="返回"></a></div>
    <div class="ds-in-bl tit center"><span>订单支付</span></div>
    <div class="ds-in-bl nav_menu"><a href="javascript:void(0);"><img src="<?php echo env('APP_URL'); ?>/images/weixin/class1.png" alt="菜单"></a></div>
</div>

@include('weixin.common.headerNav')

<div class="floor">
<form action="<?php echo route('weixin_order_dopay'); ?>" method="POST" id="goto_pay">
<input type="hidden" name="order_id" value="<?php echo $order_id; ?>">
<div class="step_main">
    <div class="clue_on"><p>您的订单已成功生成，选择您想用的支付方式进行支付。</p></div>
    <div class="order_info">
        <p>订单编号：<span><?php echo $order_id; ?></span></p>
        <p>应付金额：<span>¥<?php echo $order_detail['order_amount']; ?></span></p>
    </div>
    <div class="payment mt10">
        <h3>选择支付方式付款</h3>
        <dl class="defray">
            <?php if($is_balance_enough){ ?>
            <dd>
                <p class="radio"><input id="payment_yuer" name="payment_id" value="1" type="radio"></p>
                <label for="payment_yuer"><p class="logo"><img src="<?php echo env('APP_URL'); ?>/images/weixin/yuepay_icon.png"></p>
                <p class="explain">余额支付</p></label>
            </dd>
            <?php } ?>
            <dd>
                <p class="radio"><input id="payment_wxpay" name="payment_id" value="2" type="radio" checked="checked"></p>
                <label for="payment_wxpay"><p class="logo"><img src="<?php echo env('APP_URL'); ?>/images/weixin/wxpay_icon.png"></p>
                <p class="explain">微信支付</p></label>
            </dd>
        </dl>
        <div class="cl"></div>
    </div>
    <a href="javascript:$('#goto_pay').submit();" class="bottoma" style="margin-top:10px;margin-bottom:15px;background-color:#1aad19;border:1px solid #179e16;color:white;border-radius:2px;text-align:center;">确认支付</a>
    <div class="remark" style="color:#666;">
        您可以在 <a href="<?php echo route('weixin_order_list'); ?>">我的订单</a> 中查看或取消您的订单。<br>
        如果您现在不方便支付，可以随后到 <a href="<?php echo route('weixin_order_list'); ?>">我的订单</a>完成支付，我们会在48小时内为您保留未支付的订单。
    </div>
</div>
</form>
</div>

<style>
.step_main{padding:10px;}
.step_main .clue_on{color:#666;}
.step_main .order_info{color:#999;}
.step_main .order_info span{color:#f34;}
.step_main h4,.step_main h3{padding:5px 0;font-weight:normal;color:#333;}
.defray{margin-top:5px;}
.defray dd{min-height:36px;line-height:36px;border-top:1px solid #eee;padding:6px 0;clear:both;}
.defray dd p.logo img{float:left;height:36px;}
.defray dd p.explain{float:left;color:#787878;margin-left:10px;}
.radio{float:left;width:20px;}
.bottoma{display:block;font-size:18px;padding:10px;color:white;background-color:#f23030;text-align:center;}
</style>

@include('weixin.common.footer')
</body></html>