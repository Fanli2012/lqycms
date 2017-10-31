<?php
namespace App\Http\Controllers\Weixin;

use App\Http\Controllers\Weixin\CommonController;
use Illuminate\Http\Request;

class CartController extends CommonController
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
        $postdata = array(
            'ids' => $ids,
            'access_token' => $_SESSION['weixin_user_info']['access_token']
		);
        $url = env('APP_API_URL')."/cart_checkout_goods_list";
		$res = curl_request($url,$postdata,'GET');
        $data['list'] = $res['data']['list'];
        
        return view('weixin.cart.cartCheckout', $data);
    }
}