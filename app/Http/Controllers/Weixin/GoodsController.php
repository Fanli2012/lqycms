<?php
namespace App\Http\Controllers\Weixin;

use App\Http\Controllers\Weixin\CommonController;
use Illuminate\Http\Request;
use App\Common\ReturnCode;

class GoodsController extends CommonController
{
    public function __construct()
    {
        parent::__construct();
    }
	
    //商品详情
    public function goodsDetail($id)
	{
        $postdata = array(
            'id'  => $id
		);
        if(isset($_SESSION['weixin_user_info'])){$postdata['user_id']=$_SESSION['weixin_user_info']['id'];}
        $url = env('APP_API_URL')."/goods_detail";
		$res = curl_request($url,$postdata,'GET');
        $data['post'] = $res['data'];
        if(!$data['post']){$this->error_jump(ReturnCode::NO_FOUND,route('weixin'),3);}
        
        //添加浏览记录
        if(isset($_SESSION['weixin_user_info']))
        {
            $postdata = array(
                'goods_id'  => $id,
                'access_token' => $_SESSION['weixin_user_info']['access_token']
            );
            $url = env('APP_API_URL')."/user_goods_history_add";
            curl_request($url,$postdata,'POST');
        }
        
		return view('weixin.goods.goodsDetail', $data);
	}
    
    //商品列表
    public function goodsList(Request $request)
	{
        if($request->input('typeid', '') != ''){$param['typeid'] = $request->input('typeid');}
        if($request->input('tuijian', '') != ''){$param['tuijian'] = $request->input('tuijian');}
        if($request->input('keyword', '') != ''){$param['keyword'] = $request->input('keyword');}
        if($request->input('status', '') != ''){$param['status'] = $request->input('status');}
        if($request->input('is_promote', '') != ''){$param['is_promote'] = $request->input('is_promote');}
        if($request->input('orderby', '') != ''){$param['orderby'] = $request->input('orderby');}
        if($request->input('max_price', '') != ''){$param['max_price'] = $request->input('max_price');}else{$param['max_price'] = 99999;}
        if($request->input('min_price', '') != ''){$param['min_price'] = $request->input('min_price');}else{$param['min_price'] = 0;}
        if($request->input('brand_id', '') != ''){$param['brand_id'] = $request->input('brand_id');}
        
        //商品列表
        $postdata = $param;
        $postdata['limit'] = 10;
        $postdata['offset'] = 0;
        
        $url = env('APP_API_URL')."/goods_list";
		$res = curl_request($url,$postdata,'GET');
        $data['goods_list'] = $res['data']['list'];
        $data['request_param'] = $param;
        
		return view('weixin.goods.goodsList', $data);
	}
    
    //商品列表
    public function categoryGoodsList(Request $request)
	{
        $data['typeid'] = 0;
        if($request->input('typeid', '') != ''){$data['typeid'] = $request->input('typeid');}
        
        //商品分类列表
        $postdata = array(
            'pid'    => 0,
            'limit'  => 100,
            'offset' => 0
		);
        $url = env('APP_API_URL')."/goodstype_list";
		$res = curl_request($url,$postdata,'GET');
        $data['goodstype_list'] = $res['data']['list'];
        
       //商品列表
        $postdata = array(
            'typeid' => $data['typeid'],
            'limit'  => 100,
            'offset' => 0
		);
        $url = env('APP_API_URL')."/goods_list";
		$res = curl_request($url,$postdata,'GET');
        $data['goods_list'] = $res['data']['list'];
        
		return view('weixin.goods.categoryGoodsList', $data);
	}
}