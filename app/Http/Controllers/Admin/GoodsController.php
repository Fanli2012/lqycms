<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\CommonController;
use DB;

class GoodsController extends CommonController
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
		
		$posts = parent::pageList('goods', $where);
		foreach($posts as $key=>$value)
        {
            $info = DB::table('goods_type')->select('name')->where("id", $value->typeid)->first();
			$posts[$key]->name = $info->name;
			$posts[$key]->body = '';
        }
		
        $data['posts'] = $posts;
		
		return view('admin.goods.index', $data);
    }
    
    public function add()
    {
		$data = [];
		if(!empty($_GET["catid"])){$data['catid'] = $_GET["catid"];}else{$data['catid'] = 0;}
        
		$data['goodsbrand_list'] = object_to_array(DB::table('goods_brand')->where('status', 0)->orderBy('listorder', 'asc')->get()); //商品品牌
        
        return view('admin.goods.add', $data);
    }
    
    public function doadd()
    {
        $litpic="";if(!empty($_POST["litpic"])){$litpic = $_POST["litpic"];}else{$_POST['litpic']="";} //缩略图
        if(empty($_POST["description"])){if(!empty($_POST["body"])){$_POST['description']=cut_str($_POST["body"]);}} //description
        $_POST['add_time'] = $_POST['pubdate'] = time(); //添加&更新时间
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
		if(isset($_POST['promote_start_date'])){$_POST['promote_start_date'] = strtotime($_POST['promote_start_date']);}
        if(isset($_POST['promote_end_date'])){$_POST['promote_end_date'] = strtotime($_POST['promote_end_date']);}
        if(empty($_POST['promote_price'])){unset($_POST['promote_price']);}
        if(!empty($_POST['goods_img']))
        {
            $goods_img = $_POST['goods_img'];
            $_POST['goods_img'] = $_POST['goods_img'][0];
        }
        
		if($goods_id = DB::table('goods')->insertGetId(array_filter($_POST)))
        {
            if(isset($goods_img))
            {
                $tmp = [];
                foreach($goods_img as $k=>$v)
                {
                    $tmp[] = ['url'=>$v,'goods_id'=>$goods_id,'add_time'=>time()];
                }
                
                DB::table('goods_img')->insert($tmp);
            }
            
            success_jump('添加成功', route('admin_goods'));
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
        $goods = DB::table('goods')->where('id', $id)->first();
        if($goods->promote_start_date != 0){$goods->promote_start_date = date('Y-m-d H:i:s',$goods->promote_start_date);}
        if($goods->promote_end_date != 0){$goods->promote_end_date = date('Y-m-d H:i:s',$goods->promote_end_date);}
        
		$data['post'] = object_to_array($goods, 1);
        $data['goodsbrand_list'] = object_to_array(DB::table('goods_brand')->where('status', 0)->orderBy('listorder', 'asc')->get()); //商品品牌
        $data['goods_img_list'] = object_to_array(DB::table('goods_img')->where(array('goods_id'=>$id))->orderBy('listorder', 'asc')->get()); //商品图片
        
        return view('admin.goods.edit', $data);
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
		if(isset($_POST['promote_start_date'])){$_POST['promote_start_date'] = strtotime($_POST['promote_start_date']);}
        if(isset($_POST['promote_end_date'])){$_POST['promote_end_date'] = strtotime($_POST['promote_end_date']);}
        if(empty($_POST['promote_price'])){unset($_POST['promote_price']);}
        if(!empty($_POST['goods_img']))
        {
            $goods_img = $_POST['goods_img'];
            $_POST['goods_img'] = $_POST['goods_img'][0];
        }
        
        if(DB::table('goods')->where('id', $id)->update($_POST))
        {
            if(isset($goods_img))
            {
                $tmp = [];
                foreach($goods_img as $k=>$v)
                {
                    $tmp[] = ['url'=>$v,'goods_id'=>$id,'add_time'=>time()];
                }
                
                DB::table('goods_img')->where(array('goods_id'=>$id))->delete();
                DB::table('goods_img')->insert($tmp);
            }
            
            success_jump('修改成功', route('admin_goods'));
        }
		else
		{
			error_jump('修改失败');
		}
    }
    
    public function del()
    {
		if(!empty($_GET["id"])){$id = $_GET["id"];}else{error_jump('删除失败！请重新提交');}
		
		if(DB::table('goods')->whereIn("id", explode(',', $id))->update(['status' => 1]))
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
        if(DB::table('goods')->whereIn("id", explode(',', $id))->update($data))
        {
            success_jump("$id ,推荐成功");
        }
		else
		{
			error_jump("$id ,推荐失败！请重新提交");
		}
    }
    
	//商品是否存在
    public function goodsexists()
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
		
		return DB::table("goods")->where($where)->count();
    }
}