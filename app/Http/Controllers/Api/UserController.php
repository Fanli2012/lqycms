<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\CommonController;
use Illuminate\Http\Request;
use App\Common\ReturnData;

use App\Http\Model\User;

class UserController extends CommonController
{
    public function __construct()
    {
        parent::__construct();
    }
    
    //签到
	public function signin(Request $request)
	{
		$user = MallDataManager::userFirst(['id'=>Token::$uid]);
		if($user){}else{return ReturnCode::create(ReturnCode::PARAMS_ERROR);}
		
		$signin_time='';
		if(!empty($user->signin_time)){$signin_time = date('Ymd',strtotime($user->signin_time));} //签到时间
		
		$today = date('Ymd',time()); //今日日期
		
		if($signin_time==$today){return ReturnCode::create(101,'已经签到啦，请明天再来！');}
		
		$signin_point = (int)DB::table('system')->where(['keyword'=>'signin_point'])->value('value'); //签到积分
		DB::table('user')->where(['id'=>Token::$uid])->update(['point'=>($user->point+$signin_point),'signin_time'=>date('Y-m-d H:i:s')]); //更新用户积分，及签到时间
		DB::table('user_point_log')->insert(['type'=>1,'point'=>$signin_point,'des'=>'签到','user_id'=>Token::$uid]); //添加签到积分记录
		
		return ReturnCode::create(ReturnCode::SUCCESS,'恭喜您今日签到成功！+'.$signin_point.'积分');
    }
    
    //验证码校验
    public function verifyCodeCheck(Request $request)
    {
        $mobile = $request->input('mobile', null); //手机号码
        $verificationCode = $request->input('verificationCode', null); //手机验证码
		$type = $request->input('type', null); //验证码类型
		
		if ($mobile==null || $verificationCode==null || $type==null)
		{
            return ReturnCode::create(ReturnCode::PARAMS_ERROR);
        }
		
		if (!Helper::isValidMobile($mobile))
		{
			return ReturnCode::create(ReturnCode::MOBILE_FORMAT_FAIL);
		}
		
		$verifyCode = VerifyCode::isVerify($mobile, $verificationCode, $type);
		if(!$verifyCode)
		{
			return ReturnCode::create(ReturnCode::INVALID_VERIFY_CODE);
		}
		
		return ReturnCode::create(ReturnCode::SUCCESS);
    }
	
	//积分记录
    public function getCommunityNoticeList(Request $request)
    {
        $where = '';
		$page = $request->input('page',1);
		$size = $request->input('size',10);
		$skip = ($page-1)*$size;
		
		$select = ['id','title','des','litpic','type','created_at as time'];
		$orderBy = ['id','desc'];
		return ReturnCode::create(ReturnCode::SUCCESS,MallDataManager::getCommunityNoticeList($where,$select,$orderBy,$skip,$size));
    }
	
    //用户收货地址列表
    public function userAddressList(Request $request)
	{
        //参数
        $data['limit'] = $request->input('limit', 10);
        $data['offset'] = $request->input('offset', 0);
        
        $res = UserAddress::getList($data);
		if(!$res)
		{
			return ReturnData::create(ReturnData::SYSTEM_FAIL);
		}
        
		return ReturnData::create(ReturnData::SUCCESS,$res);
    }
    
    //用户收货地址详情
    public function userAddressDetail(Request $request)
	{
        //参数
        $id = $request->input('id',null);
        
        $res = UserAddress::getOne($id);
		if(!$res)
		{
			return ReturnData::create(ReturnData::SYSTEM_FAIL);
		}
        
		return ReturnData::create(ReturnData::SUCCESS,$res);
    }
    
    //设为默认地址
    public function userAddressSetDefault(Request $request)
	{
        //参数
        $id = $request->input('id',null);
        
        $res = UserAddress::setDefault($id);
		if(!$res)
		{
			return ReturnData::create(ReturnData::SYSTEM_FAIL);
		}
        
		return ReturnData::create(ReturnData::SUCCESS,$res);
    }
    
    //添加收货地址
    public function userAddressAdd(Request $request)
	{
        //参数
        $data['name'] = $request->input('name',null);
        $data['mobile'] = $request->input('mobile',null);
        $data['country'] = $request->input('country',null);
        $data['province'] = $request->input('province',null);
        $data['city'] = $request->input('city',null);
        $data['district'] = $request->input('district',null);
        $data['address'] = $request->input('address',null);
        if($request->input('telphone',null)!==null){$data['telphone'] = $request->input('telphone');}
        if($request->input('zipcode',null)!==null){$data['zipcode'] = $request->input('zipcode');}
        if($request->input('email',null)!==null){$data['email'] = $request->input('email');}
        if($request->input('best_time',null)!==null){$data['best_time'] = $request->input('best_time');}
        if($request->input('is_default',null)!==null){$data['is_default'] = $request->input('is_default');}
        
        if($data['name']===null || $data['mobile']===null || $data['address']===null || $data['country']===null || $data['province']===null || $data['city']===null || $data['district']===null)
		{
            return ReturnData::create(ReturnData::PARAMS_ERROR);
        }
        
        $res = UserAddress::add($data);
		if(!$res)
		{
			return ReturnData::create(ReturnData::SYSTEM_FAIL);
		}
        
		return ReturnData::create(ReturnData::SUCCESS,$res);
    }
    
    //修改收货地址
    public function userAddressUpdate(Request $request)
	{
        //参数
        $data['id'] = $request->input('id',null);
        $data['name'] = $request->input('name',null);
        $data['mobile'] = $request->input('mobile',null);
        $data['country'] = $request->input('country',null);
        $data['province'] = $request->input('province',null);
        $data['city'] = $request->input('city',null);
        $data['district'] = $request->input('district',null);
        $data['address'] = $request->input('address',null);
        if($request->input('telphone',null)!==null){$data['telphone'] = $request->input('telphone');}
        if($request->input('zipcode',null)!==null){$data['zipcode'] = $request->input('zipcode');}
        if($request->input('email',null)!==null){$data['email'] = $request->input('email');}
        if($request->input('best_time',null)!==null){$data['best_time'] = $request->input('best_time');}
        if($request->input('is_default',null)!==null){$data['is_default'] = $request->input('is_default');}
        
        if($data['id']===null || $data['name']===null || $data['mobile']===null || $data['address']===null || $data['country']===null || $data['province']===null || $data['city']===null || $data['district']===null)
		{
            return ReturnData::create(ReturnData::PARAMS_ERROR);
        }
        
        $res = UserAddress::modify($data);
		if(!$res)
		{
			return ReturnData::create(ReturnData::SYSTEM_FAIL);
		}
        
		return ReturnData::create(ReturnData::SUCCESS,$res);
    }
    
    //删除收货地址
    public function userAddressDelete(Request $request)
	{
        //参数
        $id = $request->input('id',null);
        
        $res = UserAddress::remove($id);
		if(!$res)
		{
			return ReturnData::create(ReturnData::SYSTEM_FAIL);
		}
        
		return ReturnData::create(ReturnData::SUCCESS,$res);
    }
}