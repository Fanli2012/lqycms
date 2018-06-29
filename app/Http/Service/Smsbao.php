<?php
namespace App\Http\Service;

/**
 * 短信宝
 */
class Smsbao
{
    private $user_name;
    private $password;
	private $smsapi  = "http://api.smsbao.com/";
    private $status_str = array(
        "0" => "短信发送成功",
        "-1" => "参数不全",
        "-2" => "服务器空间不支持,请确认支持curl或者fsocket，联系您的空间商解决或者更换空间！",
        "30" => "密码错误",
        "40" => "账号不存在",
        "41" => "余额不足",
        "42" => "帐户已过期",
        "43" => "IP地址限制",
        "50" => "内容含有敏感词"
    );
    
	public function __construct($user_name, $password)
    {
        $this->user_name = $user_name;
        $this->password = $password;
    }
    
    /**
     * 国内短信
     * 
     * @param string $sms_content 要发送的短信内容
     * @param string $sms_phone 接收的手机号，单发：15205201314，群发：15205201314,15205201315，群发时多个手机号以逗号分隔，一次不要超过99个号码
     * return string
     */
    public function sms($sms_content, $sms_phone)
    {
        $user    = $this->user_name; //短信平台帐号
        $pass    = md5($this->password); //短信平台密码
        $content = $sms_content; //要发送的短信内容
        $phone   = $sms_phone; //要发送短信的手机号码
        $sendurl = $this->smsapi."sms?u=".$user."&p=".$pass."&m=".$phone."&c=".urlencode($content);
        $result  = file_get_contents($sendurl) ;
        
        return $this->status_str[$result];
    }
    
    /**
     * 国际短信
     * 
     * @param string $sms_content 要发送的短信内容
     * @param string $sms_phone 接收的手机号，单发：+60901234567，群发：+60901234567,+60901234567，群发时多个手机号以逗号分隔，一次不要超过99个号码，注：国际号码需包含国际地区前缀号码，格式必须是"+"号开头("+"号需要urlencode处理，如：urlencode("+60901234567")否则会出现格式错误)
     * return string
     */
    public function wsms($sms_content, $sms_phone)
    {
        $user    = $this->user_name; //短信平台帐号
        $pass    = md5($this->password); //短信平台密码
        $content = $sms_content; //要发送的短信内容
        $phone   = $sms_phone; //要发送短信的手机号码
        $sendurl = $this->smsapi."wsms?u=".$user."&p=".$pass."&m=".$phone."&c=".urlencode($content);
        $result  = file_get_contents($sendurl) ;
        
        return $this->status_str[$result];
    }
    
    /**
     * 语音验证码发送
     * 
     * @param string $sms_code 发送的验证码
     * @param string $sms_phone 目标手机号码
     * return string
     */
    public function voice($sms_code, $sms_phone)
    {
        $user    = $this->user_name; //短信平台帐号
        $pass    = md5($this->password); //短信平台密码
        $content = $sms_code; //要发送的短信内容
        $phone   = $sms_phone; //要发送短信的手机号码
        $sendurl = $this->smsapi."voice?u=".$user."&p=".$pass."&m=".$phone."&c=".urlencode($content);
        $result  = file_get_contents($sendurl) ;
        
        return $this->status_str[$result];
    }
}