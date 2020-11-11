<?php

namespace App\Http\Controllers\Weixin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class WxPayController extends BaseController
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * 发微信红包
     * @param string $openid 用户openid
     */
    public function wxhbpay($re_openid, $money, $wishing = '恭喜发财，大吉大利！', $act_name = '赠红包活动', $remark = '赶快领取您的红包！')
    {
        //微信支付-start
        require_once(resource_path('org/wxpay/WxPayConfig.php')); // 导入微信配置类
        require_once(resource_path('org/wxpay/WxPayPubHelper.class.php')); // 导入微信支付类

        $wxconfig = \WxPayConfig::wxconfig();
        $wxHongBaoHelper = new \Sendredpack($wxconfig);
        $wxHongBaoHelper->setParameter("mch_billno", date('YmdHis') . rand(1000, 9999));//订单号
        $wxHongBaoHelper->setParameter("send_name", '红包');//红包发送者名称
        $wxHongBaoHelper->setParameter("re_openid", $re_openid);//接受openid
        $wxHongBaoHelper->setParameter("total_amount", floatval($money * 100));//付款金额，单位分
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


}