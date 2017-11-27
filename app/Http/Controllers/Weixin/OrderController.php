<?php
namespace App\Http\Controllers\Weixin;

use App\Http\Controllers\Weixin\CommonController;
use Illuminate\Http\Request;
use App\Common\ReturnData;

class OrderController extends CommonController
{
    public function __construct()
    {
        parent::__construct();
    }
	
    //订单支付
    public function pay($id)
	{
        //获取订单详情
        $postdata = array(
            'order_id' => $id, //要支付的订单id
            'access_token' => $_SESSION['weixin_user_info']['access_token']
		);
        $url = env('APP_API_URL')."/order_detail";
		$res = curl_request($url,$postdata,'GET');
        $data['order_detail'] = $res['data'];
        $data['order_id'] = $id;
        
        
        //获取会员信息
        $postdata = array(
            'access_token' => $_SESSION['weixin_user_info']['access_token']
		);
        $url = env('APP_API_URL')."/user_info";
		$res = curl_request($url,$postdata,'GET');
        $data['user_info'] = $res['data'];
        
        //判断余额是否足够
        $is_balance_enough = 1; //足够
        if($data['order_detail']['total_price']>$data['user_info']['money']){$is_balance_enough = 0;}
        $data['is_balance_enough'] = $is_balance_enough;
        
		return view('weixin.order.pay', $data);
	}
}