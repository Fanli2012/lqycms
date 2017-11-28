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
        $data['status'] = $request->input('status','');
        
        return Order::getList($data);
    }
    
    //订单详情
    public function orderDetail(Request $request)
	{
        //参数
        $data['user_id'] = Token::$uid;
        $data['order_id'] = $request->input('order_id','');
        
        if($data['order_id']=='')
		{
            return ReturnData::create(ReturnData::PARAMS_ERROR);
        }
        
        return Order::getUnpaidOrder($data);
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
    public function orderDelete(Request $request)
	{
        $id = $request->input('id','');
        
        if($id=='')
		{
            return ReturnData::create(ReturnData::PARAMS_ERROR);
        }
        
        return Order::remove($id,Token::$uid);
    }
}