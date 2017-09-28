<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\CommonController;
use Illuminate\Http\Request;
use App\Common\ReturnData;
use App\Common\Token;

use App\Http\Model\UserGoodsHistory;

class UserGoodsHistoryController extends CommonController
{
    public function __construct()
    {
        parent::__construct();
    }
	
    //我的足迹列表
    public function userGoodsHistoryList(Request $request)
	{
        //参数
        $data['limit'] = $request->input('limit', 10);
        $data['offset'] = $request->input('offset', 0);
        
        $data['user_id'] = Token::$uid;
        
        $res = UserGoodsHistory::getList($data);
		if($res === false)
		{
			return ReturnData::create(ReturnData::SYSTEM_FAIL);
		}
        
		return ReturnData::create(ReturnData::SUCCESS,$res);
    }
    
    //我的足迹添加
    public function userGoodsHistoryAdd(Request $request)
	{
        //参数
        $data['goods_id'] = $request->input('goods_id',null);
        $data['user_id'] = Token::$uid;
        
        if($data['goods_id']===null || $data['user_id']===null)
		{
            return ReturnData::create(ReturnData::PARAMS_ERROR);
        }
        
        $res = UserGoodsHistory::add($data);
		if($res === false)
		{
			return ReturnData::create(ReturnData::SYSTEM_FAIL);
		}
        
		return ReturnData::create(ReturnData::SUCCESS,$res);
    }
    
    //删除一条我的足迹
    public function userGoodsHistoryDelete(Request $request)
	{
        //参数
        $id = $request->input('id',null);
        
        $res = UserGoodsHistory::remove($id,Token::$uid);
		if($res === false)
		{
			return ReturnData::create(ReturnData::SYSTEM_FAIL);
		}
        
		return ReturnData::create(ReturnData::SUCCESS,$res);
    }
    
    //清空我的足迹
    public function userGoodsHistoryClear(Request $request)
	{
        //参数
        $user_id = Token::$uid;
        
        $res = UserGoodsHistory::remove($user_id);
		if($res === false)
		{
			return ReturnData::create(ReturnData::SYSTEM_FAIL);
		}
        
		return ReturnData::create(ReturnData::SUCCESS,$res);
    }
}