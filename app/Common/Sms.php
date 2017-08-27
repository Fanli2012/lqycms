<?php
namespace App\Common;

use App\Http\Model\SmsLog;

class Sms
{
    /**
     * 云片接口发送-支持国际短信
     *
     * @param $text 发送的内容
     * @param $mobile 要发送到哪个手机号上
     * @return bool
     */
    public static function sendByYp($text, $mobile)
    {
        // 必要参数
        $apikey = 'f9c119a3e8a0dc4faee84fdd82cbc60d'; //示例：9b11127a9701975c734b8aee81ee3526，修改为您的apikey(https://www.yunpian.com)登录官网后获取
        $mobile = $mobile; //手机号
        $text   = $text;
        // 发送短信
        $ch = curl_init();
        $data = array('text'=>$text,'apikey'=>$apikey,'mobile'=>$mobile);
        curl_setopt($ch, CURLOPT_URL, 'https://sms.yunpian.com/v2/sms/single_send.json');
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,true);
        $result = json_decode(curl_exec($ch),true);
        
        if ($result && $result['code'] != 0)
        {
            Log::info('短信发送失败：号码：' . $mobile . '； 短信内容：' . $text . '； 错误代码：' . $result['code'] . ';  错误详情：' . $result['msg']);
            SmsLog::fail($mobile, $text, $result);
            
            return false;
        }
        
        SmsLog::success($mobile, $text, $result);
        return true;
    }
    
    /**
     * 阿里大于
     *
     * @param $text 发送的内容
     * @param $mobile 要发送到哪个手机号上
     * @return bool
     */
    public static function SendDySms($text, $mobile)
    {
        $c = new TopClient;
        $c->appkey = $appkey;
        $c->secretKey = $secret;
        $req = new AlibabaAliqinFcSmsNumSendRequest;
        $req->setExtend("123456");
        $req->setSmsType("normal");
        $req->setSmsFreeSignName("阿里大于");
        $req->setSmsParam("{\"code\":\"1234\",\"product\":\"alidayu\"}");
        $req->setRecNum("13000000000");
        $req->setSmsTemplateCode("SMS_585014");
        $resp = $c->execute($req);
    }
}