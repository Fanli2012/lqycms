<?php
namespace App\Http\Model;

use Log;
use App\Common\Sms;
use App\Common\Helper;
use App\Common\ReturnData;

//验证码
class VerifyCode extends BaseModel
{
    protected $table = 'verify_code';
    
    const STATUS_UNUSE = 0;
    const STATUS_USE = 1;                                                       //验证码已被使用
    
    const TYPE_GENERAL = 0;                                                     //通用
    const TYPE_REGISTER = 1;                                                    //用户注册业务验证码
    const TYPE_CHANGE_PASSWORD = 2;                                             //密码修改业务验证码
    const TYPE_MOBILEE_BIND = 3;                                                //手机绑定业务验证码
	const TYPE_VERIFYCODE_LOGIN = 4;                                            //验证码登录
	const TYPE_CHANGE_MOBILE = 5;                                               //修改手机号码
	
    //验证码校验
    public static function isVerify($mobile, $code, $type)
    {
        return VerifyCode::Where('code', $code)->where('mobile', $mobile)->where('type', $type)->where('status', VerifyCode::STATUS_UNUSE)->where('expired_at', '>',  date('Y-m-d H:i:s'))->first();
    }
    
    //生成验证码
    public static function getVerifyCode($mobile,$type,$text='')
    {
        //验证手机号
        if (!Helper::isValidMobile($mobile))
        {
            return ReturnData::create(ReturnData::MOBILE_FORMAT_FAIL);
        }
        
        switch ($type)
        {
            case self::TYPE_GENERAL;//通用
                break;
            case self::TYPE_REGISTER: //用户注册业务验证码
                break;
            case self::TYPE_CHANGE_PASSWORD: //密码修改业务验证码
                break;
            case self::TYPE_MOBILEE_BIND: //手机绑定业务验证码
                break;
            case self::TYPE_VERIFYCODE_LOGIN: //验证码登录
                break;
            case VerifyCode::TYPE_CHANGE_MOBILE: //修改手机号码
                break;
            default:
                return ReturnData::create(ReturnData::INVALID_VERIFYCODE);
        }

        $verifyCode = new VerifyCode;
        $verifyCode->type = $type;
        $verifyCode->mobile = $mobile;
        $verifyCode->code = rand(1000, 9999);
        $verifyCode->status = self::STATUS_UNUSE;
        //10分钟有效
        $verifyCode->expired_at = date('Y-m-d H:i:s',(time()+60*20));
        
        //短信发送验证码
        if (strpos($verifyCode->mobile, '+') !== false)
        {
            $text = "【hoo】Your DC verification Code is: {$verifyCode->code}";
        }
        else
            $text = "【后】您的验证码是{$verifyCode->code}，有效期20分钟。";
        
        Sms::sendByYp($text,$verifyCode->mobile);
		
		$verifyCode->save();
		
        return ReturnData::create(ReturnData::SUCCESS,array('code' => $verifyCode->code));
    }
}