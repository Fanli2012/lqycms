<?php

namespace App\Http\Controllers\Home;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class ArticleController extends BaseController
{
    public function __construct()
    {
        parent::__construct();
    }

    //文章列表页
    public function index(Request $request)
    {
        $pagesize = 10;
        $offset = 0;

        //文章分类
        if ($request->input('typeid', null) != null) {
            $postdata = array(
                'id' => $request->input('typeid')
            );
            $url = env('APP_API_URL') . "/arctype_detail";
            $arctype_detail = curl_request($url, $postdata, 'GET');
            $data['post'] = $arctype_detail['data'];
        }

        if (isset($_REQUEST['page'])) {
            $offset = ($_REQUEST['page'] - 1) * $pagesize;
        }

        //文章列表
        $postdata2 = array(
            'limit' => $pagesize,
            'offset' => $offset
        );
        if ($request->input('typeid', null) != null) {
            $postdata2['typeid'] = $request->input('typeid');
        }

        $url = env('APP_API_URL') . "/article_list";
        $res = curl_request($url, $postdata2, 'GET');
        $data['list'] = $res['data']['list'];

        $data['totalpage'] = ceil($res['data']['count'] / $pagesize);

        if (isset($_REQUEST['page_ajax']) && $_REQUEST['page_ajax'] == 1) {
            $html = '';

            if ($res['data']['list']) {
                foreach ($res['data']['list'] as $k => $v) {
                    $html .= '<div class="list">';
                    if (!empty($v['litpic'])) {
                        $html .= '<a class="limg" href="' . get_front_url(array("id" => $v['id'], "catid" => $v['typeid'], "type" => 'content')) . '"><img alt="' . $v['title'] . '" src="' . $v['litpic'] . '"></a>';
                    }
                    $html .= '<strong class="tit"><a href="' . get_front_url(array("id" => $v['id'], "catid" => $v['typeid'], "type" => 'content')) . '">' . $v['title'] . '</a></strong><p>' . mb_strcut($v['description'], 0, 150, 'UTF-8') . '..</p>';
                    $html .= '<div class="info"><span class="fl">';
                    $taglist = taglist($v['id']);
                    if ($taglist) {
                        foreach ($taglist as $row) {
                            $html .= '<a href="' . get_front_url(array("tagid" => $row['id'], "type" => 'tags')) . '">' . $row['tag'] . '</a>';
                        }
                    }
                    $html .= '<em>' . date("m-d H:i", $v['pubdate']) . '</em></span><span class="fr"><em>' . $v['click'] . '</em>人阅读</span></div><div class="cl"></div></div>';
                }
            }

            exit(json_encode($html));
        }

        return view('home.article.index', $data);
    }

    //文章详情页
    public function detail($id)
    {
        if (empty($id) || !preg_match('/[0-9]+/', $id)) {
            return redirect()->route('page404');
        }

        $post = cache("detailid$id");
        if (!$post) {
            $post = object_to_array(DB::table('article')->where('id', $id)->first(), 1);
            if (empty($post)) {
                return redirect()->route('page404');
            }
            $post['name'] = DB::table('arctype')->where('id', $post['typeid'])->value('name');
            cache(["detailid$id" => $post], \Carbon\Carbon::now()->addMinutes(2592000));
        }
        if (!$post) {
            return redirect()->route('page404');
        }
        $cat = $post['typeid'];
        $post['body'] = ReplaceKeyword($post['body']);
        if (!empty($post['writer'])) {
            $post['writertitle'] = $post['title'] . ' ' . $post['writer'];
        }

        $data['post'] = $post;
        $data['pre'] = get_article_prenext(array('aid' => $post["id"], 'typeid' => $post["typeid"], 'type' => "pre"));

        $post = cache("catid$cat");
        if (!$post) {
            $post = object_to_array(DB::table('arctype')->where('id', $cat)->first(), 1);
            cache(["catid$cat" => $post], \Carbon\Carbon::now()->addMinutes(2592000));
        }

        return view('home.article.detail', $data);
    }

}