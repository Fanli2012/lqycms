<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\CommonController;
use Illuminate\Http\Request;
use App\Common\ReturnData;
use App\Common\Token;
use App\Http\Model\CollectGoods;

class CollectGoodsController extends CommonController
{
    public function __construct()
    {
        parent::__construct();
    }
    
    public function collectGoodsList(Request $request)
	{
        //参数
        $data['limit'] = $request->input('limit', 10);
        $data['offset'] = $request->input('offset', 0);
        $data['user_id'] = Token::$uid;
        
        $res = CollectGoods::getList($data);
		if(!$res)
		{
			return ReturnData::create(ReturnData::SYSTEM_FAIL,null,$res);
		}
        
		return ReturnData::create(ReturnData::SUCCESS,$res);
    }
    
    //收藏商品
    public function collectGoodsAdd(Request $request)
	{
        //参数
        $data['goods_id'] = $request->input('goods_id',null);
        if($request->input('is_attention', null) !== null){$data['is_attention'] = $request->input('is_attention');}
        $data['add_time'] = time();
        $data['user_id'] = Token::$uid;
        
        if($data['goods_id']===null)
		{
            return ReturnData::create(ReturnData::PARAMS_ERROR);
        }
        
        $res = CollectGoods::add($data);
		if($res !== true)
		{
			return ReturnData::create(ReturnData::SYSTEM_FAIL,null,$res);
		}
        
		return ReturnData::create(ReturnData::SUCCESS,$res);
    }
    
    //取消收藏商品
    public function collectGoodsDelete(Request $request)
	{
        //参数
        $data['goods_id'] = $request->input('goods_id',null);
        $data['user_id'] = Token::$uid;
        
        if($data['goods_id']===null)
		{
            return ReturnData::create(ReturnData::PARAMS_ERROR);
        }
        
        $res = CollectGoods::remove($data);
		if($res !== true)
		{
			return ReturnData::create(ReturnData::SYSTEM_FAIL,null,$res);
		}
        
		return ReturnData::create(ReturnData::SUCCESS,$res);
    }
}