<?php
namespace App\Http\Controllers\Weixin;

use App\Http\Controllers\Weixin\CommonController;
use Illuminate\Http\Request;

class UserController extends CommonController
{
    public function __construct()
    {
        parent::__construct();
    }
	
    //个人中心
    public function index(Request $request)
	{$_SESSION['weixin_user_info']['access_token'] = '72d623d26a1a6d61186a97f9ccf752f7';
        if($request->input('typeid', '') != ''){$data['typeid'] = $request->input('typeid');}
        if($request->input('tuijian', '') != ''){$data['tuijian'] = $request->input('tuijian');}
        if($request->input('keyword', '') != ''){$data['keyword'] = $request->input('keyword');}
        if($request->input('status', '') != ''){$data['status'] = $request->input('status');}
        if($request->input('is_promote', '') != ''){$data['is_promote'] = $request->input('is_promote');}
        if($request->input('orderby', '') != ''){$data['orderby'] = $request->input('orderby');}
        if($request->input('max_price', '') != ''){$data['max_price'] = $request->input('max_price');}else{$data['max_price'] = 99999;}
        if($request->input('min_price', '') != ''){$data['min_price'] = $request->input('min_price');}else{$data['min_price'] = 0;}
        
        //商品列表
        $postdata = array(
            'limit'  => 10,
            'offset' => 0
		);
        $url = env('APP_API_URL')."/goods_list";
		$goods_list = curl_request($url,$postdata,'GET');
        $data['goods_list'] = $goods_list['data']['list'];
        
		return view('weixin.user.index', $data);
	}
    
    //浏览记录
    public function userGoodsHistory(Request $request)
	{
        //商品列表
        $postdata = array(
            'limit'  => 10,
            'offset' => 0,
            'access_token' => $_SESSION['weixin_user_info']['access_token']
		);
        $url = env('APP_API_URL')."/user_goods_history_list";
		$res = curl_request($url,$postdata,'GET');
        $data['user_goods_history'] = $res['data']['list'];
        
		return view('weixin.user.userGoodsHistory', $data);
	}
}