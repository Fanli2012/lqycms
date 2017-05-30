<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\CommonController;
use DB;

class PageController extends CommonController
{
    public function __construct()
    {
        parent::__construct();
    }
	
    public function index()
    {
		$data['posts'] = object_to_array(DB::table("page")->orderBy('id', 'desc')->get());
        return view('admin.page.index', $data);
    }
    
    public function doadd()
    {
        $_POST['pubdate'] = time();//更新时间
        $_POST['click'] = rand(200,500);//点击
        
		unset($_POST["_token"]);
        if(isset($_POST['editorValue'])){unset($_POST['editorValue']);}
		
        if(DB::table("page")->insert($_POST))
        {
            success_jump('添加成功！');
        }
		else
		{
			error_jump('添加失败！请修改后重新添加');
		}
    }
    
    public function add()
    {
        return view('admin.page.add');
    }
    
    public function edit()
    {
        if(!empty($_GET["id"])){$id = $_GET["id"];}else{$id="";}
        if(preg_match('/[0-9]*/',$id)){}else{exit;}
        
        $data['id'] = $id;
		$data['post'] = object_to_array(DB::table('page')->where('id', $id)->first(), 1);
		
        return view('admin.page.edit', $data);
    }
    
    public function doedit()
    {
        if(!empty($_POST["id"])){$id = $_POST["id"];unset($_POST["id"]);}else {$id="";exit;}
        $_POST['pubdate'] = time();//更新时间
        
		unset($_POST["_token"]);
        if(isset($_POST['editorValue'])){unset($_POST['editorValue']);}
		
        if(DB::table('page')->where('id', $id)->update($_POST))
        {
            success_jump('修改成功！', route('admin_page'));
        }
		else
		{
			error_jump('修改失败！请修改后重新添加');
		}
    }
    
    public function del()
    {
		if(!empty($_GET["id"])){$id = $_GET["id"];}else{error_jump("删除失败！请重新提交");} //if(preg_match('/[0-9]*/',$id)){}else{exit;}
		
		if(DB::table('page')->whereIn("id", explode(',', $id))->delete())
        {
            success_jump('删除成功');
        }
		else
		{
			error_jump("删除失败！请重新提交");
		}
    }
}