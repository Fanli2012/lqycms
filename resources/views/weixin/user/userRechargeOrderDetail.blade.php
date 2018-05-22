<!DOCTYPE html><html><head><meta http-equiv="content-type" content="text/html;charset=utf-8"/>
<title>充值-支付</title><meta name="keywords" content="关键词"><meta name="description" content="描述"><meta content="width=device-width,initial-scale=1.0,minimum-scale=1.0,maximum-scale=1.0,user-scalable=0" name="viewport">
<link href="<?php echo env('APP_URL'); ?>/css/weixin/style.css" type="text/css" rel="stylesheet">
<script type="text/javascript" src="<?php echo env('APP_URL'); ?>/js/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo env('APP_URL'); ?>/js/weixin/mobile.js"></script>
<script>
//调用微信JS api 支付
function jsApiCall()
{
	WeixinJSBridge.invoke(
		'getBrandWCPayRequest',
		<?php echo $jsApiParameters; ?>,
		function(res){
			WeixinJSBridge.log(res.err_msg);
			//alert(res.err_code+res.err_desc+res.err_msg);
            
            if(res.err_msg=='get_brand_wcpay_request:ok')
            {
				alert('支付成功');
			}
            else
            {
				alert('支付失败');
			}
            
			setTimeout("location.href = '<?php echo $returnUrl; ?>'",1000);
		}
	);
}

function callpay()
{
	if (typeof WeixinJSBridge == "undefined"){
		if( document.addEventListener ){
			document.addEventListener('WeixinJSBridgeReady', jsApiCall, false);
		}else if (document.attachEvent){
			document.attachEvent('WeixinJSBridgeReady', jsApiCall); 
			document.attachEvent('onWeixinJSBridgeReady', jsApiCall);
		}
	}else{
		jsApiCall();
	}
}
</script>
</head><body onload="callpay();">

<div class="classreturn loginsignup">
    <div class="ds-in-bl return"><a href="javascript:history.back(-1);"><img src="<?php echo env('APP_URL'); ?>/images/weixin/return.png" alt="返回"></a></div>
    <div class="ds-in-bl tit center"><span>充值</span></div>
</div>

<style>
.bottoma{display:block;font-size:18px;padding:10px;border-radius:2px;}
</style>
<div class="floor">
    <div style="margin:10px;text-align:left;">
        <p>充值订单已于 <b style="color:#fea700;"><?php echo date('Y-m-d H:i:s', $post['created_at']); ?></b> 提交成功，请您尽快付款！</p>
        订单号：<?php echo $post['id']; ?><br>
        应付金额：<strong style="color:#D03737;">￥<?php echo $post['money']; ?></strong> 元<br><br>

        <p style="color:#999;font-size:.875em">请您在提交订单后30分钟内完成支付，否则订单会自动取消。</p>
    </div>
    <a style="margin:0 10px 10px 10px;background-color:#1aad19;text-align:center;color:#fff;border:1px solid #179e16;" class="bottoma" href="javascript:callpay();">去支付</a>
</div>
</body></html>