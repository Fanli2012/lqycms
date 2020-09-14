<?php
namespace App\Http\Controllers\Weixin;

use App\Http\Controllers\Weixin\CommonController;
use Illuminate\Http\Request;
use App\Common\ReturnData;
use App\Common\ReturnCode;

class CartController extends BaseController
{
    public function __construct()
    {
        parent::__construct();
    }
	
    //商品列表
    public function index(Request $request)
	{
        //购物车列表
        $postdata = array(
            'access_token' => $_SESSION['weixin_user_info']['access_token']
		);
        $url = env('APP_API_URL')."/cart_list";
		$res = curl_request($url,$postdata,'GET');
        $data['list'] = $res['data']['list'];
        
        //猜你喜欢商品列表
        $postdata = array(
            'limit'  => 4,
            'orderby'=> 1,
            'offset' => 0
		);
        $url = env('APP_API_URL')."/goods_list";
		$res = curl_request($url,$postdata,'GET');
        $data['like_goods_list'] = $res['data']['list'];
        
		return view('weixin.cart.index', $data);
	}
    
    //购物车结算
    public function cartCheckout($ids)
	{
        //支付方式列表
        $postdata = array(
            'status' => 1,
            'access_token' => $_SESSION['weixin_user_info']['access_token']
		);
        $url = env('APP_API_URL')."/payment_list";
		$res = curl_request($url,$postdata,'GET');
        $data['payment_list'] = $res['data']['list'];
        
        //用户默认收货地址
        $postdata = array(
            'access_token' => $_SESSION['weixin_user_info']['access_token']
		);
        $url = env('APP_API_URL')."/user_default_address";
		$res = curl_request($url,$postdata,'GET');
        $data['user_default_address'] = $res['data'];
        
        //收货地址列表
        $postdata = array(
            'limit'  => 100,
            'access_token' => $_SESSION['weixin_user_info']['access_token']
		);
        $url = env('APP_API_URL')."/user_address_list";
		$res = curl_request($url,$postdata,'GET');
        $data['address_list'] = $res['data']['list'];
        $data['cartids'] = $ids;
        
        //获取会员信息
        $postdata = array(
            'access_token' => $_SESSION['weixin_user_info']['access_token']
		);
        $url = env('APP_API_URL')."/user_info";
		$res = curl_request($url,$postdata,'GET');
        $data['user_info'] = $res['data'];
        
        //购物车结算商品列表
        $postdata = array(
            'ids' => $ids,
            'access_token' => $_SESSION['weixin_user_info']['access_token']
		);
        $url = env('APP_API_URL')."/cart_checkout_goods_list";
		$res = curl_request($url,$postdata,'GET');
        $data['checkout_goods'] = $res['data'];
        if(empty($data['checkout_goods']['list'])){$this->error_jump(ReturnCode::NO_FOUND);}
        
        //判断余额是否足够
        $is_balance_enough = 1; //足够
        if($data['checkout_goods']['total_price']>$data['user_info']['money']){$is_balance_enough = 0;}
        $data['is_balance_enough'] = $is_balance_enough;
        
        //获取用户优惠券列表
        $postdata = array(
            'min_amount' => $data['checkout_goods']['total_price'],
            'access_token' => $_SESSION['weixin_user_info']['access_token']
		);
        $url = env('APP_API_URL')."/user_available_bonus_list";
		$res = curl_request($url,$postdata,'GET');
        $data['bonus_list'] = $res['data']['list'];
        
        return view('weixin.cart.cartCheckout', $data);
    }
    
    //生成订单
    public function cartDone(Request $request)
	{
        $cartids = $request->input('cartids',''); //购物车商品id，8_9
        $default_address_id = $request->input('default_address_id',''); //收货地址id
        //$payid = $request->input('payid',''); //支付方式：1余额支付，2微信，3支付宝
        $user_bonus_id = $request->input('user_bonus_id',0); //优惠券id，0没有优惠券
        $shipping_costs = $request->input('shipping_costs',''); //运费
        $message = $request->input('message',''); //买家留言
        
        if($default_address_id==''){$this->error_jump('请选择收货地址');}
        //if($payid==''){$this->error_jump('请选择支付方式');}
        if($cartids==''){$this->error_jump(ReturnData::PARAMS_ERROR);}
        
        //订单提交
        $postdata = array(
            'cartids' => $cartids,
            'default_address_id' => $default_address_id,
            //'payid' => $payid,
            'user_bonus_id' => $user_bonus_id,
            'shipping_costs' => $shipping_costs,
            'message' => $message,
            'access_token' => $_SESSION['weixin_user_info']['access_token']
		);
        $url = env('APP_API_URL')."/order_add";
		$res = curl_request($url,$postdata,'POST');
        
        if($res['code'] == ReturnData::SUCCESS)
        {
            header("Location: ".route('weixin_order_pay',array('id'=>$res['data'])));
            exit;
    	}
        else
        {
            $ReturnMsg = '生成订单失败';
    		if($res['msg'])
            {
    			$ReturnMsg = $res['msg'];
    		}
            
            $this->error_jump($ReturnMsg);
    	}
    }
}