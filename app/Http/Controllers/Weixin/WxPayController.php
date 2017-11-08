<?php
namespace App\Http\Controllers\Weixin;

use App\Http\Controllers\Weixin\CommonController;
use Illuminate\Http\Request;

class WxPayController extends CommonController
{
    public function __construct()
    {
        parent::__construct();
    }
	
    //微信支付回调
    public function wxpayNotify(Request $request)
	{
        file_put_contents("1.txt",$GLOBALS['HTTP_RAW_POST_DATA']);
        //获取通知的数据
		$xml = $GLOBALS['HTTP_RAW_POST_DATA'];
        //将XML转为array
        //禁止引用外部xml实体
        libxml_disable_entity_loader(true);
		$post_data = json_decode(json_encode(simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA)), true);
		$get_arr = explode('&',$post_data['attach']);
		foreach($get_arr as $value)
        {
			$tmp_arr = explode('=',$value);
			$post_data[$tmp_arr[0]] = $tmp_arr[1];
		}
        
        if($post_data['result_code'] == 'SUCCESS')
        {
            //$post_data['out_trade_no']
            //$post_data['transaction_id']
            //$post_data['total_fee']
            file_put_contents("2.txt",$post_data['total_fee'].'--'.$post_data['out_trade_no'].'--'.$post_data['attach']);
            echo "SUCCESS";
		}
        else
        {
			echo "FAILE";
		}
	}
    
    /**
     * 发微信红包
     * @param string $openid 用户openid
     */
    public function wxhbpay($re_openid,$money,$wishing='恭喜发财，大吉大利！',$act_name='赠红包活动',$remark='赶快领取您的红包！')
    {
		//微信支付-start
        require_once(resource_path('org/wxpay/WxPayConfig.php')); // 导入微信配置类
        require_once(resource_path('org/wxpay/WxPayPubHelper.class.php')); // 导入微信支付类
        
        $wxconfig= \WxPayConfig::wxconfig();
        $wxHongBaoHelper = new \Sendredpack($wxconfig);
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
    
    
}