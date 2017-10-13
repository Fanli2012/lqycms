<?php
//微信支付设置
public function wxconf()
{
    //=======【基本信息设置】=====================================
    //微信公众号身份的唯一标识。审核通过后，在微信发送的邮件中查看
    $wxconfig['APPID']  = 'wx1c7946b5734199d0';
    //受理商ID，身份标识
    $wxconfig['MCHID']  = '1331184301';
    //商户支付密钥Key。审核通过后，在微信发送的邮件中查看
    $wxconfig['KEY']  = '93aa64d6552bf09401af7e7e6f9b3be7';
    //JSAPI接口中获取openid，审核后在公众平台开启开发模式后可查看
    $wxconfig['APPSECRET']  = '93aa64d6552bf09401af7e7e6f9b3be7';

    //=======【JSAPI路径设置】===================================
    //获取access_token过程中的跳转uri，通过跳转将code传入jsapi支付页面
    $wxconfig['JS_API_CALL_URL']  = 'http://'.$_SERVER['HTTP_HOST'].U('Wxpay/index');

    //=======【证书路径设置】=====================================
    //证书路径,注意应该填写绝对路径
    $wxconfig['SSLCERT_PATH']  = './cert/apiclient_cert.pem';
    $wxconfig['SSLKEY_PATH']  = './cert/apiclient_key.pem';

    //=======【异步通知url设置】===================================
    //异步通知url，商户根据实际开发过程设定
    $wxconfig['NOTIFY_URL']  = 'http://'.$_SERVER['HTTP_HOST'].U('Wxpay/notify_url');

    //=======【curl超时设置】===================================
    //本例程通过curl使用HTTP POST方法，此处可修改其超时时间，默认为30秒
    $wxconfig['CURL_TIMEOUT'] = 30;

    return $wxconfig;
}

//PHP服务端SDK生成APP支付订单信息示例
public function wxt()
{
    $body = '商品购买';//订单详情
    $out_trade_no = '2017787878';//订单号
    $total_fee = floatval(0.01*100);//价格3880.00
    $wxconfig=$this->wxconf();
    //=========步骤1：网页授权获取用户openid============
    //使用jsapi接口
    require_once './WxPayPubHelper.class.php';
    //import("@.ORG.Wxpay.WxPayPubHelper");
    //Vendor('Wxpay.WxPayPubHelper');// 导入微信类
    $jsApi = new JsApi_pub($wxconfig);
    //通过code获得openid
    if (!isset($_GET['code']))
    {
        //触发微信返回code码
        //$url = $jsApi->createOauthUrlForCode($this->wxconfig['JS_API_CALL_URL']);
        $reurl='http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
        $url = $jsApi->createOauthUrlForCode(urlencode($reurl));
        Header("Location: $url"); exit;
    }
    else
    {
        //获取code码，以获取openid
        $code = $_GET['code'];
        $jsApi->setCode($code);
        $openid = $jsApi->getOpenId();
    }
    //=========步骤2：使用统一支付接口，获取prepay_id============
    //使用统一支付接口
    $unifiedOrder = new UnifiedOrder_pub($wxconfig);

    $notify_url = $wxconfig['NOTIFY_URL'];//通知地址
    //设置统一支付接口参数
    //设置必填参数
    //appid已填,商户无需重复填写
    //mch_id已填,商户无需重复填写
    //noncestr已填,商户无需重复填写
    //spbill_create_ip已填,商户无需重复填写
    //sign已填,商户无需重复填写
    $unifiedOrder->setParameter("openid","$openid");//微信用户
    $unifiedOrder->setParameter("body","$body");//商品描述
    $unifiedOrder->setParameter("out_trade_no","$out_trade_no");//商户订单号
    $unifiedOrder->setParameter("total_fee","$total_fee");//总金额
    $unifiedOrder->setParameter("notify_url","$notify_url");//通知地址
    $unifiedOrder->setParameter("trade_type","JSAPI");//交易类型
    //$unifiedOrder->setParameter("attach","test"); //附加数据，选填，在查询API和支付通知中原样返回，可作为自定义参数使用

    $prepay_id = $unifiedOrder->getPrepayId();
    //=========步骤3：使用jsapi调起支付============
    $jsApi->setPrepayId($prepay_id);
    $jsApiParameters = $jsApi->getParameters();
    $this->assign('jsApiParameters',$jsApiParameters);

    $returnUrl='http://'.$_SERVER['HTTP_HOST'].U('User/index');
    $this->assign('returnUrl',$returnUrl);
    $this->display();
}

//PHP服务端验证异步通知信息参数示例
public function AlipayTradeAppPayNotify()
{
    $xml = $GLOBALS['HTTP_RAW_POST_DATA'];
    $post_data = json_decode(json_encode(simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA)), true);
    $array_data['out_trade_no'] = substr($post_data['out_trade_no'],0,-5);
    $array_data['total_fee'] = $post_data['total_fee'];
    $array_data['trade_state'] = $post_data['result_code'];
    $array_data['transaction_id'] = $post_data['transaction_id'];
    $get_arr = explode('&',$post_data['attach']);
    foreach($get_arr as $value){
        $tmp_arr = explode('=',$value);
        $array_data[$tmp_arr[0]] = $tmp_arr[1];
    }
    $wxorder=serialize($array_data);//保存post数据
    $out_trade_no = $array_data['out_trade_no'];
    
    if($array_data['trade_state']=='SUCCESS' )
    {
        echo "SUCCESS";
    }
    else
    {
        echo "FAILE";
	}
}

/**
 * 微信红包
 * @param string $openid 用户openid
 */
public function wxhbpay($re_openid,$money,$wishing='恭喜发财，大吉大利！',$act_name='赠红包活动',$remark='赶快领取您的红包！')
{
    import("@.ORG.Wxpay.WxPayPubHelper");
    $wxHongBaoHelper = new Sendredpack($this->wxconfig);
    $wxHongBaoHelper->setParameter("mch_billno", date('YmdHis').rand(1000, 9999));//订单号
    $wxHongBaoHelper->setParameter("send_name", '红包');//红包发送者名称
    $wxHongBaoHelper->setParameter("re_openid", $re_openid);//接受openid
    $wxHongBaoHelper->setParameter("total_amount", floatval($money*100));//付款金额，单位分
    $wxHongBaoHelper->setParameter("total_num", 1);//红包収放总人数
    $wxHongBaoHelper->setParameter("wishing", $wishing);//红包祝福
    $wxHongBaoHelper->setParameter("client_ip", '127.0.0.1');//调用接口的机器 Ip 地址
    $wxHongBaoHelper->setParameter("act_name", $act_name);//活劢名称
    $wxHongBaoHelper->setParameter("remark", $remark);//备注信息
    $responseXml = $wxHongBaoHelper->postXmlSSL();
    //用作结果调试输出
    //echo htmlentities($responseXml,ENT_COMPAT,'UTF-8');
    $responseObj = simplexml_load_string($responseXml, 'SimpleXMLElement', LIBXML_NOCDATA);
    return $responseObj->result_code;
}
