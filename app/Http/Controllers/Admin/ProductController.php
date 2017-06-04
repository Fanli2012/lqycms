<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\CommonController;
use DB;

class ProductController extends CommonController
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
        };
		
		$posts = parent::pageList('product', $where);
		foreach($posts as $key=>$value)
        {
            $info = DB::table('product_type')->select('typename')->where("id", $value->typeid)->first();
			$posts[$key]->typename = $info->typename;
			$posts[$key]->body = '';
        }
		
        $data['posts'] = $posts;
		
		return view('admin.product.index', $data);
    }
    
    public function add()
    {
		$data = [];
		if(!empty($_GET["catid"])){$data['catid'] = $_GET["catid"];}else{$data['catid'] = 0;}
		
        return view('admin.product.add', $data);
    }
    
    public function doadd()
    {
        $litpic="";if(!empty($_POST["litpic"])){$litpic = $_POST["litpic"];}else{$_POST['litpic']="";} //缩略图
        if(empty($_POST["description"])){if(!empty($_POST["body"])){$_POST['description']=cut_str($_POST["body"]);}} //description
        $_POST['addtime'] = $_POST['pubdate'] = time(); //添加&更新时间
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
		
		unset($_POST["_token"]);
		if(isset($_POST['editorValue'])){unset($_POST['editorValue']);}
		
		if(DB::table('product')->insert(array_filter($_POST)))
        {
            success_jump('添加成功！', route('admin_product'));
        }
		else
		{
			error_jump('添加失败！请修改后重新添加');
		}
    }
    
    public function edit()
    {
        if(!empty($_GET["id"])){$id = $_GET["id"];}else {$id="";}if(preg_match('/[0-9]*/',$id)){}else{exit;}
        
        $data['id'] = $id;
		$data['post'] = object_to_array(DB::table('product')->where('id', $id)->first(), 1);
        
        return view('admin.product.edit', $data);
    }
    
    public function doedit()
    {
        if(!empty($_POST["id"])){$id = $_POST["id"];}else {$id="";exit;}
        
        $litpic="";if(!empty($_POST["litpic"])){$litpic = $_POST["litpic"];}else{$_POST['litpic']="";} //缩略图
        if(empty($_POST["description"])){if(!empty($_POST["body"])){$_POST['description']=cut_str($_POST["body"]);}}//description
        $_POST['pubdate'] = time();//更新时间
        $_POST['user_id'] = $_SESSION['admin_user_info']['id']; // 修改者id
		
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
		
		unset($_POST["_token"]);
        if(isset($_POST['editorValue'])){unset($_POST['editorValue']);}
		
        if(DB::table('product')->where('id', $id)->update($_POST))
        {
            success_jump('修改成功！', route('admin_product'));
        }
		else
		{
			error_jump('修改失败！');
		}
    }
    
    public function del()
    {
		if(!empty($_GET["id"])){$id = $_GET["id"];}else{error_jump('删除失败！请重新提交');}
		
		if(DB::table('product')->whereIn("id", explode(',', $id))->delete())
        {
            success_jump("$id ,删除成功");
        }
		else
		{
			error_jump("$id ,删除失败！请重新提交");
		}
    }
    
	//商品推荐
	public function recommendarc()
    {
		if(!empty($_GET["id"])){$id = $_GET["id"];}else{error_jump('删除失败！请重新提交');}
		
		$data['tuijian'] = 1;
        if(DB::table('product')->whereIn("id", explode(',', $id))->update($data))
        {
            success_jump("$id ,推荐成功");
        }
		else
		{
			error_jump("$id ,推荐失败！请重新提交");
		}
    }
    
	//商品是否存在
    public function productexists()
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
		
		return DB::table("product")->where($where)->count();
    }
}