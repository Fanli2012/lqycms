<?php

namespace App\Http\Controllers\Weixin;

use App\Http\Controllers\Weixin\CommonController;
use Illuminate\Http\Request;
use App\Common\ReturnCode;

class GoodsController extends BaseController
{
    public function __construct()
    {
        parent::__construct();
    }

    //商品详情
    public function goodsDetail($id)
    {
        $postdata = array(
            'id' => $id
        );
        if (isset($_SESSION['weixin_user_info'])) {
            $postdata['user_id'] = $_SESSION['weixin_user_info']['id'];
        }
        $url = env('APP_API_URL') . "/goods_detail";
        $res = curl_request($url, $postdata, 'GET');
        $data['post'] = $res['data'];
        if (!$data['post']) {
            $this->error_jump(ReturnCode::NO_FOUND, route('weixin'), 3);
        }

        //添加浏览记录
        if (isset($_SESSION['weixin_user_info'])) {
            $postdata = array(
                'goods_id' => $id,
                'access_token' => $_SESSION['weixin_user_info']['access_token']
            );
            $url = env('APP_API_URL') . "/user_goods_history_add";
            curl_request($url, $postdata, 'POST');
        }

        return view('weixin.goods.goodsDetail', $data);
    }

    //商品列表
    public function goodsList(Request $request)
    {
        if ($request->input('typeid', null) != null) {
            $param['typeid'] = $request->input('typeid');
        }
        if ($request->input('tuijian', null) != null) {
            $param['tuijian'] = $request->input('tuijian');
        }
        if ($request->input('keyword', null) != null) {
            $param['keyword'] = $request->input('keyword');
        }
        if ($request->input('status', null) != null) {
            $param['status'] = $request->input('status');
        }
        if ($request->input('is_promote', null) != null) {
            $param['is_promote'] = $request->input('is_promote');
        }
        if ($request->input('orderby', null) != null) {
            $param['orderby'] = $request->input('orderby');
        }
        if ($request->input('max_price', null) != null) {
            $param['max_price'] = $request->input('max_price');
        } else {
            $param['max_price'] = 99999;
        }
        if ($request->input('min_price', null) != null) {
            $param['min_price'] = $request->input('min_price');
        } else {
            $param['min_price'] = 0;
        }
        if ($request->input('brand_id', null) != null) {
            $param['brand_id'] = $request->input('brand_id');
        }

        //商品列表
        $postdata = $param;
        $postdata['limit'] = 10;
        $postdata['offset'] = 0;

        $url = env('APP_API_URL') . "/goods_list";
        $res = curl_request($url, $postdata, 'GET');
        $data['goods_list'] = $res['data']['list'];
        $data['request_param'] = $param;

        return view('weixin.goods.goodsList', $data);
    }

    //商品列表
    public function categoryGoodsList(Request $request)
    {
        $data['typeid'] = 0;
        if ($request->input('typeid', null) != null) {
            $data['typeid'] = $request->input('typeid');
        }

        $pagesize = 10;
        $offset = 0;
        if (isset($_REQUEST['page'])) {
            $offset = ($_REQUEST['page'] - 1) * $pagesize;
        }

        //商品列表
        $postdata = array(
            'typeid' => $data['typeid'],
            'limit' => $pagesize,
            'offset' => $offset
        );
        $url = env('APP_API_URL') . "/goods_list";
        $res = curl_request($url, $postdata, 'GET');
        $data['list'] = $res['data']['list'];

        $data['totalpage'] = ceil($res['data']['count'] / $pagesize);

        if (isset($_REQUEST['page_ajax']) && $_REQUEST['page_ajax'] == 1) {
            $html = '';

            if ($res['data']['list']) {
                foreach ($res['data']['list'] as $k => $v) {
                    $html .= '<li>';
                    $html .= '<a href="' . $v['goods_detail_url'] . '"><img alt="' . $v['title'] . '" src="' . $v['litpic'] . '"><div class="goods_info"><p class="goods_tit">';

                    if ($v['is_promote_goods'] > 0) {
                        $html .= '<span class="badge_comm" style="background-color:#f23030;">Hot</span>';
                    }

                    $html .= $v['title'] . '</p><div class="goods_price">￥<b>' . $v['price'] . '</b><span class="fr">' . $v['sale'] . '人付款</span></div></div></a>';
                    $html .= '</li>';
                }
            }

            exit(json_encode($html));
        }

        //商品分类列表
        $postdata = array(
            'pid' => 0,
            'limit' => 15,
            'offset' => 0
        );
        $url = env('APP_API_URL') . "/goodstype_list";
        $res = curl_request($url, $postdata, 'GET');
        $data['goodstype_list'] = $res['data']['list'];

        return view('weixin.goods.categoryGoodsList', $data);
    }
}