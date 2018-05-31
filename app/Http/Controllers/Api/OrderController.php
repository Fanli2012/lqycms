<?php
namespace App\Http\Controllers\Api;
use Log;
use DB;
use Illuminate\Http\Request;
use App\Common\ReturnData;
use App\Common\Helper;
use App\Common\Token;
use App\Http\Model\Order;
use App\Http\Logic\OrderLogic;

class OrderController extends CommonController
{
    public function __construct()
    {
        parent::__construct();
    }
    
    public function getLogic()
    {
        return logic('Order');
    }
    
    public function orderList(Request $request)
	{
        //参数
        $limit = $request->input('limit', 10);
        $offset = $request->input('offset', 0);
        
        $where = function ($query) use ($request) {
            $query->where('user_id', Token::$uid)->where('is_delete', 0);
            
            $status = $request->input('status',null);
            if($status!=null && $status!=0)
            {
                //0或者不传表示全部，1待付款，2待发货,3待收货,4待评价(确认收货，交易成功),5退款/售后
                if($status == 1)
                {
                    $query->where('order_status', 0)->where('pay_status', 0);
                }
                elseif($status == 2)
                {
                    $query->where('order_status', 0)->where('shipping_status', 0)->where('pay_status', 1);
                }
                elseif($status == 3)
                {
                    $query->where('order_status', 0)->where('shipping_status', 1)->where('pay_status', 1)->where('refund_status', 0);
                }
                elseif($status == 4)
                {
                    $query->where('order_status', 3)->where('shipping_status', 2)->where('is_comment', 0)->where('refund_status', 0);
                }
                elseif($status == 5)
                {
                    $query->where('order_status', 3)->where('refund_status', '<>', 0);
                }
            }
        };
        //var_dump(model('Order')->where($where)->toSql());exit;
        $res = $this->getLogic()->getList($where, array('id', 'desc'), '*', $offset, $limit);
		
		return ReturnData::create(ReturnData::SUCCESS,$res);
    }
    
    public function orderDetail(Request $request)
	{
        //参数
        if(!checkIsNumber($request->input('id',null))){return ReturnData::create(ReturnData::PARAMS_ERROR);}
        $id = $request->input('id');
        $where['id'] = $id;
        $where['user_id'] = Token::$uid;
        if($request->input('order_status','') != ''){$where['order_status'] = $request->input('order_status');}
        if($request->input('pay_status','') != ''){$where['pay_status'] = $request->input('pay_status');}
        if($request->input('refund_status','') != ''){$where['refund_status'] = $request->input('refund_status');}
        
        $res = $this->getLogic()->getOne($where);
		if(!$res)
		{
			return ReturnData::create(ReturnData::RECORD_NOT_EXIST);
		}
        
		return ReturnData::create(ReturnData::SUCCESS,$res);
    }
    
    //添加
    public function orderAdd(Request $request)
    {
        $data['default_address_id'] = $request->input('default_address_id','');
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
        
        if(Helper::isPostRequest())
        {
            $data['user_id'] = Token::$uid;
            
            return $this->getLogic()->add($data);
        }
    }
    
    //修改
    public function orderUpdate(Request $request)
    {
        if(!checkIsNumber($request->input('id',null))){return ReturnData::create(ReturnData::PARAMS_ERROR);}
        $id = $request->input('id');
        
        if(Helper::isPostRequest())
        {
            unset($_POST['id']);
            $where['id'] = $id;
            $where['user_id'] = Token::$uid;
            
            return $this->getLogic()->edit($_POST,$where);
        }
    }
    
    //删除
    public function orderDelete(Request $request)
    {
        if(!checkIsNumber($request->input('id',null))){return ReturnData::create(ReturnData::PARAMS_ERROR);}
        $id = $request->input('id');
        
        if(Helper::isPostRequest())
        {
            $where['id'] = $id;
            $where['user_id'] = Token::$uid;
            
            return $this->getLogic()->del($where);
        }
    }
    
    //用户-取消订单
    public function userCancelOrder(Request $request)
	{
        if(!checkIsNumber($request->input('id',null))){return ReturnData::create(ReturnData::PARAMS_ERROR);}
        $id = $request->input('id');
        
        $where['id'] = $id;
        $where['user_id'] = Token::$uid;
        
        return $this->getLogic()->userCancelOrder($where);
    }
    
    //订单-余额支付
    public function orderYuepay(Request $request)
	{
        if(!checkIsNumber($request->input('id',null))){return ReturnData::create(ReturnData::PARAMS_ERROR);}
        $id = $request->input('id');
        
        $where['id'] = $id;
        $where['user_id'] = Token::$uid;
        
        return $this->getLogic()->orderYuepay($where);
    }
    
    //用户-确认收货
    public function userReceiptConfirm(Request $request)
	{
        if(!checkIsNumber($request->input('id',null))){return ReturnData::create(ReturnData::PARAMS_ERROR);}
        $id = $request->input('id');
        
        $where['id'] = $id;
        $where['user_id'] = Token::$uid;
        
        return $this->getLogic()->orderReceiptConfirm($where);
    }
    
    //用户-退款退货
    public function userOrderRefund(Request $request)
	{
        if(!checkIsNumber($request->input('id',null))){return ReturnData::create(ReturnData::PARAMS_ERROR);}
        $id = $request->input('id');
        
        $where['id'] = $id;
        $where['user_id'] = Token::$uid;
        
        return $this->getLogic()->orderRefund($where);
    }
    
    //用户-删除订单
    public function userOrderDelete(Request $request)
	{
        if(!checkIsNumber($request->input('id',null))){return ReturnData::create(ReturnData::PARAMS_ERROR);}
        $id = $request->input('id');
        
        $where['id'] = $id;
        $where['user_id'] = Token::$uid;
        
        return $this->getLogic()->del($where);
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
            $order = model('Order')->getOne($where);
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
    
    //商城支付宝app支付
	public function orderAlipayApp(Request $request)
    {
        $id = $request->input('id',null);
        if($id===null){return ReturnCode::create(ReturnCode::PARAMS_ERROR);}
        
        $order = DB::table('order')->where(['id'=>$id,'status'=>0,'user_id'=>Token::$uid])->first();
        if(!$order){return ReturnCode::create(ReturnCode::PARAMS_ERROR);}
        
        $order_pay = DB::table('order_pay')->where(['id'=>$order->pay_id])->first();
        if(!$order_pay){return ReturnCode::create(ReturnCode::PARAMS_ERROR);}
        
        require_once base_path('resources/org/alipay_app').'/AopClient.php';
        require_once base_path('resources/org/alipay_app').'/AlipayTradeAppPayRequest.php';
        
        $aop = new \AopClient;
        $aop->gatewayUrl = "https://openapi.alipay.com/gateway.do";
        $aop->appId = config('alipay.app_alipay.appId');
        $aop->rsaPrivateKey = config('alipay.app_alipay.rsaPrivateKey');
        $aop->format = "json";
        $aop->charset = "UTF-8";
        $aop->signType = "RSA2";
        $aop->alipayrsaPublicKey = config('alipay.app_alipay.alipayrsaPublicKey');
        //实例化具体API对应的request类,类名称和接口名称对应,当前调用接口名称：alipay.trade.app.pay
        $request = new \AlipayTradeAppPayRequest();
        //SDK已经封装掉了公共参数，这里只需要传入业务参数
        $bizcontent = "{\"body\":\"订单支付\"," 
                        . "\"subject\": \"订单支付\","
                        . "\"out_trade_no\": \"".$order_pay->sn."\","
                        . "\"total_amount\": \"".$order_pay->pay_amount."\","
                        . "\"timeout_express\": \"30m\"," 
                        . "\"product_code\":\"QUICK_MSECURITY_PAY\""
                        . "}";
        $request->setNotifyUrl(config('app.url.apiDomain') . '/payment/notify/order_alipay/');
        $request->setBizContent($bizcontent);
        //这里和普通的接口调用不同，使用的是sdkExecute
        $response = $aop->sdkExecute($request);
        //htmlspecialchars是为了输出到页面时防止被浏览器将关键参数html转义，实际打印到日志以及http传输不会有这个问题
        return ReturnCode::create(ReturnCode::SUCCESS,$response);//就是orderString 可以直接给客户端请求，无需再做处理。
    }
    
    //商城微信app支付
	public function orderWxpayApp(Request $request)
    {
        //参数
		$id = $request->input('id',null);
        if($id===null){return ReturnCode::create(ReturnCode::PARAMS_ERROR);}
        
        $order_info = DB::table('order')->where(['id'=>$id,'status'=>0,'user_id'=>Token::$uid])->first();
        if(!$order_info){return ReturnCode::create(ReturnCode::PARAMS_ERROR);}
        
        $order_pay = DB::table('order_pay')->where(['id'=>$order_info->pay_id])->first();
        if(!$order_pay){return ReturnCode::create(ReturnCode::PARAMS_ERROR);}
        
		//1.配置
		$options = config('weixin.app');
        
		$app = new \EasyWeChat\Foundation\Application($options);
		$payment = $app->payment;
		$out_trade_no = $order_pay->sn;
        
		//2.创建订单
		$attributes = [
			'trade_type'       => 'APP', // JSAPI，NATIVE，APP...
			'body'             => '订单支付',
			'detail'           => '订单支付',
			'out_trade_no'     => $out_trade_no,
			'total_fee'        => $order_pay->pay_amount*100, // 单位：分
			'notify_url'       => config('app.url.apiDomain').'payment/notify/app_order_weixin_pay/', // 支付结果通知网址，如果不设置则会使用配置里的默认地址
			//'openid'           => '当前用户的 openid', // trade_type=JSAPI，此参数必传，用户在商户appid下的唯一标识，
			// ...
		];
        
		$order = new \EasyWeChat\Payment\Order($attributes);
        
		//3.统一下单
		$result = $payment->prepare($order);
        
		if ($result->return_code == 'SUCCESS' && $result->result_code == 'SUCCESS')
		{
			$prepayId = $result->prepay_id;
			$res = $payment->configForAppPayment($prepayId);
		}
        
		$res['out_trade_no'] = $out_trade_no;

		return ReturnCode::create(ReturnCode::SUCCESS,$res);
    }
}