<?php
namespace App\Http\Controllers\Weixin;

use App\Http\Controllers\Weixin\CommonController;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class IndexController extends CommonController
{
    public function __construct()
    {
        parent::__construct();
    }
    
    //页面跳转
    public function jump()
	{
		return view('weixin.index.jump');
    }
	
	//首页
    public function index()
	{
        //分享到首页，把推荐id存下来
        if(isset($_GET['parent_id']) && !empty($_GET['parent_id']))
        {
			$_SESSION['weixin_user_parent_id'] = intval($_GET['parent_id']);
		}
        
        //banner轮播图
        $postdata = array(
            'limit'  => 5,
            'offset' => 0
		);
        $url = env('APP_API_URL')."/slide_list";
		$slide_list = curl_request($url,$postdata,'GET');
        $data['slide_list'] = $slide_list['data']['list'];
        
        //最新资讯
        $postdata = array(
            'limit'  => 5,
            'offset' => 0
		);
        $url = env('APP_API_URL')."/article_list";
		$article_list = curl_request($url,$postdata,'GET');
        $data['article_list'] = $article_list['data']['list'];
        
        //商品列表
        $postdata = array(
            'limit'  => 10,
            'offset' => 0
		);
        $url = env('APP_API_URL')."/goods_list";
		$goods_list = curl_request($url,$postdata,'GET');
        $data['goods_list'] = $goods_list['data']['list'];
        
        return view('weixin.index.index',$data);
    }
	
    //分类
    public function category()
	{
        $data['aaa'] = 111;
        return view('weixin.index.category',$data);
    }
    
    //标签详情页，共有3种显示方式，1正常列表，2列表显示文章，3显示描述
	public function tag($tag, $page=0)
	{
        $pagenow = $page;
        
		if(empty($tag) || !preg_match('/[0-9]+/',$tag)){return redirect()->route('page404');}
        
		$post = object_to_array(DB::table('tagindex')->where('id',$tag)->first(), 1);
        $data['post'] = $post;
		
		$counts=DB::table("taglist")->where('tid',$tag)->count('aid');
		if($counts>sysconfig('CMS_MAXARC')){$counts=sysconfig('CMS_MAXARC');}
		$pagesize=sysconfig('CMS_PAGESIZE');$page=0;
		if($counts % $pagesize){//取总数据量除以每页数的余数
		$pages = intval($counts/$pagesize) + 1; //如果有余数，则页数等于总数据量除以每页数的结果取整再加一,如果没有余数，则页数等于总数据量除以每页数的结果
		}else{$pages = $counts/$pagesize;}
		if(!empty($pagenow)){if($pagenow==1 || $pagenow>$pages){return redirect()->route('page404');}$page = $pagenow-1;$nextpage=$pagenow+1;$previouspage=$pagenow-1;}else{$page = 0;$nextpage=2;$previouspage=0;}
		$data['page'] = $page;
		$data['pages'] = $pages;
		$data['counts'] = $counts;
		$start=$page*$pagesize;
		
		$posts=object_to_array(DB::table("taglist")->where('tid',$tag)->orderBy('aid', 'desc')->skip($start)->take($pagesize)->get());
		foreach($posts as $row)
		{
			$aid[] = $row["aid"];
		}
		$aid = isset($aid)?implode(',',$aid):"";
		
        if($aid!="")
        {
            if($post['template']=='tag2')
            {
                $data['posts'] = arclist(array("sql"=>"id in ($aid)","orderby"=>['id', 'desc'],"row"=>"$pagesize","field"=>"title,body")); //获取列表
            }
            else
            {
                $data['posts'] = arclist(array("sql"=>"id in ($aid)","orderby"=>['id', 'desc'],"row"=>"$pagesize")); //获取列表
            }
        }
		else
        {
            $data['posts'] = ''; //获取列表
        }
        
		$data['pagenav'] = get_listnav(array("counts"=>$counts,"pagesize"=>$pagesize,"pagenow"=>$page+1,"catid"=>$tag,"urltype"=>"tag")); //获取分页列表
		
        if($post['template']=='tag2' || $post['template']=='tag3'){if(!empty($pagenow)){return redirect()->route('page404');}}
		
		return view('weixin.index.'.$post['template'], $data);
    }
    
	//标签页
    public function tags()
	{
		return view('weixin.index.tags');
    }
    
    //搜索页
	public function search()
	{
		return view('weixin.index.search');
    }
    
    //单页面
    public function page($id)
	{
		$data = [];
		
        if(!empty($id) && preg_match('/[a-z0-9]+/',$id))
        {
            $map['filename']=$id;
            if(cache("pageid$id")){$post=cache("pageid$id");}else{$post = object_to_array(DB::table('page')->where($map)->first(), 1);cache("pageid$id", $post, 2592000);cache(["pageid$id"=>$post], \Carbon\Carbon::now()->addMinutes(2592000));}
            
            if($post)
            {
                $data['post'] = $post;
            }
            else
            {
                return redirect()->route('page404');
            }
			
        }
        else
        {
            return redirect()->route('page404');
        }
		
		$data['posts'] = object_to_array(DB::table('page')->orderBy(\DB::raw('rand()'))->take(5)->get());
		
		return view('weixin.index.'.$post['template'], $data);
    }
	
	//商品列表页
    public function goodslist(Request $request)
	{
        if($request->input('typeid', '') != ''){$data['typeid'] = $request->input('typeid');}
        if($request->input('tuijian', '') != ''){$data['tuijian'] = $request->input('tuijian');}
        if($request->input('keyword', '') != ''){$data['keyword'] = $request->input('keyword');}
        if($request->input('status', '') != ''){$data['status'] = $request->input('status');}
        if($request->input('is_promote', '') != ''){$data['is_promote'] = $request->input('is_promote');}
        if($request->input('orderby', '') != ''){$data['orderby'] = $request->input('orderby');}
        if($request->input('max_price', '') != ''){$data['max_price'] = $request->input('max_price');}else{$data['max_price'] = 99999;}
        if($request->input('min_price', '') != ''){$data['min_price'] = $request->input('min_price');}else{$data['min_price'] = 0;}
        
		return view('weixin.index.goodslist', $data);
	}
    
    //商品详情页
    public function goods($id)
	{
        if(empty($id) || !preg_match('/[0-9]+/',$id)){return redirect()->route('page404');}
		
		$post = object_to_array(DB::table('goods')->where('id', $id)->first(), 1);if(empty($post)){return redirect()->route('page404');}$post['name'] = DB::table('goods_type')->where('id', $post['typeid'])->value('name');
		if($post)
        {
			$cat = $post['typeid'];
            $post['body'] = ReplaceKeyword($post['body']);
            if(!empty($post['writer'])){$post['writertitle']=$post['title'].' '.$post['writer'];}
            
			$data['post'] = $post;
            $data['pre'] = get_article_prenext(array('aid'=>$post["id"],'typeid'=>$post["typeid"],'type'=>"pre"));
        }
        else
        {
            return redirect()->route('page404');
        }
        
		$post = object_to_array(DB::table('goods_type')->where('id', $cat)->first(), 1);
        
        return view('weixin.index.'.$post['temparticle'], $data);
    }
	
	//sitemap页面
    public function sitemap()
    {
		return view('weixin.index.sitemap');
    }
	
	//404页面
	public function page404()
	{
		return view('weixin.404');
	}
	
    //测试页面
	public function test()
    {return view('weixin.index.test');
        //return base_path('resources/org');
        //$qrcode = new \SimpleSoftwareIO\QrCode\BaconQrCodeGenerator;
        //return $qrcode->size(500)->generate('Make a qrcode without Laravel!');
        //return '<img src="data:image/png;base64,'.base64_encode(\QrCode::format('png')->encoding('UTF-8')->size(200)->generate('http://www.72p.org/')).'">';
		//set_exception_handler('myException');
		//return uniqid();
		//return \App\Common\Helper::formatPrice(1.2346);
    }
}