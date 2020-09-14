<?php

namespace App\Http\Controllers\Home;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class GoodsController extends BaseController
{
    public function __construct()
    {
        parent::__construct();
    }

    // 商品列表页
    public function index(Request $request)
    {
        if ($request->input('typeid', null) != null) {
            $postdata['typeid'] = $request->input('typeid');
        }
        if ($request->input('orderby', null) != null) {
            $postdata['orderby'] = $request->input('orderby');
        }
        if ($request->input('tuijian', null) != null) {
            $postdata['tuijian'] = $request->input('tuijian');
        }

        $pagesize = 15;
        $offset = 0;
        if (isset($_REQUEST['page'])) {
            $offset = ($_REQUEST['page'] - 1) * $pagesize;
        }

        //商品列表
        $postdata['limit'] = $pagesize;
        $postdata['offset'] = $offset;
        $url = env('APP_API_URL') . "/goods_list";
        $res = curl_request($url, $postdata, 'GET');
        $data['list'] = $res['data']['list'];

        $data['totalpage'] = ceil($res['data']['count'] / $pagesize);

        if (isset($_REQUEST['page_ajax']) && $_REQUEST['page_ajax'] == 1) {
            $html = '';

            if ($res['data']['list']) {
                foreach ($res['data']['list'] as $k => $v) {
                    $html .= '<li><a href="' . route('home_goods', array('id' => $v['id'])) . '" target="_blank"><img src="' . $v['litpic'] . '" alt="' . $v['title'] . '">';
                    $html .= '<p class="title">' . $v['title'] . '</p>';
                    $html .= '<p class="desc"><span class="price-point"><i></i>库存(' . $v['goods_number'] . ')</span> ' . $v['description'] . '</p>';
                    $html .= '<div class="item-prices red"><div class="item-link">立即<br>抢购</div><div class="item-info"><div class="price"><i>¥</i><em class="J_actPrice"><span class="yen">' . ceil($v['price']) . '</span></em></div>';
                    $html .= '<div class="dock"><div class="dock-price"><del class="orig-price">¥' . $v['market_price'] . '</del> <span class="benefit">包邮</span></div><div class="prompt"><div class="sold-num"><em>' . $v['sale'] . '</em> 件已付款</div></div></div></div></div></a></li>';

                    /* if($v['is_promote_goods']>0)
                    {
                        $html .= '<span class="badge_comm" style="background-color:#f23030;">Hot</span>';
                    }
                    
                    $html .= $v['title'].'</p><div class="goods_price">￥<b>'.$v['price'].'</b><span class="fr">'.$v['sale'].'人付款</span></div></div></a>';
                    $html .= '</li>'; */
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

        return view('home.goods.index', $data);
    }

    // 商品详情页
    public function detail($id)
    {
        if (empty($id) || !preg_match('/[0-9]+/', $id)) {
            return redirect()->route('page404');
        }

        $where['id'] = $id;
        $where['status'] = 0;
        $data['post'] = logic('Goods')->getOne($where);
        if (!$data['post']) {
            return redirect()->route('page404');
        }

        $data['tj_list'] = DB::table('goods')->where(['tuijian' => 1, 'status' => 0])->orderBy('id', 'desc')->get();

        return view('home.goods.detail', $data);
    }

    //商品列表页
    public function brand_list(Request $request)
    {
        $data['brand_list'] = object_to_array(DB::table('goods_brand')->where(['status' => 0])->take(30)->orderBy('listorder', 'asc')->get());

        return view('home.index.brandList', $data);
    }

}