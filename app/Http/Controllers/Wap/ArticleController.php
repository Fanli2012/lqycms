<?php

namespace App\Http\Controllers\Wap;

use Illuminate\Support\Facades\DB;

class ArticleController extends BaseController
{
    public function __construct()
    {
        parent::__construct();
    }

    //列表页
    public function index($cat, $page = 0)
    {
        $pagenow = $page;

        if (empty($cat) || !preg_match('/[0-9]+/', $cat)) {
            return redirect()->route('page404');
        }

        if (cache("catid$cat")) {
            $post = cache("catid$cat");
        } else {
            $post = object_to_array(DB::table('arctype')->where('id', $cat)->first(), 1);
            if (empty($post)) {
                return redirect()->route('page404');
            }
            cache(["catid$cat" => $post], \Carbon\Carbon::now()->addMinutes(2592000));
        }
        $data['post'] = $post;

        $subcat = "";
        $sql = "";
        $post2 = object_to_array(DB::table('arctype')->select('id')->where('pid', $cat)->get());
        if (!empty($post2)) {
            foreach ($post2 as $row) {
                $subcat = $subcat . "typeid=" . $row["id"] . " or ";
            }
        }
        $subcat = $subcat . "typeid=" . $cat;
        $sql = $subcat . " or typeid2 in (" . $cat . ")";//echo $subcat2;exit;
        $data['sql'] = $sql;

        $counts = DB::table("article")->whereRaw($sql)->count();
        if ($counts > sysconfig('CMS_MAXARC')) {
            $counts = sysconfig('CMS_MAXARC');
            dd($counts);
        }
        $pagesize = sysconfig('CMS_PAGESIZE');
        $page = 0;
        if ($counts % $pagesize) {//取总数据量除以每页数的余数
            $pages = intval($counts / $pagesize) + 1; //如果有余数，则页数等于总数据量除以每页数的结果取整再加一,如果没有余数，则页数等于总数据量除以每页数的结果
        } else {
            $pages = $counts / $pagesize;
        }
        if (!empty($pagenow)) {
            if ($pagenow == 1 || $pagenow > $pages) {
                return redirect()->route('page404');
            }
            $page = $pagenow - 1;
            $nextpage = $pagenow + 1;
            $previouspage = $pagenow - 1;
        } else {
            $page = 0;
            $nextpage = 2;
            $previouspage = 0;
        }
        $data['page'] = $page;
        $data['pages'] = $pages;
        $data['counts'] = $counts;
        $start = $page * $pagesize;

        $data['posts'] = arclist(array("sql" => $sql, "limit" => "$start,$pagesize")); //获取列表
        $data['pagenav'] = get_listnav(array("counts" => $counts, "pagesize" => $pagesize, "pagenow" => $page + 1, "catid" => $cat)); //获取分页列表

        if ($post['templist'] == 'category2') {
            if (!empty($pagenow)) {
                return redirect()->route('page404');
            }
        }

        return view('wap.article.index', $data);
    }

    //文章详情页
    public function detail($id)
    {
        if (empty($id) || !preg_match('/[0-9]+/', $id)) {
            return redirect()->route('page404');
        }

        if (cache("detailid$id")) {
            $post = cache("detailid$id");
        } else {
            $post = object_to_array(DB::table('article')->where('id', $id)->first(), 1);
            if (empty($post)) {
                return redirect()->route('page404');
            }
            $post['name'] = DB::table('arctype')->where('id', $post['typeid'])->value('name');
            cache(["detailid$id" => $post], \Carbon\Carbon::now()->addMinutes(2592000));
        }
        if ($post) {
            $cat = $post['typeid'];
            $post['body'] = ReplaceKeyword($post['body']);
            if (!empty($post['writer'])) {
                $post['writertitle'] = $post['title'] . ' ' . $post['writer'];
            }

            $data['post'] = $post;
            $data['pre'] = get_article_prenext(array('aid' => $post["id"], 'typeid' => $post["typeid"], 'type' => "pre"));
        } else {
            return redirect()->route('page404');
        }

        if (cache("catid$cat")) {
            $post = cache("catid$cat");
        } else {
            $post = object_to_array(DB::table('arctype')->where('id', $cat)->first(), 1);
            cache(["catid$cat" => $post], \Carbon\Carbon::now()->addMinutes(2592000));
        }

        return view('wap.article.detail', $data);
    }
}