<?php
namespace App\Http\Controllers\Weixin;

use App\Http\Controllers\Weixin\CommonController;
use Illuminate\Http\Request;

class ArticleController extends CommonController
{
    public function __construct()
    {
        parent::__construct();
    }
	
    //列表页
    public function category($cat)
	{
        //文章分类
        $postdata = array(
            'id'  => $cat
		);
        $url = env('APP_API_URL')."/arctype_detail";
		$arctype_detail = curl_request($url,$postdata,'GET');
        $data['post'] = $arctype_detail['data'];
        
        //文章列表
        $postdata = array(
            'limit'  => 10,
            'offset' => 0
		);
        $url = env('APP_API_URL')."/article_list";
		$article_list = curl_request($url,$postdata,'GET');
        $data['article_list'] = $article_list['data']['list'];
        
		return view('weixin.article.category', $data);
	}
    
    //文章详情页
    public function detail($id)
	{
        //最新资讯
        $postdata = array(
            'id'  => $id
		);
        $url = env('APP_API_URL')."/article_detail";
		$article_detail = curl_request($url,$postdata,'GET');
        if(empty($article_detail['data'])){return redirect()->route('weixin_page404');}
        $article_detail['data']['body'] = preg_replace('/src=\"\/uploads\/allimg/',"src=\"".env('APP_URL')."/uploads/allimg",$article_detail['data']['body']);
        $data['post'] = $article_detail['data'];
        
        return view('weixin.article.detail', $data);
    }
	
}