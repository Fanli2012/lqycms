<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\CommonController;
use DB;

class ProductTypeController extends CommonController
{
    public function __construct()
    {
        parent::__construct();
    }
    
    public function index()
    {
		$data['catlist'] = category_tree(get_category('product_type',0));
        return view('admin.producttype.index', $data);
    }
    
    public function add()
    {
        if(!empty($_GET["reid"]))
        {
            $id = $_GET["reid"];
            if(preg_match('/[0-9]*/',$id)){}else{exit;}
			
            if($id!=0)
            {
				$data['postone'] = object_to_array(DB::table("product_type")->where('id', $id)->first(), 1);
            }
			
			$data['id'] = $id;
        }
        else
        {
            $data['id'] = 0;
        }
		
        return view('admin.producttype.add', $data);
    }
    
    public function doadd()
    {
        if(isset($_POST["prid"])){if($_POST["prid"]=="top"){$_POST['reid']=0;}else{$_POST['reid'] = $_POST["prid"];}unset($_POST["prid"]);}//父级栏目id
        $_POST['addtime'] = time();//添加时间
        
		unset($_POST["_token"]);
		if(isset($_POST['editorValue'])){unset($_POST['editorValue']);}
		
		if(DB::table("product_type")->insert($_POST))
        {
            success_jump('添加成功！', route('admin_producttype'));
        }
		else
		{
			error_jump('添加失败！请修改后重新添加');
		}
    }
    
    public function edit()
    {
        $id = $_GET["id"];if(preg_match('/[0-9]*/',$id)){}else{exit;}
        
        $data['id'] = $id;
        $post = object_to_array(DB::table("product_type")->where('id', $id)->first(), 1);
        $reid = $post['reid'];
        if($reid!=0){$data['postone'] = object_to_array(DB::table("product_type")->where('id', $reid)->first(), 1);}
        $data['post'] = $post;
        
        return view('admin.producttype.edit', $data);
    }
    
    public function doedit()
    {
        if(!empty($_POST["id"])){$id = $_POST["id"];unset($_POST["id"]);}else{$id="";exit;}
        $_POST['addtime'] = time();//添加时间
        
		unset($_POST["_token"]);
		if(isset($_POST['editorValue'])){unset($_POST['editorValue']);}
		
		if(DB::table("product_type")->where('id', $id)->update($_POST))
        {
            success_jump('修改成功！', route('admin_producttype'));
        }
		else
		{
			error_jump('修改失败！请修改后重新添加');
		}
    }
    
    public function del()
    {
		if(!empty($_GET["id"])){$id = $_GET["id"];}else{error_jump('删除失败！请重新提交');}
		
		if(DB::table("product_type")->where('reid', $id)->first())
		{
			error_jump('删除失败！请先删除子分类');
		}
		else
		{
			if(DB::table("product_type")->where('id', $id)->delete())
			{
				if(DB::table("product")->where('typeid', $id)->count()>0) //判断该分类下是否有商品，如果有把该分类下的商品也一起删除
				{
					if(DB::table("product")->where('typeid', $id)->delete())
					{
						success_jump('删除成功');
					}
					else
					{
						error_jump('分类下的商品删除失败！');
					}
				}
				else
				{
					success_jump('删除成功');
				}
			}
			else
			{
				error_jump('删除失败！请重新提交');
			}
		}
    }
}