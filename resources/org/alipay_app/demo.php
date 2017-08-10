<?php
//PHP服务端SDK生成APP支付订单信息示例
public function AlipayTradeAppPayRequest()
{
    require_once './AopClient.php';
    require_once './AlipayTradeAppPayRequest.php';
    
    $aop = new \AopClient;
    $aop->gatewayUrl = "https://openapi.alipay.com/gateway.do";
    $aop->appId = "2017070707673008";
    $aop->rsaPrivateKey = '1fengMIIEpAIBAAKCAQEA5Eccv1+NjMMEMYC9ePnldw8MgCvIsXq1A4VUTlfzCpLpEAe8Losf4lDqZhcwJOhk6+ZC6dWi1rKE7P+huG0Mh88PpXQAy9zPcbbdFqcuijZFxLNj0qcZGhurS6m0cWofAJxVcuSYpHNwJF24kCPrUje46mpNd3J8hsGXjZQBQpU3BdB4DM0hRA7BopR8WTaiGrNIzJSrAi6hIwDqjMFez3AYD4RhQRt9k7NPY04uKI7UR0D6Me+f6Cu0exodB87L1EXTm/ICG/F8rj+4xUXgqWOWw0QuUHMEYB0S5dSxy2sQg/2A67PogsxIUkOB+UdcsI0W2ZmpO5MKSusPlV6VwwIDAQABAoIBAQCscwBHnkLLtMNlNjFsw7PSln7GEM2DLgSzDTUcHhrPwR3p6z4BFz7V9HSu/RN0vk8HWqLwDWD/ukrq007ziQXvTsAuKI01dLEN4avxoghphwh7yV0+1NcEvyRPe3uCNj4HcxKmQgUCLubnwhlcYpYyPUAnbnjpJIboMjVwUgAFsFBlm5aQ1cCTR2aPg/KkC+VlxWOEBaY6Y2RH59sMon+G2LPIvzYJW8Ive+rccyZ0ly7dqEiaW5+dhcLRUC7z/Z4R9ZZm5zrzwFhI+v4vDN+oaTUSjijVbRkZN4U+PGvNYj+OyYd3rQvGS41EmCiO1L23jI7ve0XnbfXYpnpILVN5AoGBAPRF/4uc2ug3HFfP7jgmxuZHJR6GXZz9S9Au6CFi6SQ3D5bgvIN4RiZ8kIXnf1FAJ+/Gi97QPFpozAbNWgBj42w25FRXCe60HKV7K89ovSyeKcbKQ/PhV4MQnsyUU+bkqVzTK5uCedwYPG9rDGHkS3t0kvtvL+QtaK5FRXjtmmHnAoGBAO88iQsw3cE6Xf4B5byj1C3NaIvW7G8ZqLLKc190aNrMtDym8HPw4H2h0MrQ12fRIU/v06DzKII2SbywaICEpMQnAg2WS+X9oeiFGwVB8L2npHz6TX+TGgC8zjJuzW2wVX5NYATP5nSUbZE5oVEYh44gyE4JkY/iwesupO1PGunFAoGAW81qytd6VcdQeZgFmUjJe4XFZ4Fr8TIoqebXCqUXpaqjyzpO3sH260PpNMnZyXlpCO3/Zw+vfvLfqrbGWlsv/11p1mCXtQQvt+lgf6SHZBtU7AbcHu3Ta8h1RcGA/sd09xPN0bXpglQBcoYysx+PVqhrDN+uifye2M/j2hzB5oUCgYBns13UNAJr19kWWcwz0PAQSpGezDMAlabCmW8ZWWR6M3GNOO/R0f/9dT8EKzK0FbrS46pgggZ1KwMbf3xM+TJStHX3XcbYkvCz0b68sLCiBSEP64/cVO9Ykn7u7Yium1jzvqZ4b4X90rkL0mdSt8dKnHs3GH64WBqmzzk+hKOt4QKBgQCwAPwnlLiZmtORdja3rNFrTTXvjua8HVTemMdp2rUuSFB2FXS3suRhqkH2ilMRvbdiP/GlaCOyOTMSOVis88KZKie5Dy26TUgWUMsvG/7d21meRP6SCqpFhw5tkNkTzX+7ul5Si7iabmMtdlhw1OiD7yv4bo3Sw4YTWMa4s4D2ag=='; //请填写开发者私钥去头去尾去回车，一行字符串
    $aop->format = "json";
    $aop->charset = "UTF-8";
    $aop->signType = "RSA2";
    $aop->alipayrsaPublicKey = '1fengMIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAmLo5catqqLXWcf+LhRs/WDziyCAB+HPb/+xls2BAtNtvfLHCM9xej5VGTzX7mw6e5/Et3yVAhFnnTZ9U9RWq1m3MiEv19n17/yIbGMXpxSSujYnL0drFBY6Z4f19tzfqWQPETpEf1atFSHbcJQfpaslyr9W2NmS5dbWIe+sJVmZjRN5cYEhFY7U0JHqIPr653XSDzsQ152rHZIb0wJmEVfkr0yyOZl1ja0sx+Gv3/BcHDK1brK94mi9I6J78dDXQS6WSQY7mup9l74Z78FLHf22LtS9GvpkzlL5zAKh0LzTVsgGlyJNMnh0/aRYK4p4IKiSAvQRhLXjfbWLc9XFAzQIDAQAB'; //请填写支付宝公钥，一行字符串
    //实例化具体API对应的request类,类名称和接口名称对应,当前调用接口名称：alipay.trade.app.pay
    $request = new \AlipayTradeAppPayRequest();
    //SDK已经封装掉了公共参数，这里只需要传入业务参数
    $bizcontent = "{\"body\":\"我是测试数据\"," 
                    . "\"subject\": \"App支付测试\","
                    . "\"out_trade_no\": \"20170125test01\","
                    . "\"timeout_express\": \"30m\"," 
                    . "\"total_amount\": \"0.01\","
                    . "\"product_code\":\"QUICK_MSECURITY_PAY\""
                    . "}";
    $request->setNotifyUrl("http://59.110.220.223:8087/receive_notify"); //商户外网可以访问的异步地址,回调地址
    $request->setBizContent($bizcontent);
    //这里和普通的接口调用不同，使用的是sdkExecute
    $response = $aop->sdkExecute($request);
    //htmlspecialchars是为了输出到页面时防止被浏览器将关键参数html转义，实际打印到日志以及http传输不会有这个问题
    //echo htmlspecialchars($response);//就是orderString 可以直接给客户端请求，无需再做处理。
    echo $response;
}

//PHP服务端验证异步通知信息参数示例
public function AlipayTradeAppPayNotify()
{
    require_once './AopClient.php';
    
    $aop = new \AopClient;
    $aop->alipayrsaPublicKey = ''; //请填写支付宝公钥，一行字符串
    $flag = $aop->rsaCheckV1($_POST, NULL, "RSA2"); //RSA2与上面一致
}