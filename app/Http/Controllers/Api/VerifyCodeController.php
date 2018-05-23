<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\CommonController;
use Illuminate\Http\Request;
use App\Common\ReturnData;
use App\Common\Helper;
use App\Common\Token;

use App\Http\Model\VerifyCode;

class VerifyCodeController extends CommonController
{
    public function __construct()
    {
        parent::__construct();
    }
	
    //验证码校验
    public function verifyCodeCheck(Request $request)
    {
        $mobile = $request->input('mobile', null); //手机号码
        $verifyCode = $request->input('verifyCode', null); //手机验证码
		$type = $request->input('type', null); //验证码类型
		
		if ($mobile==null || $verifyCode==null || $type==null)
		{
            return ReturnData::create(ReturnData::PARAMS_ERROR);
        }
		
		if (!Helper::isValidMobile($mobile))
		{
			return ReturnData::create(ReturnData::MOBILE_FORMAT_FAIL);
		}
		
		$verifyCode = VerifyCode::isVerify($mobile, $verifyCode, $type);
		if(!$verifyCode)
		{
			return ReturnData::create(ReturnData::INVALID_VERIFYCODE);
		}
		
		return ReturnData::create(ReturnData::SUCCESS);
    }
}