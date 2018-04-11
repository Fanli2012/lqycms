<?php
namespace App\Http\Controllers\Home;

use App\Http\Controllers\Home\CommonController;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class IndexController extends CommonController
{
    public function __construct()
    {
        parent::__construct();
    }
	
	//首页
    public function index()
	{
        //推荐商品列表
        $postdata = array(
            'tuijian' => 1,
            'status' => 0,
            'limit'  => 6,
            'offset' => 0
		);
        $url = env('APP_API_URL')."/goods_list";
		$res = curl_request($url,$postdata,'GET');
        $data['tjlist'] = $res['data']['list'];
        
        //商品列表
        $pagesize = 15;
        $offset = 0;
        if(isset($_REQUEST['page'])){$offset = ($_REQUEST['page']-1)*$pagesize;}
        
        $postdata = array(
            'status' => 0,
            'limit'  => $pagesize,
            'offset' => $offset
		);
        $url = env('APP_API_URL')."/goods_list";
		$res = curl_request($url,$postdata,'GET');
        $data['list'] = $res['data']['list'];
        
        $data['totalpage'] = ceil($res['data']['count']/$pagesize);
        
        if(isset($_REQUEST['page_ajax']) && $_REQUEST['page_ajax']==1)
        {
    		$html = '';
            
            if($res['data']['list'])
            {
                foreach($res['data']['list'] as $k => $v)
                {
                    $html .= '<li><a href="'.route('home_goods',array('id'=>$v['id'])).'" target="_blank"><img src="'.$v['litpic'].'" alt="'.$v['title'].'">';
                    $html .= '<p class="title">'.$v['title'].'</p>';
                    $html .= '<p class="desc"><span class="price-point"><i></i>库存('.$v['goods_number'].')</span> '.$v['description'].'</p>';
                    $html .= '<div class="item-prices red"><div class="item-link">立即<br>抢购</div><div class="item-info"><div class="price"><i>¥</i><em class="J_actPrice"><span class="yen">'.ceil($v['price']).'</span></em></div>';
                    $html .= '<div class="dock"><div class="dock-price"><del class="orig-price">¥'.$v['market_price'].'</del> <span class="benefit">包邮</span></div><div class="prompt"><div class="sold-num"><em>'.$v['sale'].'</em> 件已付款</div></div></div></div></div></a></li>';
                    
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
            'pid'    => 0,
            'limit'  => 15,
            'offset' => 0
		);
        $url = env('APP_API_URL')."/goodstype_list";
		$res = curl_request($url,$postdata,'GET');
        $data['goodstype_list'] = $res['data']['list'];
        
        //banner轮播图
        $postdata = array(
            'type'   => 0,
            'limit'  => 5,
            'offset' => 0
		);
        $url = env('APP_API_URL')."/slide_list";
		$res = curl_request($url,$postdata,'GET');
        $data['slide_list'] = $res['data']['list'];
        
        return view('home.index.index',$data);
    }
	
	//商品列表页
    public function goodslist(Request $request)
	{
        $data['typeid'] = 0;
        if($request->input('typeid', null) != null){$data['typeid'] = $request->input('typeid');}
        
        $pagesize = 15;
        $offset = 0;
        if(isset($_REQUEST['page'])){$offset = ($_REQUEST['page']-1)*$pagesize;}
        
        //商品列表
        $postdata = array(
            'typeid' => $data['typeid'],
            'limit'  => $pagesize,
            'offset' => $offset
		);
        $url = env('APP_API_URL')."/goods_list";
		$res = curl_request($url,$postdata,'GET');
        $data['list'] = $res['data']['list'];
        
        $data['totalpage'] = ceil($res['data']['count']/$pagesize);
        
        if(isset($_REQUEST['page_ajax']) && $_REQUEST['page_ajax']==1)
        {
    		$html = '';
            
            if($res['data']['list'])
            {
                foreach($res['data']['list'] as $k => $v)
                {
                    $html .= '<li><a href="'.route('home_goods',array('id'=>$v['id'])).'" target="_blank"><img src="'.$v['litpic'].'" alt="'.$v['title'].'">';
                    $html .= '<p class="title">'.$v['title'].'</p>';
                    $html .= '<p class="desc"><span class="price-point"><i></i>库存('.$v['goods_number'].')</span> '.$v['description'].'</p>';
                    $html .= '<div class="item-prices red"><div class="item-link">立即<br>抢购</div><div class="item-info"><div class="price"><i>¥</i><em class="J_actPrice"><span class="yen">'.ceil($v['price']).'</span></em></div>';
                    $html .= '<div class="dock"><div class="dock-price"><del class="orig-price">¥'.$v['market_price'].'</del> <span class="benefit">包邮</span></div><div class="prompt"><div class="sold-num"><em>'.$v['sale'].'</em> 件已付款</div></div></div></div></div></a></li>';
                    
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
            'pid'    => 0,
            'limit'  => 15,
            'offset' => 0
		);
        $url = env('APP_API_URL')."/goodstype_list";
		$res = curl_request($url,$postdata,'GET');
        $data['goodstype_list'] = $res['data']['list'];
        
		return view('home.index.goodslist', $data);
	}
    
    //商品详情页
    public function goods($id)
	{
        if(empty($id) || !preg_match('/[0-9]+/',$id)){return redirect()->route('page404');}
		
		$post = object_to_array(DB::table('goods')->where(['id'=>$id,'status'=>0])->first(), 1);if(empty($post)){return redirect()->route('page404');}$post['type_name'] = DB::table('goods_type')->where('id', $post['typeid'])->value('name');
		if($post)
        {
			$data['post'] = $post;
        }
        else
        {
            return redirect()->route('page404');
        }
        
        $data['tj_list'] = object_to_array(DB::table('goods')->where(['tuijian'=>1,'status'=>0])->get());
        
        DB::table('goods')->where(array('id'=>$id))->increment('click', 1);
        return view('home.index.goods', $data);
    }
    
    //商品列表页
    public function brandList(Request $request)
	{
        $data['brand_list'] = object_to_array(DB::table('goods_brand')->where(['status'=>0])->take(30)->orderBy('listorder','asc')->get());
        
        return view('home.index.brandList', $data);
    }
    
    //网址组装
    public function listpageurl($http_host,$query_string,$page=0)
	{
        $res = '';
        foreach(explode("&",$query_string) as $row)
        {
            if($row)
            {
                $canshu = explode("=",$row);
                $res[$canshu[0]] = $canshu[1];
            }
        }
        
        if(isset($res['page']))
        {
            unset($res['page']);
        }
        
        if($page==1 || $page==0){}else{$res['page'] = $page;}
        
        if($res){$res = $http_host.'?'.http_build_query($res);}
        
        return $res;
    }
	
    //列表页
    public function category(Request $request)
	{
        $pagesize = 10;
        $offset = 0;
        
        //文章分类
        $postdata = array(
            'id'  => $cat
		);
        $url = env('APP_API_URL')."/arctype_detail";
		$arctype_detail = curl_request($url,$postdata,'GET');
        $data['post'] = $arctype_detail['data'];
        dd($data['post']);
        if(isset($_REQUEST['page'])){$offset = ($_REQUEST['page']-1)*$pagesize;}
        
        //文章列表
        $postdata2 = array(
            'limit'  => $pagesize,
            'offset' => $offset
		);
        if($request->input('typeid', null) != null){$postdata2['typeid'] = $request->input('typeid');}
        
        $url = env('APP_API_URL')."/article_list";
		$res = curl_request($url,$postdata2,'GET');
        $data['list'] = $res['data']['list'];
        
        $data['totalpage'] = ceil($res['data']['count']/$pagesize);
        
        if(isset($_REQUEST['page_ajax']) && $_REQUEST['page_ajax']==1)
        {
    		$html = '';
            
            if($res['data']['list'])
            {
                foreach($res['data']['list'] as $k => $v)
                {
                    $html .= '<li><a href="'.$v['article_detail_url'].'">'.$v['title'].'</a><p>'.$v['pubdate'].'</p></li>';
                }
            }
            
    		exit(json_encode($html));
    	}
        
		return view('home.index.'.$data['post']['templist'], $data);
	}
    
    //文章列表页
    public function arclist(Request $request)
    {
        $pagesize = 10;
        $offset = 0;
        
        //文章分类
        if($request->input('typeid', null) != null)
        {
            $postdata = array(
                'id'  => $request->input('typeid')
            );
            $url = env('APP_API_URL')."/arctype_detail";
            $arctype_detail = curl_request($url,$postdata,'GET');
            $data['post'] = $arctype_detail['data'];
        }
        
        if(isset($_REQUEST['page'])){$offset = ($_REQUEST['page']-1)*$pagesize;}
        
        //文章列表
        $postdata2 = array(
            'limit'  => $pagesize,
            'offset' => $offset
		);
        if($request->input('typeid', null) != null){$postdata2['typeid'] = $request->input('typeid');}
        
        $url = env('APP_API_URL')."/article_list";
		$res = curl_request($url,$postdata2,'GET');
        $data['list'] = $res['data']['list'];
        
        $data['totalpage'] = ceil($res['data']['count']/$pagesize);
        
        if(isset($_REQUEST['page_ajax']) && $_REQUEST['page_ajax']==1)
        {
    		$html = '';
            
            if($res['data']['list'])
            {
                foreach($res['data']['list'] as $k => $v)
                {
                    $html .= '<div class="list">';
                    if(!empty($v['litpic']))
                    {
                        $html .= '<a class="limg" href="'.get_front_url(array("id"=>$v['id'],"catid"=>$v['typeid'],"type"=>'content')).'"><img alt="'.$v['title'].'" src="'.$v['litpic'].'"></a>';
                    }
                    $html .= '<strong class="tit"><a href="'.get_front_url(array("id"=>$v['id'],"catid"=>$v['typeid'],"type"=>'content')).'">'.$v['title'].'</a></strong><p>'.mb_strcut($v['description'],0,150,'UTF-8').'..</p>';
                    $html .= '<div class="info"><span class="fl">';
                    $taglist=taglist($v['id']);
                    if($taglist)
                    {
                        foreach($taglist as $row)
                        {
                            $html .= '<a href="'.get_front_url(array("tagid"=>$row['id'],"type"=>'tags')).'">'.$row['tag'].'</a>';
                        }
                    }
                    $html .= '<em>'.date("m-d H:i",$v['pubdate']).'</em></span><span class="fr"><em>'.$v['click'].'</em>人阅读</span></div><div class="cl"></div></div>';
                }
            }
            
    		exit(json_encode($html));
    	}
        
		return view('home.index.arclist', $data);
	}
    
    //文章详情页
    public function detail($id)
	{
        if(empty($id) || !preg_match('/[0-9]+/',$id)){return redirect()->route('page404');}
		
		if(cache("detailid$id")){$post = cache("detailid$id");}else{$post = object_to_array(DB::table('article')->where('id', $id)->first(), 1);if(empty($post)){return redirect()->route('page404');}$post['name'] = DB::table('arctype')->where('id', $post['typeid'])->value('name');cache(["detailid$id"=>$post], \Carbon\Carbon::now()->addMinutes(2592000));}
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
        
		if(cache("catid$cat")){$post=cache("catid$cat");}else{$post = object_to_array(DB::table('arctype')->where('id', $cat)->first(), 1);cache(["catid$cat"=>$post], \Carbon\Carbon::now()->addMinutes(2592000));}
        
        return view('home.index.'.$post['temparticle'], $data);
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
		
		return view('home.index.'.$post['template'], $data);
    }
    
	//标签页
    public function tags()
	{
		return view('home.index.tags');
    }
    
    //搜索页
	public function search($keyword)
	{
		if(empty($keyword))
		{
			echo '请输入正确的关键词';exit;
		}
		
		if(strstr($keyword,"&")) exit;
			
		$data['posts']= object_to_array(DB::table("article")->where("title", "like", "%$keyword%")->orderBy('id', 'desc')->take(30)->get());
		$data['keyword']= $keyword;
		
		return view('home.index.search', $data);
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
		
		return view('home.index.'.$post['template'], $data);
    }
	
	//sitemap页面
    public function sitemap()
    {
		return view('home.index.sitemap');
    }
	
	//404页面
	public function page404()
	{
		return view('home.404');
	}
	
    //测试页面
	public function test()
    {return view('home.index.test');
        //return base_path('resources/org');
        //$qrcode = new \SimpleSoftwareIO\QrCode\BaconQrCodeGenerator;
        //return $qrcode->size(500)->generate('Make a qrcode without Laravel!');
        //return '<img src="data:image/png;base64,'.base64_encode(\QrCode::format('png')->encoding('UTF-8')->size(200)->generate('http://www.72p.org/')).'">';
		//set_exception_handler('myException');
		//return uniqid();
		//return \App\Common\Helper::formatPrice(1.2346);
    }
}