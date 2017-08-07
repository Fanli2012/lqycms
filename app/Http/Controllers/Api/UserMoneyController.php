<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\CommonController;
use Illuminate\Http\Request;
use App\Common\ReturnData;

use App\Http\Model\UserMoney;

class UserMoneyController extends CommonController
{
    public function __construct()
    {
        parent::__construct();
    }
    
    public function userMoneyList(Request $request)
	{
        //参数
        $data['limit'] = $request->input('limit', 10);
        $data['offset'] = $request->input('offset', 0);
        if($request->input('type', null) !== null){$data['type'] = $request->input('type');};
        
        $res = UserMoney::getList($data);
		if(!$res)
		{
			return ReturnData::create(ReturnData::SYSTEM_FAIL);
		}
        
		return ReturnData::create(ReturnData::SUCCESS,$res);
    }
    
    //添加余额明细
    public function userMoneyAdd(Request $request)
	{
        //参数
        $data['user_id'] = Token::$uid;
        $data['type'] = $request->input('type',null);
        $data['money'] = $request->input('money',null);
        $data['add_time'] = time();
        $data['des'] = $request->input('des',null);
        
        if($data['type']===null || $data['money']===null || $data['des']===null)
		{
            return ReturnData::create(ReturnData::PARAMS_ERROR);
        }
        
        $res = UserMoney::add($data);
		if(!$res)
		{
			return ReturnData::create(ReturnData::SYSTEM_FAIL);
		}
        
		return ReturnData::create(ReturnData::SUCCESS,$res);
    }
}