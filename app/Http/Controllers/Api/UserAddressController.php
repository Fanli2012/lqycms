<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\CommonController;
use Illuminate\Http\Request;
use App\Common\ReturnData;
use App\Common\Token;

use App\Http\Model\UserAddress;

class UserAddressController extends CommonController
{
    public function __construct()
    {
        parent::__construct();
    }
	
    //用户收货地址列表
    public function userAddressList(Request $request)
	{
        //参数
        $data['limit'] = $request->input('limit', 10);
        $data['offset'] = $request->input('offset', 0);
        $data['user_id'] = Token::$uid;
        
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
        
        $res = UserAddress::getOne(Token::$uid,$id);
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
        
        $res = UserAddress::setDefault($id,Token::$uid);
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
        $data['user_id'] = Token::$uid;
        $data['name'] = $request->input('name',null);
        $data['mobile'] = $request->input('mobile',null);
        $data['province'] = $request->input('province',null);
        $data['city'] = $request->input('city',null);
        $data['district'] = $request->input('district',null);
        $data['address'] = $request->input('address',null);
        if($request->input('country',null)!==null){$data['country'] = $request->input('country');}
        if($request->input('telphone',null)!==null){$data['telphone'] = $request->input('telphone');}
        if($request->input('zipcode',null)!==null){$data['zipcode'] = $request->input('zipcode');}
        if($request->input('is_default',null)!==null){$data['is_default'] = $request->input('is_default');}
        
        if($data['name']===null || $data['mobile']===null || $data['address']===null || $data['province']===null || $data['city']===null || $data['district']===null)
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
        $data['user_id'] = Token::$uid;
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
        $id = $request->input('id','');
        
        if($id == '')
		{
            return ReturnData::create(ReturnData::PARAMS_ERROR);
        }
        
        $res = UserAddress::remove($id,Token::$uid);
		if(!$res)
		{
			return ReturnData::create(ReturnData::SYSTEM_FAIL);
		}
        
		return ReturnData::create(ReturnData::SUCCESS,$res);
    }
}