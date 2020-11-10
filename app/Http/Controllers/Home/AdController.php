<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Home\CommonController;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Common\Helper;

class AdController extends BaseController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function detail($id)
    {
		$where = function ($query) use ($id) {
            $query->where('id', '=', $id)->orWhere('flag', '=', $id);
        };
        $post = cache("index_ad_detail_$id");
        if (!$post) {
			$time = time();
			$post = DB::table('ad')->where($where)->first();
            if (!$post) {
                exit('not found');
            }
			if ($post->is_expire == 1 && $post->end_time < $time) {
				exit('expired');
			}
            cache("index_ad_detail_$id", $post, 2592000);
        }

		if (Helper::is_mobile_access()) {
			if ($post->content_wap) {
				exit($post->content_wap);
			}
		}
        exit($post->content);
    }

}