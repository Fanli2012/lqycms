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
    
    //订单详情
    public function orderDetail(Request $request)
	{
        //参数
        $data['user_id'] = Token::$uid;
        
        $res = Order::getList($data);
		
		return ReturnData::create(ReturnData::SUCCESS,$res);
    }
    
    //生成订单
    public function orderAdd(Request $request)
	{
        //参数
        $default_address_id = $request->input('default_address_id','');
        $payid = $request->input('payid','');
        $user_bonus_id = $request->input('user_bonus_id','');
        $shipping_costs = $request->input('shipping_costs','');
        $message = $request->input('message','');
        
        //获取商品列表
        $cartids = $request->input('cartids','');
        
        if($cartids=='')
		{
            return ReturnData::create(ReturnData::PARAMS_ERROR);
        }
        
        $orderGoods = Cart::cartCheckoutGoodsList(array('ids'=>$cartids,'user_id'=>Token::$uid));
        
		return Order::add($data);
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