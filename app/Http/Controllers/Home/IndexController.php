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
        
		if(empty($cat) || !preg_match('/[0-9]+/',$cat)){error_jump('您访问的页面不存在或已被删除！', route('page404'));}
        
		if(cache("catid$cat")){$post = cache("catid$cat");}else{$post = object_to_array(DB::table('arctype')->where('id', $cat)->first(), 1);if(empty($post)){error_jump('您访问的页面不存在或已被删除！', route('page404'));} cache(["catid$cat"=>$post], \Carbon\Carbon::now()->addMinutes(2592000));}
        $data['post'] = $post;
        
		$subcat="";$sql="";
		$post2 = object_to_array(DB::table('arctype')->select('id')->where('reid', $cat)->get());
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
		if(!empty($pagenow)){if($pagenow==1 || $pagenow>$pages){error_jump('您访问的页面不存在或已被删除！', route('page404'));}$page = $pagenow-1;$nextpage=$pagenow+1;$previouspage=$pagenow-1;}else{$page = 0;$nextpage=2;$previouspage=0;}
		$data['page'] = $page;
		$data['pages'] = $pages;
		$data['counts'] = $counts;
		$start = $page*$pagesize;
		
		$data['posts'] = arclist(array("sql"=>$sql, "limit"=>"$start,$pagesize")); //获取列表
		$data['pagenav'] = get_listnav(array("counts"=>$counts,"pagesize"=>$pagesize,"pagenow"=>$page+1,"catid"=>$cat)); //获取分页列表
        
        if($post['templist']=='category2'){if(!empty($pagenow)){error_jump('您访问的页面不存在或已被删除！', route('page404'));}}
        
		return view('home.index.'.$post['templist'], $data);
	}
    
    //文章详情页
    public function detail($id)
	{
        if(empty($id) || !preg_match('/[0-9]+/',$id)){error_jump('您访问的页面不存在或已被删除！', route('page404'));}
		
		if(cache("detailid$id")){$post = cache("detailid$id");}else{$post = object_to_array(DB::table('article')->where('id', $id)->first(), 1);if(empty($post)){error_jump('您访问的页面不存在或已被删除！', route('page404'));}$post['typename'] = DB::table('arctype')->where('id', $post['typeid'])->value('typename');cache(["detailid$id"=>$post], \Carbon\Carbon::now()->addMinutes(2592000));}
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
            error_jump('您访问的页面不存在或已被删除！', route('page404'));
        }
        
		if(cache("catid$cat")){$post=cache("catid$cat");}else{$post = object_to_array(DB::table('arctype')->where('id', $cat)->first(), 1);cache(["catid$cat"=>$post], \Carbon\Carbon::now()->addMinutes(2592000));}
        
        return view('home.index.'.$post['temparticle'], $data);
    }
	
    //标签详情页，共有3种显示方式，1正常列表，2列表显示文章，3显示描述
	public function tag($tag, $page)
	{
        $pagenow = $page;
        
		if(empty($tag) || !preg_match('/[0-9]+/',$tag)){error_jump('您访问的页面不存在或已被删除！', route('page404'));}
        
		if(cache("tagid$tag")){$post=cache("tagid$tag");}else{$post = DB::table('tagindex')->where("id=$tag")->first();cache("tagid$tag",$post,2592000);}
        $this->assign('post',$post);
		
		$counts=DB::table("taglist")->where("tid=$tag")->count('aid');
		if($counts>CMS_MAXARC){$counts=CMS_MAXARC;}
		$pagesize=CMS_PAGESIZE;$page=0;
		if($counts % $pagesize){//取总数据量除以每页数的余数
		$pages = intval($counts/$pagesize) + 1; //如果有余数，则页数等于总数据量除以每页数的结果取整再加一,如果没有余数，则页数等于总数据量除以每页数的结果
		}else{$pages = $counts/$pagesize;}
		if(!empty($pagenow)){if($pagenow==1 || $pagenow>$pages){header("HTTP/1.0 404 Not Found");error_jump('您访问的页面不存在或已被删除！', route('page404'));}$page = $pagenow-1;$nextpage=$pagenow+1;$previouspage=$pagenow-1;}else{$page = 0;$nextpage=2;$previouspage=0;}
		$this->assign('page',$page);
		$this->assign('pages',$pages);
		$this->assign('counts',$counts);
		$start=$page*$pagesize;
		
		$posts=DB::table("taglist")->where("tid=$tag")->order('aid desc')->limit("$start,$pagesize")->select();
		foreach($posts as $row)
		{
			$aid[] = $row["aid"];
		}
		$aid = isset($aid)?implode(',',$aid):"";
		
        if($aid!="")
        {
            if($post['template']=='tag2')
            {
                $this->assign('posts',arclist(array("sql"=>"id in ($aid)","orderby"=>"id desc","limit"=>"$pagesize","field"=>"title,body"))); //获取列表
            }
            else
            {
                $this->assign('posts',arclist(array("sql"=>"id in ($aid)","orderby"=>"id desc","limit"=>"$pagesize"))); //获取列表
            }
        }
		else
        {
            $this->assign('posts',""); //获取列表
        }
        
		$this->assign('pagenav',get_listnav(array("counts"=>$counts,"pagesize"=>$pagesize,"pagenow"=>$page+1,"catid"=>$tag,"urltype"=>"tag"))); //获取分页列表
		
        if($post['template']=='tag2' || $post['template']=='tag3'){if(!empty($pagenow)){error_jump('您访问的页面不存在或已被删除！', route('page404'));}}
		return $this->fetch($post['template']);
		return view('home.index.index');
    }
    
	//标签页
    public function tags()
	{
		return view('home.index.tags');
    }
    
    //搜索页
	public function search()
	{
		if(!empty($_GET["keyword"]))
		{
			$keyword = $_GET["keyword"]; //搜索的关键词
			if(strstr($keyword,"&")) exit;
			
			$map['title'] = array('LIKE',"%$keyword%");
			
            $this->assign('posts',DB::table("article")->field('body',true)->where($map)->order('id desc')->limit(30)->select());
			$this->assign('keyword',$keyword);
		}
		else
		{
			$this->error('请输入正确的关键词', '/' , 3);exit;
		}
		
		return view('home.index.search');
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
                error_jump('您访问的页面不存在或已被删除！', route('page404'));
            }
			
        }
        else
        {
            error_jump('您访问的页面不存在或已被删除！', route('page404'));
        }
		
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
    {
		return date("Y-m-d H:i:s",strtotime("2017-04"));
    }
}
