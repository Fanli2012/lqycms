<?php
namespace App\Http\Controllers\Api;
use Log;
use DB;
use Illuminate\Http\Request;
use App\Common\ReturnData;
use App\Common\Helper;
use App\Common\Token;
use App\Http\Model\VerifyCode;
use App\Http\Logic\VerifyCodeLogic;

class VerifyCodeController extends CommonController
{
    public function __construct()
    {
        parent::__construct();
    }
	
    public function getLogic()
    {
        return logic('VerifyCode');
    }
    
    public function verifyCodeList(Request $request)
	{
        //参数
        $limit = $request->input('limit', 10);
        $offset = $request->input('offset', 0);
        
        $where['user_id'] = Token::$uid;
        
        $res = $this->getLogic()->getList($where, array('id', 'desc'), '*', $offset, $limit);
		
		return ReturnData::create(ReturnData::SUCCESS,$res);
    }
    
    public function verifyCodeDetail(Request $request)
	{
        //参数
        if(!checkIsNumber($request->input('id',null))){return ReturnData::create(ReturnData::PARAMS_ERROR);}
        $id = $request->input('id');
        $where['id'] = $id;
        
        $res = $this->getLogic()->getOne($where);
		if(!$res)
		{
			return ReturnData::create(ReturnData::RECORD_NOT_EXIST);
		}
        
		return ReturnData::create(ReturnData::SUCCESS,$res);
    }
    
    //添加
    public function verifyCodeAdd(Request $request)
    {
        if(Helper::isPostRequest())
        {
            $_POST['user_id'] = Token::$uid;
            
            return $this->getLogic()->add($_POST);
        }
    }
    
    //修改
    public function verifyCodeUpdate(Request $request)
    {
        if(!checkIsNumber($request->input('id',null))){return ReturnData::create(ReturnData::PARAMS_ERROR);}
        $id = $request->input('id');
        
        if(Helper::isPostRequest())
        {
            unset($_POST['id']);
            $where['id'] = $id;
            $where['user_id'] = Token::$uid;
            
            return $this->getLogic()->edit($_POST,$where);
        }
    }
    
    //删除
    public function verifyCodeDelete(Request $request)
    {
        if(!checkIsNumber($request->input('id',null))){return ReturnData::create(ReturnData::PARAMS_ERROR);}
        $id = $request->input('id');
        
        if(Helper::isPostRequest())
        {
            $where['id'] = $id;
            $where['user_id'] = Token::$uid;
            
            return $this->getLogic()->del($where);
        }
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