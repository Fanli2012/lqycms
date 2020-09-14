<?php

namespace App\Http\Controllers\Wap;

use Illuminate\Support\Facades\DB;

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
            if (cache("pageid$id")) {
                $post = cache("pageid$id");
            } else {
                $post = object_to_array(DB::table('page')->where($map)->first(), 1);
                cache("pageid$id", $post, 2592000);
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

        return view('wap.page.detail', $data);
    }

}