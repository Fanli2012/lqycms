<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\CommonController;
use Illuminate\Http\Request;
use App\Common\ReturnData;
use App\Common\Token;
use App\Http\Model\UserBonus;

class UserBonusController extends CommonController
{
    public function __construct()
    {
        parent::__construct();
    }
    
    public function userBonusList(Request $request)
	{
        //参数
        $data['limit'] = $request->input('limit', 10);
        $data['offset'] = $request->input('offset', 0);
        if($request->input('status', '') != ''){$data['status'] = $request->input('status');}
        $data['user_id'] = Token::$uid;
        
        $res = UserBonus::getList($data);
		if($res == false)
		{
			return ReturnData::create(ReturnData::SYSTEM_FAIL);
		}
        
		return ReturnData::create(ReturnData::SUCCESS,$res);
    }
    
    //用户获取优惠券
    public function userBonusAdd(Request $request)
	{
        //参数
        $data['bonus_id'] = $request->input('bonus_id','');
        $data['get_time'] = time();
        $data['user_id'] = Token::$uid;
        
        if($data['bonus_id']=='')
		{
            return ReturnData::create(ReturnData::PARAMS_ERROR);
        }
        
        $res = UserBonus::add($data);
		if($res == false)
		{
			return ReturnData::create(ReturnData::SYSTEM_FAIL);
		}
        
		return ReturnData::create(ReturnData::SUCCESS,$res);
    }
    
    //用户删除优惠券
    public function userBonusDelete(Request $request)
	{
        $id = $request->input('id','');
        if($id=='')
		{
            return ReturnData::create(ReturnData::PARAMS_ERROR);
        }
        
        $res = UserBonus::remove($id);
		if($res == false)
		{
			return ReturnData::create(ReturnData::SYSTEM_FAIL,null,$res);
		}
        
		return ReturnData::create(ReturnData::SUCCESS,$res);
    }
}