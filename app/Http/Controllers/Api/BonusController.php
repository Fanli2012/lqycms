<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\CommonController;
use Illuminate\Http\Request;
use App\Common\ReturnData;
use App\Common\Token;
use App\Http\Model\Bonus;
use App\Http\Model\UserBonus;

class BonusController extends CommonController
{
    public function __construct()
    {
        parent::__construct();
    }
    
    //可用获取的优惠券列表
    public function bonusList(Request $request)
	{
        //参数
        $data['limit'] = $request->input('limit', 10);
        $data['offset'] = $request->input('offset', 0);
        $data['user_id'] = Token::$uid;
        
        $res = Bonus::getList($data);
		if(!$res)
		{
			return ReturnData::create(ReturnData::SYSTEM_FAIL,null,$res);
		}
        
		return ReturnData::create(ReturnData::SUCCESS,$res);
    }
    
    //添加优惠券
    public function bonusAdd(Request $request)
	{
        //参数
        $data['name'] = $request->input('name',null);
        $data['money'] = $request->input('money',null);
        $data['min_amount'] = $request->input('min_amount',null);
        $data['start_time'] = $request->input('start_time',null);
        $data['end_time'] = $request->input('end_time',null);
        if($request->input('point', null) !== null){$data['point'] = $request->input('point');}
        if($request->input('status', null) !== null){$data['status'] = $request->input('status');}
        $data['add_time'] = time();
        
        if($data['name']===null || $data['money']===null || $data['min_amount']===null || $data['start_time']===null || $data['end_time']===null)
		{
            return ReturnData::create(ReturnData::PARAMS_ERROR);
        }
        
        if($data['start_time'] >= $data['end_time'])
		{
            return ReturnData::create(ReturnData::PARAMS_ERROR,null,'有效期错误');
        }
        
        //正则验证时间格式，未作
        
        $res = Bonus::add($data);
		if($res !== true)
		{
			return ReturnData::create(ReturnData::SYSTEM_FAIL,null,$res);
		}
        
		return ReturnData::create(ReturnData::SUCCESS,$res);
    }
    
    //修改优惠券
    public function bonusUpdate(Request $request)
	{
        //参数
        $id = $request->input('id',null);
        $data['name'] = $request->input('name',null);
        $data['money'] = $request->input('money',null);
        $data['min_amount'] = $request->input('min_amount',null);
        $data['start_time'] = $request->input('start_time',null);
        $data['end_time'] = $request->input('end_time',null);
        if($request->input('point', null) !== null){$data['point'] = $request->input('point');}
        if($request->input('status', null) !== null){$data['status'] = $request->input('status');}
        
        if($id===null || $data['name']===null || $data['money']===null || $data['min_amount']===null || $data['start_time']===null || $data['end_time']===null)
		{
            return ReturnData::create(ReturnData::PARAMS_ERROR);
        }
        
        if($data['start_time'] >= $data['end_time'])
		{
            return ReturnData::create(ReturnData::PARAMS_ERROR,null,'有效期错误');
        }
        
        //正则验证时间格式，未作
        
        $res = Bonus::modify(array('id'=>$id),$data);
		if($res !== true)
		{
			return ReturnData::create(ReturnData::SYSTEM_FAIL,null,$res);
		}
        
		return ReturnData::create(ReturnData::SUCCESS,$res);
    }
    
    //删除优惠券
    public function bonusDelete(Request $request)
	{
        //参数
        $id = $request->input('id',null);
        if($id===null)
		{
            return ReturnData::create(ReturnData::PARAMS_ERROR);
        }
        
        $res = Bonus::remove($id);
		if($res !== true)
		{
			return ReturnData::create(ReturnData::SYSTEM_FAIL,null,$res);
		}
        
		return ReturnData::create(ReturnData::SUCCESS,$res);
    }
}