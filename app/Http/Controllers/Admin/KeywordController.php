<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\CommonController;
use DB;

class KeywordController extends CommonController
{
	public function __construct()
    {
        parent::__construct();
    }
    
    public function index()
    {
		$data['posts'] = parent::pageList('keyword');
		
		return view('admin.keyword.index', $data);
    }
    
    public function add()
    {
        return view('admin.keyword.add');
    }
    
    public function doadd()
    {
		unset($_POST["_token"]);
        if(DB::table('keyword')->insert($_POST))
        {
            success_jump("添加成功", route('admin_keyword'));
        }
		else
		{
			error_jump('添加失败！请修改后重新添加');
		}
    }
    
    public function edit()
    {
        if(!empty($_GET["id"])){$id = $_GET["id"];}else{$id="";}
        if(preg_match('/[0-9]*/',$id)){}else{exit;}
        
        $data['id'] = $id;
		$data['post'] = object_to_array(DB::table('keyword')->where('id', $id)->first(), 1);
        
        return view('admin.keyword.edit', $data);
    }
    
    public function doedit()
    {
        if(!empty($_POST["id"])){$id = $_POST["id"];unset($_POST["id"]);}else {$id="";exit;}
		
		unset($_POST["_token"]);
		if(DB::table('keyword')->where('id', $id)->update($_POST))
        {
            success_jump('修改成功', route('admin_keyword'));
        }
		else
		{
			error_jump('修改失败');
		}
    }
    
    public function del()
    {
		if(!empty($_GET["id"])){$id = $_GET["id"];}else{error_jump('删除失败！请重新提交');}
		
		if(DB::table("keyword")->whereIn("id", explode(',', $id))->delete())
        {
            success_jump('删除成功');
        }
		else
		{
			error_jump('删除失败！请重新提交');
		}
    }
}