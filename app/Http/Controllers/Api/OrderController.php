<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\CommonController;
use Illuminate\Http\Request;
use App\Common\ReturnData;
use App\Common\Token;
use App\Http\Model\Order;

class OrderController extends CommonController
{
    public function __construct()
    {
        parent::__construct();
    }
    
    //订单列表
    public function orderList(Request $request)
	{
        //参数
        $data['user_id'] = Token::$uid;
        
        $res = Order::getList($data);
		
		return ReturnData::create(ReturnData::SUCCESS,$res);
    }
    
    //生成订单
    public function orderAdd(Request $request)
	{return ReturnData::create(ReturnData::SUCCESS);
        //参数
        $data['goods_number'] = $request->input('goods_number','');
        $data['goods_id'] = $request->input('goods_id','');
        
        if($request->input('goods_attr', '') != ''){$data['goods_attr'] = $request->input('goods_attr');}
        if($request->input('shop_id', '') != ''){$data['shop_id'] = $request->input('shop_id');}
        $data['add_time'] = time();
        $data['user_id'] = Token::$uid;
        
        if($data['goods_number']=='' || $data['goods_id']=='')
		{
            return ReturnData::create(ReturnData::PARAMS_ERROR);
        }
        
		return Order::cartAdd($data);
    }
    
    //删除订单
    public function cartDelete(Request $request)
	{
        $id = $request->input('id','');
        
        if($id=='')
		{
            return ReturnData::create(ReturnData::PARAMS_ERROR);
        }
        
        $res = Cart::remove($id,Token::$uid);
		if($res === true)
		{
			return ReturnData::create(ReturnData::SUCCESS,$res);
		}
        
		return ReturnData::create(ReturnData::SYSTEM_FAIL);
    }
}