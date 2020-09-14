<?php
namespace App\Http\Controllers\Admin;
use DB;
use App\Common\ReturnData;
use Illuminate\Http\Request;

class CategoryController extends BaseController
{
    public function __construct()
    {
        parent::__construct();
    }
	
	public function index()
	{
		$catlist = category_tree(get_category('arctype',0));
		
		if($catlist)
		{
			foreach($catlist as $k=>$v)
			{
				$arctype = DB::table("arctype")->where('id', $v['id'])->first();
				$catlist[$k]['typedir'] = $arctype->typedir;
				$catlist[$k]['addtime'] = $arctype->addtime;
			}
		}

		$data['catlist'] = $catlist;
		return view('admin.category.index', $data);
	}
	
    public function add()
    {
        if(!empty($_GET["reid"]))
        {
            $id = $_GET["reid"];
            if(preg_match('/[0-9]*/',$id)){}else{exit;}
            if($id!=0)
            {
				$data['postone'] = object_to_array(DB::table("arctype")->where('id', $id)->first(), 1);
            }
			
            $data['id'] = $id;
        }
        else
        {
            $data['id'] = 0;
        }
        
        return view('admin.category.add', $data);
    }
    
    public function doadd()
    {
        if(!empty($_POST["prid"])){if($_POST["prid"]=="top"){$_POST['pid']=0;}else{$_POST['pid'] = $_POST["prid"];}}//父级栏目id
        $_POST['addtime'] = time();//添加时间
		unset($_POST["prid"]);
		unset($_POST["_token"]);
		if(isset($_POST['editorValue'])){unset($_POST['editorValue']);}
		
		if(DB::table('arctype')->insert($_POST))
        {
            success_jump('添加成功');
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
        $post = object_to_array(DB::table('arctype')->where('id', $id)->first(), 1);
        $reid = $post['pid'];
        if($reid!=0){$data['postone'] = object_to_array(DB::table('arctype')->where('id', $reid)->first());}
        
        $data['post'] = $post;
		
        return view('admin.category.edit', $data);
    }
    
    public function doedit()
    {
        if(!empty($_POST["id"])){$id = $_POST["id"];unset($_POST["id"]);}else {$id="";exit;}
        $_POST['addtime'] = time(); //添加时间
        unset($_POST["_token"]);
		if(isset($_POST['editorValue'])){unset($_POST['editorValue']);}
		
		if(DB::table('arctype')->where('id', $id)->update($_POST))
        {
            success_jump('修改成功', route('admin_category'));
        }
		else
		{
			error_jump('修改失败！请修改后重新添加');
		}
    }
    
    public function del()
    {
		if(!empty($_REQUEST["id"])){$id = $_REQUEST["id"];}else{error_jump('删除失败！请重新提交');} //if(preg_match('/[0-9]*/',$id)){}else{exit;}
		
		if(DB::table('arctype')->where('pid', $id)->first())
		{
			error_jump('删除失败！请先删除子栏目');
		}
		else
		{
			if(DB::table('arctype')->where('id', $id)->delete())
			{
				if(DB::table("article")->where('typeid', $id)->count()>0) //判断该分类下是否有文章，如果有把该分类下的文章也一起删除
				{
					if(DB::table("article")->where('typeid', $id)->delete())
					{
						success_jump('删除成功');
					}
					else
					{
						error_jump('栏目下的文章删除失败');
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