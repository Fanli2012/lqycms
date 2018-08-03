<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\CommonController;
use DB;

class SysconfigController extends CommonController
{
    public function __construct()
    {
        parent::__construct();
    }
	
    public function index()
    {
		$data['posts'] = parent::pageList('sysconfig', '', ['id', 'desc']);
        return view('admin.sysconfig.index', $data);
    }
    
	//添加参数，视图
    public function add()
    {
        return view('admin.sysconfig.add');
    }
    
    public function doadd()
    {
        //参数名称
        if(!empty($_POST["varname"]))
        {
			if(!preg_match("/^CMS_[a-z]+$/i", $_POST["varname"]))
			{
				error_jump('添加失败！参数名称不正确');exit;
			}
        }
        else
        {
            error_jump('添加失败！参数名称不能为空');exit;
        }
		
		unset($_POST["_token"]);
		if($_POST['varname']!="" && DB::table('sysconfig')->insert($_POST))
        {
			cache()->forget('sysconfig'); //删除缓存
            success_jump('添加成功', route('admin_sysconfig'));
        }
		else
		{
			error_jump('添加失败！请修改后重新添加');
		}
    }
    
	//修改参数，视图
    public function edit()
    {
        if(!empty($_REQUEST["id"])){$id = $_REQUEST["id"];}else{$id="";}
        if(preg_match('/[0-9]*/',$id)){}else{exit;}
        
		$data['id'] = $id;
		$data['post'] = object_to_array(DB::table('sysconfig')->where('id', $id)->first(), 1);
		
        return view('admin.sysconfig.edit', $data);
    }
    
    public function doedit()
    {
        if(isset($_POST["id"]) && !empty($_POST["id"])){$id = $_POST["id"];unset($_POST["id"]);}else{$id="";exit;}
        
        //参数名称
        if(!empty($_POST["varname"]))
        {
            if(!preg_match("/^CMS_[a-z]+$/i", $_POST["varname"]))
			{
				error_jump('更新失败！参数名称不正确');exit;
			}
        }
        else
        {
            error_jump('更新失败！参数名称不能为空');exit;
        }
		
		unset($_POST["_token"]);
		if(DB::table('sysconfig')->where('id', $id)->update($_POST))
        {
            cache()->forget('sysconfig'); //删除缓存
            success_jump('更新成功', route('admin_sysconfig'));
        }
		else
		{
			error_jump('更新失败！请修改后重新提交');
		}
    }
    
    public function del()
    {
		if(!empty($_REQUEST["id"])){$id = $_REQUEST["id"];}else{error_jump('删除失败！请重新提交');}
		
		if(DB::table("sysconfig")->whereIn("id", explode(',', $id))->delete())
        {
            success_jump('删除成功');
        }
		else
		{
			error_jump('删除失败！请重新提交');
		}
    }
}