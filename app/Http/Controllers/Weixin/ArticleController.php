<?php

namespace App\Http\Controllers\Weixin;

use App\Http\Controllers\Weixin\CommonController;
use Illuminate\Http\Request;

class ArticleController extends BaseController
{
    public function __construct()
    {
        parent::__construct();
    }

    //列表页
    public function category($cat)
    {
        $pagesize = 10;
        $offset = 0;

        //文章分类
        $postdata = array(
            'id' => $cat
        );
        $url = env('APP_API_URL') . "/arctype_detail";
        $arctype_detail = curl_request($url, $postdata, 'GET');
        $data['post'] = $arctype_detail['data'];

        if (isset($_REQUEST['page'])) {
            $offset = ($_REQUEST['page'] - 1) * $pagesize;
        }

        //文章列表
        $postdata2 = array(
            'limit' => $pagesize,
            'offset' => $offset,
            'typeid' => $cat
        );
        $url = env('APP_API_URL') . "/article_list";
        $res = curl_request($url, $postdata2, 'GET');
        if ($res['data']['list']) {
            foreach ($res['data']['list'] as $k => $v) {
                $res['data']['list'][$k]['pubdate'] = date("Y-m-d H:i", $v['pubdate']);
            }
        }
        $data['list'] = $res['data']['list'];

        $data['totalpage'] = ceil($res['data']['count'] / $pagesize);

        if (isset($_REQUEST['page_ajax']) && $_REQUEST['page_ajax'] == 1) {
            $html = '';

            if ($res['data']['list']) {
                foreach ($res['data']['list'] as $k => $v) {
                    $html .= '<li><a href="' . $v['article_detail_url'] . '">' . $v['title'] . '</a><p>' . $v['pubdate'] . '</p></li>';
                }
            }

            exit(json_encode($html));
        }

        return view('weixin.article.category', $data);
    }

    //文章详情页
    public function detail($id)
    {
        //最新资讯
        $postdata = array(
            'id' => $id
        );
        $url = env('APP_API_URL') . "/article_detail";
        $res = curl_request($url, $postdata, 'GET');
        if (empty($res['data'])) {
            return redirect()->route('weixin_page404');
        }
        $res['data']['body'] = preg_replace('/src=\"\/uploads\/allimg/', "src=\"" . env('APP_URL') . "/uploads/allimg", $res['data']['body']);
        $res['data']['pubdate'] = date('Y-m-d', $res['data']['pubdate']);
        $data['post'] = $res['data'];

        return view('weixin.article.detail', $data);
    }
}