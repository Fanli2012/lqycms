<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\CommonController;
use Illuminate\Http\Request;
use App\Common\ReturnData;
use App\Common\Token;
use App\Http\Model\Goods;

class GoodsController extends CommonController
{
    public function __construct()
    {
        parent::__construct();
    }
    
    public function goodsList(Request $request)
	{
        //参数
        $data['limit'] = $request->input('limit', 10);
        $data['offset'] = $request->input('offset', 0);
        if($request->input('type', null) !== null){$data['type'] = $request->input('type');}
        $data['user_id'] = Token::$uid;
        
        $res = Goods::getList($data);
		if($res === false)
		{
			return ReturnData::create(ReturnData::SYSTEM_FAIL);
		}
        
		return ReturnData::create(ReturnData::SUCCESS,$res);
    }
    
    //添加余额明细
    public function userMoneyAdd(Request $request)
	{
        //参数
        $data['type'] = $request->input('type',null);
        $data['money'] = $request->input('money',null);
        $data['des'] = $request->input('des',null);
        if($request->input('user_money', null) !== null){$data['user_money'] = $request->input('user_money');}
        $data['add_time'] = time();
        $data['user_id'] = Token::$uid;
        
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