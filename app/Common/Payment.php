<?php
namespace App\Common;

class Payment
{
    //微信APP支付
	public static function WeixinPayApp($attributes2,$config = config('weixin.app'))
    {
		//1.配置
		//$config = config('weixin.app');
        
		$app = new \EasyWeChat\Foundation\Application($config);
		$payment = $app->payment;
		
		//2.创建订单
		$attributes = array(
			'trade_type'       => 'APP', // JSAPI，NATIVE，APP...
			'body'             => '订单支付',
			'detail'           => '订单支付',
			'out_trade_no'     => 'fghfdgfg789',
			'total_fee'        => '123.00', // 单位：分
			'notify_url'       => 'http://www.baidu.com/aaa.php', // 支付结果通知网址，如果不设置则会使用配置里的默认地址
			//'openid'           => '当前用户的 openid', // trade_type=JSAPI，此参数必传，用户在商户appid下的唯一标识，
			// ...
		);
        
		$order = new \EasyWeChat\Payment\Order(array_merge($attributes, $attributes2));
        
		//3.统一下单
		$result = $payment->prepare($order);
        
		if ($result->return_code == 'SUCCESS' && $result->result_code == 'SUCCESS')
		{
			$prepayId = $result->prepay_id;
			$res = $payment->configForAppPayment($prepayId);
            
            return $res;
		}
        
		return false;
    }
    
    /** 
     * 支付宝APP支付
     * bizcontent
     * 支付宝APP支付
     */
	public function AlipayApp($bizcontent,$notify_url,$config = config('alipay.app_alipay'))
    {
        require_once base_path('resources/org/alipay_app').'/AopClient.php';
        require_once base_path('resources/org/alipay_app').'/AlipayTradeAppPayRequest.php';
        
        $aop = new \AopClient;
        $aop->gatewayUrl = "https://openapi.alipay.com/gateway.do";
        $aop->appId = $config['appId'];
        $aop->rsaPrivateKey = $config['rsaPrivateKey'];
        $aop->format = "json";
        $aop->charset = "UTF-8";
        $aop->signType = "RSA2";
        $aop->alipayrsaPublicKey = $config['alipayrsaPublicKey'];
        //实例化具体API对应的request类,类名称和接口名称对应,当前调用接口名称：alipay.trade.app.pay
        $request = new \AlipayTradeAppPayRequest();
        //SDK已经封装掉了公共参数，这里只需要传入业务参数
        /* $bizcontent = "{\"body\":\"订单支付\"," 
                        . "\"subject\": \"订单支付\","
                        . "\"out_trade_no\": \""."jklkjlkj54654165"."\","
                        . "\"total_amount\": \""."123.00"."\","
                        . "\"timeout_express\": \"30m\"," 
                        . "\"product_code\":\"QUICK_MSECURITY_PAY\""
                        . "}"; */
        $request->setNotifyUrl($notify_url);
        $request->setBizContent($bizcontent);
        //这里和普通的接口调用不同，使用的是sdkExecute
        $response = $aop->sdkExecute($request);
        //htmlspecialchars是为了输出到页面时防止被浏览器将关键参数html转义，实际打印到日志以及http传输不会有这个问题
        return $response;//就是orderString 可以直接给客户端请求，无需再做处理。
    }
}