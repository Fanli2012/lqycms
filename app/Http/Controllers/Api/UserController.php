<?php
namespace App\Http\Controllers\Api;
use Log;
use DB;
use Illuminate\Http\Request;
use App\Common\ReturnData;
use App\Common\Helper;
use App\Common\Token;
use App\Http\Model\User;
use App\Http\Logic\UserLogic;

class UserController extends CommonController
{
    public function __construct()
    {
        parent::__construct();
    }
    
    public function getLogic()
    {
        return logic('User');
    }
    
    public function userList(Request $request)
	{
        //参数
        $limit = $request->input('limit', 10);
        $offset = $request->input('offset', 0);
        
        $where = [];
        if($request->input('parent_id', '')!=''){$where['parent_id'] = $request->input('parent_id');}
        if($request->input('group_id', '')!=''){$where['group_id'] = $request->input('group_id');}
        if($request->input('sex', '')!=''){$where['sex'] = $request->input('sex');}
        
        $res = $this->getLogic()->getList($where, array('id', 'desc'), '*', $offset, $limit);
		
        /* if($res['count']>0)
        {
            foreach($res['list'] as $k=>$v)
            {
                
            }
        } */
        
		return ReturnData::create(ReturnData::SUCCESS,$res);
    }
    
    public function userDetail(Request $request)
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
    public function userAdd(Request $request)
    {
        if(Helper::isPostRequest())
        {
            return $this->getLogic()->add($_POST);
        }
    }
    
    //修改
    public function userUpdate(Request $request)
    {
        if(Helper::isPostRequest())
        {
            $where['id'] = Token::$uid;
            
            //判断用户名是否已经存在
            if($request->input('user_name', null)!==null)
            {
                if(model('User')->getOne([['user_name', '=', $request->input('user_name')],['id', '<>', Token::$uid]]))
                {
                    return ReturnData::create(ReturnData::PARAMS_ERROR,null,'用户名已存在');
                }
            }
            $data = [];
            if($request->input('email', null)!==null){$data['email'] = $request->input('email');}
            if($request->input('sex', null)!==null){$data['sex'] = $request->input('sex');}
            if($request->input('birthday', null)!==null){$data['birthday'] = $request->input('birthday');}
            if($request->input('address_id', null)!==null){$data['address_id'] = $request->input('address_id');}
            if($request->input('nickname', null)!==null){$data['nickname'] = $request->input('nickname');}
            if($request->input('mobile', null)!==null){$data['mobile'] = $request->input('mobile');}
            if($request->input('group_id', null)!==null){$data['group_id'] = $request->input('group_id');}
            if($request->input('password', null)!==null){$data['password'] = $request->input('password');}
            if($request->input('head_img', null)!==null){$data['head_img'] = $request->input('head_img');}
            if($request->input('refund_account', null)!==null){$data['refund_account'] = $request->input('refund_account');}
            if($request->input('refund_name', null)!==null){$data['refund_name'] = $request->input('refund_name');}
            
            return $this->getLogic()->edit($data,$where);
        }
    }
    
    //删除
    public function userDelete(Request $request)
    {
        if(!checkIsNumber($request->input('id',null))){return ReturnData::create(ReturnData::PARAMS_ERROR);}
        $id = $request->input('id');
        
        if(Helper::isPostRequest())
        {
            $where['id'] = $id;
            //$where['user_id'] = Token::$uid;
            
            return $this->getLogic()->del($where);
        }
    }
    
    //用户信息
    public function userInfo(Request $request)
    {
        $where['id'] = Token::$uid;
        
        $res = $this->getLogic()->getOne($where);
		if(!$res)
		{
			return ReturnData::create(ReturnData::RECORD_NOT_EXIST);
		}
        
        if($res->pay_password){$res->pay_password = 1;}else{$res->pay_password = 0;}
        unset($res->password);
        
		return ReturnData::create(ReturnData::SUCCESS,$res);
    }
    
    //修改用户密码、支付密码
    public function userPasswordUpdate(Request $request)
    {
        if($request->input('password', '')!='' && $request->input('old_password', '')!='')
        {
            $data['password'] = $request->input('password');
            $data['old_password'] = $request->input('old_password');
            
            if($data['password'] == $data['old_password']){return ReturnData::create(ReturnData::PARAMS_ERROR,null,'新旧密码相同');}
        }
        
        if($request->input('pay_password', '')!='')
        {
            $data['pay_password'] = $request->input('pay_password');
            $data['old_pay_password'] = $request->input('old_pay_password','');
            
            if($data['pay_password'] == $data['old_pay_password']){return ReturnData::create(ReturnData::PARAMS_ERROR,null,'新旧支付密码相同');}
        }
        
        if(!isset($data)){return ReturnData::create(ReturnData::PARAMS_ERROR);}
        
        return $this->getLogic()->userPasswordUpdate($data, array('id'=>Token::$uid));
    }
    
    //签到
	public function signin(Request $request)
	{
		return $this->getLogic()->signin(array('id'=>Token::$uid,'status'=>User::USER_NORMAL_STATUS));
    }
    
	//登录
    public function wxLogin(Request $request)
    {
        $data['user_name'] = $request->input('user_name','');
        $data['password'] = $request->input('password','');
        $data['openid'] = $request->input('openid','');
        
        if (($data['user_name']=='' || $data['password']=='') && $data['openid']=='')
		{
            return ReturnData::create(ReturnData::PARAMS_ERROR);
        }
        
        return $this->getLogic()->wxLogin($data);
    }
    
    //注册
    public function wxRegister(Request $request)
	{
        $data['mobile'] = $request->input('mobile','');
        $data['user_name'] = $request->input('user_name','');
        $data['password'] = $request->input('password','');
        $data['parent_id'] = 0;if($request->input('parent_id',null)!=null){$data['parent_id'] = $request->input('parent_id');}
        $parent_mobile = $request->input('parent_mobile','');
        
        if (($data['mobile']=='' && $data['user_name']=='') || $data['password']=='')
		{
            return ReturnData::create(ReturnData::PARAMS_ERROR);
        }
        
        if ($parent_mobile!='')
		{
            if($user = model('User')->getOne(array('mobile'=>$parent_mobile)))
            {
                $data['parent_id'] = $user->id;
            }
            else
            {
                return ReturnData::create(ReturnData::PARAMS_ERROR,null,'推荐人不存在或推荐人手机号错误');
            }
        }
        
        if ($data['mobile']!='')
		{
            //判断手机格式
            if(!Helper::isValidMobile($data['mobile'])){return ReturnData::create(ReturnData::MOBILE_FORMAT_FAIL);}
            
            //判断是否已经注册
            if (model('User')->getOne(array('mobile'=>$data['mobile'])))
            {
                return ReturnData::create(ReturnData::MOBILE_EXIST);
            }
        }
		
        if ($data['user_name']!='')
		{
            if (model('User')->getOne(array('user_name'=>$data['user_name'])))
            {
                return ReturnData::create(ReturnData::PARAMS_ERROR,null,'用户名已存在');
            }
        }
        
        return $this->getLogic()->wxRegister($data);
    }
	
    //微信授权注册
    public function wxOauthRegister(Request $request)
	{
        $data['openid'] = $request->input('openid','');
        $data['unionid'] = $request->input('unionid','');
        $data['sex'] = $request->input('sex','');
        $data['head_img'] = $request->input('head_img','');
        $data['nickname'] = $request->input('nickname','');
        $data['parent_id'] = 0;if($request->input('parent_id',null)!=null){$data['parent_id'] = $request->input('parent_id');}
        $data['user_name'] = date('YmdHis').dechex(rand(1000,9999));
        $data['password'] = md5('123456');
        
        if ($data['openid']=='')
		{
            return ReturnData::create(ReturnData::PARAMS_ERROR);
        }
        
		if (model('User')->getOne(array('openid'=>$data['openid'])))
		{
            return $this->getLogic()->wxLogin(array('openid'=>$data['openid']));
		}
        
        //添加用户
        $res = $this->getLogic()->wxRegister($data);
        if($res['code'] != ReturnData::SUCCESS){return $res;}
        
        //更新用户名user_name，微信登录没有用户名
        model('User')->edit(array('user_name'=>'u'.$res['code']['data']['uid']),array('id'=>$res['code']['data']['uid']));
        
        return $this->getLogic()->wxLogin(array('openid'=>$data['openid']));
    }
    
    //验证码登录
	public function verificationCodeLogin(Request $request)
    {
        $mobile = $request->input('mobile');
		$code = $request->input('code', null);
        $type = $request->input('type', null); //7表示验证码登录
		
        if (!$mobile || !$code)
		{
            return response(ReturnCode::create(ReturnCode::PARAMS_ERROR));
        }
		
		//判断验证码
        if ($type != VerifyCode::TYPE_LOGIN)
		{
            return response(ReturnCode::create(ReturnCode::INVALID_VERIFY_CODE));
        }
		
        $verifyCode = VerifyCode::isVerify($mobile, $code, $type);
        if (!$verifyCode)
		{
            return response(ReturnCode::create(ReturnCode::INVALID_VERIFY_CODE));
        }
        
        if ($user = MallDataManager::userFirst(['mobile'=>$mobile]))
		{
			//获取token
			$expired_at = Carbon::now()->addDay()->toDateTimeString();
			$token = Token::generate(Token::TYPE_SHOP, $user->id);
			
			$response = ReturnCode::success();
			$response['data']=[
				'id' => $user->id, 'name' => $user->name, 'nickname' => $user->nickname, 'headimg' => (string)$user->head_img, 'token' => $token, 'expired_at' => $expired_at, 'mobile' => $user->mobile, 'hx_name' => 'cuobian'.$user->id, 'hx_pwd' => md5('cuobian'.$user->id)
			];
			
			return response($response);
        }
		else
		{
            return response(ReturnCode::create(ReturnCode::USER_NOT_EXIST));
        }
    }
    
    //修改密码
    public function changePassword(Request $request)
    {
        $mobile = $request->input('mobile', null);
        $password = $request->input('password', null); //新密码
		$oldPassword = $request->input('oldPassword', null); //旧密码
		
		if (!$mobile || !$password || !$oldPassword)
		{
            return ReturnCode::create(ReturnCode::PARAMS_ERROR);
        }
		
		if($password == $oldPassword)
		{
			return ReturnCode::create(ReturnCode::PARAMS_ERROR,'新旧密码相同');
		}
		
		if (!Helper::isValidMobile($mobile))
		{
			return ReturnCode::create(ReturnCode::MOBILE_FORMAT_FAIL);
		}
		
		$user = MallDataManager::userFirst(['mobile'=>$mobile,'password'=>$oldPassword,'id'=>Token::$uid]);
		
		if(!$user)
		{
			return ReturnCode::create(ReturnCode::PARAMS_ERROR,'手机或密码错误');
		}
		
		DB::table('user')->where(['mobile'=>$mobile,'password'=>$oldPassword,'id'=>Token::$uid])->update(['password'=>$password]);
		
		MallDataManager::tokenDelete(['uid'=>Token::$uid]);
		
		return ReturnCode::create(ReturnCode::SUCCESS);
    }
	
	//找回密码，不用输入旧密码
    public function findPassword(Request $request)
    {
        $mobile = $request->input('mobile', null);
        $password = $request->input('password', null);
		
        if ($mobile && $password)
		{
            if (!Helper::isValidMobile($mobile))
			{
                return response(ReturnCode::create(ReturnCode::MOBILE_FORMAT_FAIL));
            }
			
            //判断验证码是否有效
            $code = $request->input('code', '');
            $type = $request->input('type', null);
            if($type != VerifyCode::TYPE_CHANGE_PASSWORD)
                return response(ReturnCode::create(ReturnCode::INVALID_VERIFY_CODE,'验证码类型错误'));
            $verifyCode = VerifyCode::isVerify($mobile, $code, $type);
			
            if($verifyCode)
            {
                try
				{
                    DB::beginTransaction();
                    $verifyCode->status = VerifyCode::STATUS_USE;
                    $verifyCode->save();
					
                    if ($user = MallDataManager::userFirst(['mobile'=>$mobile]))
					{
                        DB::table('user')->where(['mobile'=>$mobile])->update(['password'=>$password]);
                        
						MallDataManager::tokenDelete(['uid'=>$user->id]);
						
						$response = response(ReturnCode::create(ReturnCode::SUCCESS));
                    }
					else
					{
                        $response = response(ReturnCode::create(ReturnCode::PARAMS_ERROR));
                    }
					
					DB::commit();
					
                    return $response;
                }
				catch (Exception $e)
				{
                    DB::rollBack();
                    return response(ReturnCode::error($e->getCode(), $e->getMessage()));
                }
            }
            else
            {
                return response(ReturnCode::create(ReturnCode::INVALID_VERIFY_CODE));
            }
        }
		else
		{
            return response(ReturnCode::create(ReturnCode::PARAMS_ERROR));
        }
    }
	
	//修改手机号
    public function changeMobile(Request $request)
    {
        $mobile = $request->input('mobile', null); //新手机号码
        $verificationCode = $request->input('verificationCode', null); //新手机验证码
		$oldMobile = $request->input('oldMobile', null); //旧手机号码
		$oldVerificationCode = $request->input('oldVerificationCode', null); //旧手机验证码
		$type = $request->input('type', null); //验证码类型
		
		if (!$mobile || !$verificationCode || !$oldMobile || !$oldVerificationCode || !$type)
		{
            return ReturnCode::create(ReturnCode::PARAMS_ERROR);
        }
		
		if (!Helper::isValidMobile($mobile))
		{
			return ReturnCode::create(ReturnCode::MOBILE_FORMAT_FAIL);
		}
		
		if($mobile == $oldMobile)
		{
			return ReturnCode::create(ReturnCode::PARAMS_ERROR,'新旧手机号码相同');
		}
		
		if($type != VerifyCode::TYPE_CHANGE_MOBILE)
		{
			return ReturnCode::create(ReturnCode::INVALID_VERIFY_CODE,'验证码类型错误');
        }
		
		$verifyCode = VerifyCode::isVerify($oldMobile, $oldVerificationCode, $type);
		if(!$verifyCode)
		{
			return ReturnCode::create(ReturnCode::INVALID_VERIFY_CODE);
		}
		
		$verifyCode = null;
		$verifyCode = VerifyCode::isVerify($mobile, $verificationCode, $type);
		if(!$verifyCode)
		{
			return ReturnCode::create(ReturnCode::INVALID_VERIFY_CODE);
		}
		
		$user = MallDataManager::userFirst(['mobile'=>$oldMobile,'id'=>Token::$uid]);
		
		if(!$user)
		{
			return ReturnCode::create(ReturnCode::PARAMS_ERROR,'旧手机号码错误');
		}
		
		DB::table('user')->where(['mobile'=>$oldMobile,'id'=>Token::$uid])->update(['mobile'=>$mobile]);
		
		MallDataManager::tokenDelete(['uid'=>Token::$uid]);
		
		return ReturnCode::create(ReturnCode::SUCCESS);
    }
}