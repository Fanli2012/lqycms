<?php
namespace App\Http\Controllers\Home;

use App\Http\Controllers\Home\CommonController;
use Illuminate\Support\Facades\DB;

class IndexController extends CommonController
{
    public function __construct()
    {
        parent::__construct();
    }
	
	//首页
    public function index()
	{
        return view('home.index.index');
    }
	
    //列表页
    public function category($cat, $page=0)
	{
        $pagenow = $page;
        
		if(empty($cat) || !preg_match('/[0-9]+/',$cat)){return redirect()->route('page404');}
        
		if(cache("catid$cat")){$post = cache("catid$cat");}else{$post = object_to_array(DB::table('arctype')->where('id', $cat)->first(), 1);if(empty($post)){return redirect()->route('page404');} cache(["catid$cat"=>$post], \Carbon\Carbon::now()->addMinutes(2592000));}
        $data['post'] = $post;
        
		$subcat="";$sql="";
		$post2 = object_to_array(DB::table('arctype')->select('id')->where('pid', $cat)->get());
		if(!empty($post2)){foreach($post2 as $row){$subcat=$subcat."typeid=".$row["id"]." or ";}}
		$subcat=$subcat."typeid=".$cat;
		$sql=$subcat." or typeid2 in (".$cat.")";//echo $subcat2;exit;
		$data['sql'] = $sql;
		
		$counts = DB::table("article")->whereRaw($sql)->count();
		if($counts>sysconfig('CMS_MAXARC')){$counts=sysconfig('CMS_MAXARC');dd($counts);}
		$pagesize = sysconfig('CMS_PAGESIZE');$page=0;
		if($counts % $pagesize){//取总数据量除以每页数的余数
		$pages = intval($counts/$pagesize) + 1; //如果有余数，则页数等于总数据量除以每页数的结果取整再加一,如果没有余数，则页数等于总数据量除以每页数的结果
		}else{$pages = $counts/$pagesize;}
		if(!empty($pagenow)){if($pagenow==1 || $pagenow>$pages){return redirect()->route('page404');}$page = $pagenow-1;$nextpage=$pagenow+1;$previouspage=$pagenow-1;}else{$page = 0;$nextpage=2;$previouspage=0;}
		$data['page'] = $page;
		$data['pages'] = $pages;
		$data['counts'] = $counts;
		$start = $page*$pagesize;
		
		$data['posts'] = arclist(array("sql"=>$sql, "limit"=>"$start,$pagesize")); //获取列表
		$data['pagenav'] = get_listnav(array("counts"=>$counts,"pagesize"=>$pagesize,"pagenow"=>$page+1,"catid"=>$cat)); //获取分页列表
        
        if($post['templist']=='category2'){if(!empty($pagenow)){return redirect()->route('page404');}}
        
		return view('home.index.'.$post['templist'], $data);
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
	
	//商品列表页
    public function productcat($cat, $page=0)
	{
        $pagenow = $page;
        
		if(empty($cat) || !preg_match('/[0-9]+/',$cat)){return redirect()->route('page404');}
        
		$post = object_to_array(DB::table('product_type')->where('id', $cat)->first(), 1);if(empty($post)){return redirect()->route('page404');}
        $data['post'] = $post;
        
		$subcat="";
		$post2 = object_to_array(DB::table('product_type')->select('id')->where('pid', $cat)->get());
		if(!empty($post2)){foreach($post2 as $row){$subcat=$subcat."typeid=".$row["id"]." or ";}}
		$subcat=$subcat."typeid=".$cat;
		$data['sql'] = $subcat;
		
		$counts = DB::table("product")->whereRaw($subcat)->count();
		if($counts>sysconfig('CMS_MAXARC')){$counts=sysconfig('CMS_MAXARC');dd($counts);}
		$pagesize = sysconfig('CMS_PAGESIZE');$page=0;
		if($counts % $pagesize){//取总数据量除以每页数的余数
		$pages = intval($counts/$pagesize) + 1; //如果有余数，则页数等于总数据量除以每页数的结果取整再加一,如果没有余数，则页数等于总数据量除以每页数的结果
		}else{$pages = $counts/$pagesize;}
		if(!empty($pagenow)){if($pagenow==1 || $pagenow>$pages){return redirect()->route('page404');}$page = $pagenow-1;$nextpage=$pagenow+1;$previouspage=$pagenow-1;}else{$page = 0;$nextpage=2;$previouspage=0;}
		$data['page'] = $page;
		$data['pages'] = $pages;
		$data['counts'] = $counts;
		$start = $page*$pagesize;
		
		$data['posts'] = arclist(array("table"=>"product","sql"=>$subcat, "limit"=>"$start,$pagesize")); //获取列表
		$data['pagenav'] = get_listnav(array("counts"=>$counts,"pagesize"=>$pagesize,"pagenow"=>$page+1,"catid"=>$cat,"urltype"=>"product")); //获取分页列表
        
        if($post['templist']=='category2'){if(!empty($pagenow)){return redirect()->route('page404');}}
        
		return view('home.index.'.$post['templist'], $data);
	}
    
    //商品详情页
    public function product($id)
	{
        if(empty($id) || !preg_match('/[0-9]+/',$id)){return redirect()->route('page404');}
		
		$post = object_to_array(DB::table('product')->where('id', $id)->first(), 1);if(empty($post)){return redirect()->route('page404');}$post['name'] = DB::table('product_type')->where('id', $post['typeid'])->value('name');
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
        
		$post = object_to_array(DB::table('product_type')->where('id', $cat)->first(), 1);
        
        return view('home.index.'.$post['temparticle'], $data);
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
    {
		//set_exception_handler('myException');
		//return uniqid();
		//return \App\Common\Helper::formatPrice(1.2346);
    }
}