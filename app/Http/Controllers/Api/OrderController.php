<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\CommonController;
use Illuminate\Http\Request;
use App\Common\ReturnData;
use App\Common\Token;
use App\Http\Model\Order;
use DB;

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
        $data['status'] = $request->input('status',-1);
        
        return Order::getList($data);
    }
    
    //订单详情
    public function orderDetail(Request $request)
	{
        //参数
        $data['user_id'] = Token::$uid;
        $data['order_id'] = $request->input('order_id','');
        if($request->input('order_status','') != ''){$data['order_status'] = $request->input('order_status');}
        if($request->input('pay_status','') != ''){$data['pay_status'] = $request->input('pay_status');}
        if($request->input('refund_status','') != ''){$data['refund_status'] = $request->input('refund_status');}
        
        if($data['order_id']=='')
		{
            return ReturnData::create(ReturnData::PARAMS_ERROR);
        }
        
        return Order::getOne($data);
    }
    
    //生成订单
    public function orderAdd(Request $request)
	{
        //参数
        $data['default_address_id'] = $request->input('default_address_id','');
        //$data['payid'] = $request->input('payid','');
        $data['user_bonus_id'] = $request->input('user_bonus_id','');
        $data['shipping_costs'] = $request->input('shipping_costs','');
        $data['message'] = $request->input('message','');
        $data['place_type'] = $request->input('place_type',2); //订单来源,1pc，2微信，3app
        $data['user_id'] = Token::$uid;
        
        //获取商品列表
        $data['cartids'] = $request->input('cartids','');
        
        if($data['cartids']=='')
		{
            return ReturnData::create(ReturnData::PARAMS_ERROR);
        }
        
		return Order::add($data);
    }
    
    //订单修改
    public function orderUpdate(Request $request)
	{
		if($request->input('id', '')!=''){$where['id'] = $request->input('id');}
        if($request->input('order_sn', '')!=''){$where['order_sn'] = $request->input('order_sn');}
        
        if($request->input('order_amount', '')!=''){$data['order_amount'] = $request->input('order_amount');}
        if($request->input('out_trade_no', '')!=''){$data['out_trade_no'] = $request->input('out_trade_no');}
        if($request->input('shipping_name', '')!=''){$data['shipping_name'] = $request->input('shipping_name');}
        if($request->input('shipping_id', '')!=''){$data['shipping_id'] = $request->input('shipping_id');}
        if($request->input('shipping_sn', '')!=''){$data['shipping_sn'] = $request->input('shipping_sn');}
        if($request->input('shipping_fee', '')!=''){$data['shipping_fee'] = $request->input('shipping_fee');}
        if($request->input('shipping_time', '')!=''){$data['shipping_time'] = $request->input('shipping_time');}
        if($request->input('name', '')!=''){$data['name'] = $request->input('name');}
        if($request->input('province', '')!=''){$data['province'] = $request->input('province');}
        if($request->input('city', '')!=''){$data['city'] = $request->input('city');}
        if($request->input('district', '')!=''){$data['district'] = $request->input('district');}
        if($request->input('address', '')!=''){$data['address'] = $request->input('address');}
        if($request->input('zipcode', '')!=''){$data['zipcode'] = $request->input('zipcode');}
        if($request->input('mobile', '')!=''){$data['mobile'] = $request->input('mobile');}
        if($request->input('message', '')!=''){$data['message'] = $request->input('message');}
        if($request->input('is_comment', '')!=''){$data['is_comment'] = $request->input('is_comment');}
        if($request->input('is_delete', '')!=''){$data['is_delete'] = $request->input('is_delete');}
        if($request->input('to_buyer', '')!=''){$data['to_buyer'] = $request->input('to_buyer');}
        if($request->input('invoice', '')!=''){$data['invoice'] = $request->input('invoice');}
        if($request->input('invoice_title', '')!=''){$data['invoice_title'] = $request->input('invoice_title');}
        if($request->input('invoice_taxpayer_number', '')!=''){$data['invoice_taxpayer_number'] = $request->input('invoice_taxpayer_number');}
        
        if(!isset($where)){return ReturnData::create(ReturnData::PARAMS_ERROR);}
        
        if (isset($data))
		{
            $where['user_id'] = Token::$uid;
			Order::modify($where,$data);
        }
		
		return ReturnData::create(ReturnData::SUCCESS);
    }
    
    //订单状态修改
    public function orderStatusUpdate(Request $request)
	{
		$type = $request->input('type','');
        if($request->input('id', '')!=''){$where['id'] = $request->input('id');}
        $where['user_id'] = Token::$uid;
        
        if($type=='' || $where['id'] =='')
		{
            return ReturnData::create(ReturnData::PARAMS_ERROR);
        }
        
        //修改订单状态，1设为支付，2设为取消，3设为确认收货，4设为退款退货，5设为删除，6设为已评价
        if($type == 1)
        {
            //判断订单是否存在或本人
            $where['order_status'] = 0;
            $where['pay_status'] = 0;
            $order = Order::where($where)->first();
            if(!$order){return ReturnData::create(ReturnData::PARAMS_ERROR,null,'订单不存在');}
            
            //判断用户余额是否足够
            $user_money = DB::table('user')->where(array('id'=>Token::$uid))->value('money');
            if($order['order_amount']>$user_money){return ReturnData::create(ReturnData::PARAMS_ERROR,null,'余额不足');}
            
            $data['pay_status'] = 1;
            $data['pay_money'] = $order['order_amount']; //支付金额
            $data['pay_id'] = $request->input('pay_id','');
            $data['pay_time'] = $request->input('pay_time',time());
            if($request->input('pay_name', '')!=''){$data['pay_name'] = $request->input('pay_name');}
            
            //扣除用户余额
            if($data['pay_money']<=0 || !DB::table('user')->where(array('id'=>Token::$uid))->decrement('money', $data['pay_money']))
            {
                return ReturnData::create(ReturnData::PARAMS_ERROR);
            }
            
            //增加用户余额记录
            DB::table('user_money')->insert(array('user_id'=>Token::$uid,'type'=>1,'money'=>$data['pay_money'],'des'=>'订单余额支付','user_money'=>DB::table('user')->where(array('id'=>Token::$uid))->value('money'),'add_time'=>time()));
        }
        elseif($type == 2)
        {
            //判断订单是否存在或本人
            $where['order_status'] = 0;
            $where['pay_status'] = 0;
            $order = Order::where($where)->first();
            if(!$order){return ReturnData::create(ReturnData::PARAMS_ERROR,null,'订单不存在');}
            
            $data['order_status'] = 1;
        }
        elseif($type == 3)
        {
            //判断订单是否存在或本人
            $where['order_status'] = 0;
            $where['refund_status'] = 0;
            $where['pay_status'] = 1;
            $order = Order::where($where)->first();
            if(!$order){return ReturnData::create(ReturnData::PARAMS_ERROR,null,'订单不存在');}
            
            $data['order_status'] = 3;
            $data['shipping_status'] = 2;
            $data['refund_status'] = 0;
            $data['is_comment'] = 0;
        }
        elseif($type == 4)
        {
            //判断订单是否存在或本人
            $where['order_status'] = 3;
            $where['refund_status'] = 0;
            $order = Order::where($where)->first();
            if(!$order){return ReturnData::create(ReturnData::PARAMS_ERROR,null,'订单不存在');}
            
            $data['refund_status'] = 1;
        }
        elseif($type == 5)
        {
            //判断订单是否存在或本人
            $order = Order::where(array('order_status'=>3,'refund_status'=>0))->orWhere(array('order_status'=>1))->orWhere(array('order_status'=>2))->first();
            if(!$order){return ReturnData::create(ReturnData::PARAMS_ERROR,null,'订单不存在');}
            
            $data['is_delete'] = 1;
        }
        elseif($type == 6)
        {
            //判断订单是否存在或本人
            $where['order_status'] = 3;
            $where['refund_status'] = 0;
            $order = Order::where($where)->first();
            if(!$order){return ReturnData::create(ReturnData::PARAMS_ERROR,null,'订单不存在');}
            
            $data['is_comment'] = 1;
        }
        
        //修改订单状态
        if (isset($data))
		{
			Order::modify($where,$data);
        }
		
		return ReturnData::create(ReturnData::SUCCESS);
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