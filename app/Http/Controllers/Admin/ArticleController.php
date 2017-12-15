<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\CommonController;
use DB;
use Illuminate\Http\Request;
use App\Http\Requests\ArticleRequest;
use Validator;

class ArticleController extends CommonController
{
    public function __construct()
    {
        parent::__construct();
    }
	
	public function index()
    {
		$res = '';
		$where = function ($query) use ($res) {
			if(isset($_REQUEST["keyword"]))
			{
				$query->where('title', 'like', '%'.$_REQUEST['keyword'].'%');
			}
			
			if(isset($_REQUEST["typeid"]) && $_REQUEST["typeid"]!=0)
			{
				$query->where('typeid', $_REQUEST["typeid"]);
			}
			
			if(isset($_REQUEST["id"]))
			{
				$query->where('typeid', $_REQUEST["id"]);
			}
			
			if(isset($_REQUEST["ischeck"]))
			{
				$query->where('ischeck', $_REQUEST["ischeck"]); //未审核过的文章
			}
        };
		
        $posts = parent::pageList('article', $where);
		foreach($posts as $key=>$value)
        {
            $info = DB::table('arctype')->select('name')->where("id", $value->typeid)->first();
			$posts[$key]->name = $info->name;
			$posts[$key]->body = '';
        }
		
        $data['posts'] = $posts;
		
		return view('admin.article.index', $data);
		
        //if(!empty($_GET["id"])){$id = $_GET["id"];}else {$id="";}if(preg_match('/[0-9]*/',$id)){}else{exit;}
        
        /* if(!empty($id)){$map['typeid']=$id;}
        $Article = M("Article")->field('id')->where($map);
        $counts = $Article->count();
        
        $pagesize =CMS_PAGESIZE;$page =0;
        if($counts % $pagesize){ //取总数据量除以每页数的余数
        $pages = intval($counts/$pagesize) + 1; //如果有余数，则页数等于总数据量除以每页数的结果取整再加一,如果没有余数，则页数等于总数据量除以每页数的结果
        }else{$pages = $counts/$pagesize;}
        if(!empty($_GET["page"])){$page = $_GET["page"]-1;$nextpage=$_GET["page"]+1;$previouspage=$_GET["page"]-1;}else{$page = 0;$nextpage=2;$previouspage=0;}
        if($counts>0){if($page>$pages-1){exit;}}
        $start = $page*$pagesize;
        $Article = M("Article")->field('id,typeid,title,pubdate,click,litpic,tuijian')->where($map)->order('id desc')->limit($start,$pagesize)->select();
        
        $this->counts = $counts;
		$this->pages = $pages;
        $this->page = $page;
        $this->nextpage = $nextpage;
        $this->previouspage = $previouspage;
        $this->id = $id;
        $this->posts = $Article; */
        
        //echo '<pre>';
        //print_r($Article);
        //return $this->fetch();
    }
    
    public function add()
    {
        $validate = new ArticleRequest();
        $validator = Validator::make($_REQUEST, $validate->getSceneRules('add'), $validate->getSceneRulesMessages());
        
        if ($validator->fails())
        {
            //$validator->errors()->first();
            //$validator->errors()->all();
            error_jump('参数错误');
        }
        
		$data = '';
		if(!empty($_REQUEST["catid"])){$data['catid'] = $_REQUEST["catid"];}else{$data['catid'] = 0;}
		
        return view('admin.article.add', $data);
    }
    
    public function doadd()
    {
        $litpic="";if(!empty($_POST["litpic"])){$litpic = $_POST["litpic"];}else{$_POST['litpic']="";} //缩略图
        if(empty($_POST["description"])){if(!empty($_POST["body"])){$_POST['description']=cut_str($_POST["body"]);}} //description
        $content="";if(!empty($_POST["body"])){$content = $_POST["body"];}
        $_POST['pubdate'] = time();//更新时间
        $_POST['addtime'] = time();//添加时间
		$_POST['user_id'] = $_SESSION['admin_user_info']['id']; // 发布者id
        
		//关键词
        if(!empty($_POST["keywords"]))
		{
			$_POST['keywords']=str_replace("，",",",$_POST["keywords"]);
		}
		else
		{
			if(!empty($_POST["title"]))
			{
				$title=$_POST["title"];
				$title=str_replace("，","",$title);
				$title=str_replace(",","",$title);
				$_POST['keywords']=get_keywords($title);//标题分词
			}
		}
		
		if(isset($_POST["dellink"]) && $_POST["dellink"]==1 && !empty($content)){$content=replacelinks($content,array(sysconfig('CMS_BASEHOST')));} //删除非站内链接
		$_POST['body']=$content;
		
		//提取第一个图片为缩略图
		if(isset($_POST["autolitpic"]) && $_POST["autolitpic"] && empty($litpic))
		{
			if(getfirstpic($content))
			{
				//获取文章内容的第一张图片
				$imagepath = '.'.getfirstpic($content);
				
				//获取后缀名
				preg_match_all ("/\/(.+)\.(gif|jpg|jpeg|bmp|png)$/iU",$imagepath,$out, PREG_PATTERN_ORDER);
				
				$saveimage='./uploads/'.date('Y/m',time()).'/'.basename($imagepath,'.'.$out[2][0]).'-lp.'.$out[2][0];
				
				//生成缩略图，按照原图的比例生成一个最大为240*180的缩略图
				\Intervention\Image\Facades\Image::make($imagepath)->resize(sysconfig('CMS_IMGWIDTH'), sysconfig('CMS_IMGHEIGHT'))->save($saveimage);
				
				//缩略图路径
				$_POST['litpic']='/uploads/'.date('Y/m',time()).'/'.basename($imagepath,'.'.$out[2][0]).'-lp.'.$out[2][0];
			}
		}
		
		unset($_POST["dellink"]);
		unset($_POST["autolitpic"]);
		unset($_POST["_token"]);
        if(isset($_POST['editorValue'])){unset($_POST['editorValue']);}
		if(DB::table('article')->insert($_POST))
        {
			success_jump("添加成功！");
        }
		else
		{
			error_jump("添加失败！请修改后重新添加");
		}
    }
    
    public function edit()
    {
        if(!empty($_GET["id"])){$id = $_GET["id"];}else {$id="";}if(preg_match('/[0-9]*/',$id)){}else{exit;}
        
		$data['id'] = $id;
		$data['post'] = object_to_array(DB::table('article')->where('id', $id)->first(), 1);
        
        return view('admin.article.edit', $data);
    }
    
    public function doedit()
    {
        if(!empty($_POST["id"])){$id = $_POST["id"];unset($_POST["id"]);}else{$id="";exit;}
        $litpic="";if(!empty($_POST["litpic"])){$litpic = $_POST["litpic"];}else{$_POST['litpic']="";} //缩略图
        if(empty($_POST["description"])){if(!empty($_POST["body"])){$_POST['description']=cut_str($_POST["body"]);}} //description
        $content="";if(!empty($_POST["body"])){$content = $_POST["body"];}
        $_POST['pubdate'] = time();//更新时间
        $_POST['user_id'] = $_SESSION['admin_user_info']['id']; // 修改者id
        
		if(!empty($_POST["keywords"]))
		{
			$_POST['keywords']=str_replace("，",",",$_POST["keywords"]);
		}
		else
		{
			if(!empty($_POST["title"]))
			{
				$title=$_POST["title"];
				$title=str_replace("，","",$title);
				$title=str_replace(",","",$title);
				$_POST['keywords']=get_keywords($title);//标题分词
			}
		}
		
		if(isset($_POST["dellink"]) && $_POST["dellink"]==1 && !empty($content)){$content=replacelinks($content,array(CMS_BASEHOST));} //删除非站内链接
		$_POST['body']=$content;
		
		//提取第一个图片为缩略图
		if(isset($_POST["autolitpic"]) && $_POST["autolitpic"] && empty($litpic))
		{
			if(getfirstpic($content))
			{
				//获取文章内容的第一张图片
				$imagepath = '.'.getfirstpic($content);
				
				//获取后缀名
				preg_match_all ("/\/(.+)\.(gif|jpg|jpeg|bmp|png)$/iU",$imagepath,$out, PREG_PATTERN_ORDER);
				
				$saveimage='./uploads/'.date('Y/m',time()).'/'.basename($imagepath,'.'.$out[2][0]).'-lp.'.$out[2][0];
				
				//生成缩略图，按照原图的比例生成一个最大为240*180的缩略图
				\Intervention\Image\Facades\Image::make($imagepath)->resize(sysconfig('CMS_IMGWIDTH'), sysconfig('CMS_IMGHEIGHT'))->save($saveimage);
				
				//缩略图路径
				$_POST['litpic']='/uploads/'.date('Y/m',time()).'/'.basename($imagepath,'.'.$out[2][0]).'-lp.'.$out[2][0];
			}
		}
		
		unset($_POST["dellink"]);
		unset($_POST["autolitpic"]);
		unset($_POST["_token"]);
        if(isset($_POST['editorValue'])){unset($_POST['editorValue']);}
        if(DB::table('article')->where('id', $id)->update($_POST))
        {
            success_jump("修改成功！", route('admin_article'));
        }
		else
		{
			error_jump("修改失败！");
		}
    }
    
	//删除文章
    public function del()
    {
		if(!empty($_GET["id"])){$id = $_GET["id"];}else{error_jump("删除失败！请重新提交");}
		
		if(DB::table("article")->whereIn("id", explode(',', $id))->delete())
        {
            success_jump("$id ,删除成功");
        }
		else
		{
			error_jump("$id ,删除失败！请重新提交");
		}
    }
    
	
	//重复文章列表
    public function repetarc()
    {
		$data['posts'] = object_to_array(DB::table('article')->select(DB::raw('title,count(*) AS count'))->orderBy('count', 'desc')->groupBy('title')->having('count', '>', 1)->get());
		
        return view('admin.article.repetarc', $data);
    }
	
	//推荐文章
	public function recommendarc()
    {
		if(!empty($_GET["id"])){$id = $_GET["id"];}else{error_jump("您访问的页面不存在或已被删除！");} //if(preg_match('/[0-9]*/',$id)){}else{exit;}
		
		$data['tuijian'] = 1;
		
        if(DB::table("article")->whereIn("id", explode(',', $id))->update($data))
        {
			success_jump("$id ,推荐成功");
        }
		else
		{
			error_jump("$id ,推荐失败！请重新提交");
		}
    }
    
	//检测重复文章数量
    public function articleexists()
    {
		$res = '';
		$where = function ($query) use ($res) {
			if(isset($_REQUEST["title"]))
			{
				$query->where('title', $_REQUEST["title"]);
			}
			
			if(isset($_REQUEST["id"]))
			{
				$query->where('id', '<>', $_REQUEST["id"]);
			}
        };
		
        return DB::table("article")->where($where)->count();
    }
}
