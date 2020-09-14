<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Home\CommonController;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class PageController extends BaseController
{
    public function __construct()
    {
        parent::__construct();
    }

    //单页面
    public function detail($id)
    {
        $data = [];

        if (!empty($id) && preg_match('/[a-z0-9]+/', $id)) {
            $map['filename'] = $id;
            $post = cache("pageid$id");
            if (!$post) {
                $post = object_to_array(DB::table('page')->where($map)->first(), 1);
                //cache("pageid$id", $post, 2592000);
                cache(["pageid$id" => $post], \Carbon\Carbon::now()->addMinutes(2592000));
            }

            if (!$post) {
                return redirect()->route('page404');
            }
            $data['post'] = $post;
        } else {
            return redirect()->route('page404');
        }

        $data['posts'] = object_to_array(DB::table('page')->orderBy(\DB::raw('rand()'))->take(5)->get());

        return view('home.page.detail', $data);
    }

}