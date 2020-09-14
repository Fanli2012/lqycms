<?php

namespace App\Http\Controllers\Wap;

use Illuminate\Support\Facades\DB;

class GoodsController extends BaseController
{
    public function __construct()
    {
        parent::__construct();
    }

    //商品列表页
    public function index($cat, $page = 0)
    {
        $pagenow = $page;

        if (empty($cat) || !preg_match('/[0-9]+/', $cat)) {
            return redirect()->route('page404');
        }

        $post = object_to_array(DB::table('product_type')->where('id', $cat)->first(), 1);
        if (empty($post)) {
            return redirect()->route('page404');
        }
        $data['post'] = $post;

        $subcat = "";
        $post2 = object_to_array(DB::table('product_type')->select('id')->where('pid', $cat)->get());
        if (!empty($post2)) {
            foreach ($post2 as $row) {
                $subcat = $subcat . "typeid=" . $row["id"] . " or ";
            }
        }
        $subcat = $subcat . "typeid=" . $cat;
        $data['sql'] = $subcat;

        $counts = DB::table("product")->whereRaw($subcat)->count();
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

        $data['posts'] = arclist(array("table" => "product", "sql" => $subcat, "limit" => "$start,$pagesize")); //获取列表
        $data['pagenav'] = get_listnav(array("counts" => $counts, "pagesize" => $pagesize, "pagenow" => $page + 1, "catid" => $cat, "urltype" => "product")); //获取分页列表

        if ($post['templist'] == 'category2') {
            if (!empty($pagenow)) {
                return redirect()->route('page404');
            }
        }

        return view('wap.goods.index', $data);
    }

    //商品详情页
    public function detail($id)
    {
        if (empty($id) || !preg_match('/[0-9]+/', $id)) {
            return redirect()->route('page404');
        }

        $post = object_to_array(DB::table('product')->where('id', $id)->first(), 1);
        if (empty($post)) {
            return redirect()->route('page404');
        }
        $post['name'] = DB::table('product_type')->where('id', $post['typeid'])->value('name');
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

        $post = object_to_array(DB::table('product_type')->where('id', $cat)->first(), 1);

        return view('wap.goods.detail', $data);
    }
}