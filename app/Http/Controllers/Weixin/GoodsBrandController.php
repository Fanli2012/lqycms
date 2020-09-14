<?php

namespace App\Http\Controllers\Weixin;

use App\Http\Controllers\Weixin\CommonController;
use Illuminate\Http\Request;
use App\Common\ReturnCode;

class GoodsBrandController extends BaseController
{
    public function __construct()
    {
        parent::__construct();
    }

    //商品品牌详情
    public function brandDetail($id)
    {
        $postdata['id'] = $id;
        $url = env('APP_API_URL') . "/goodsbrand_detail";
        $res = curl_request($url, $postdata, 'GET');
        $data['post'] = $res['data'];
        if (!$data['post']) {
            $this->error_jump(ReturnCode::NO_FOUND, route('weixin'), 3);
        }

        return view('weixin.goods_brand.brandDetail', $data);
    }

    //商品品牌列表
    public function brandList(Request $request)
    {
        //商品列表
        $postdata['limit'] = 10;
        $postdata['offset'] = 0;

        $url = env('APP_API_URL') . "/goodsbrand_list";
        $res = curl_request($url, $postdata, 'GET');
        $data['list'] = $res['data']['list'];

        return view('weixin.goods_brand.brandList', $data);
    }
}