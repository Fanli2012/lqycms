<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\CommonController;
use DB;

class UserController extends CommonController
{
    public function __construct()
    {
        parent::__construct();
    }
	
    public function index()
    {
        $posts = parent::pageList('admin_user');
		
        $data['posts'] = $posts;
        
        return view('admin.user.index', $data);
    }
    
    public function add()
    {
		$data['rolelist'] = object_to_array(DB::table('admin_user_role')->orderBy('listorder','desc')->get());
		
        return view('admin.user.add', $data);
    }
    
    public function doadd()
    {
		unset($_POST["_token"]);
		$_POST['pwd'] = md5($_POST['pwd']);
		if(DB::table('admin_user')->insert($_POST))
        {
            success_jump('添加成功！', route('admin_user'));
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
		$data['post'] = object_to_array(DB::table('admin_user')->where('id', $id)->first(), 1);
        $data['rolelist'] = object_to_array(DB::table('admin_user_role')->orderBy('listorder','desc')->get());
		
        return view('admin.user.edit', $data);
    }
	
	public function doedit()
    {
        if(!empty($_POST["id"])){$id = $_POST["id"];unset($_POST["id"]);}else {$id="";exit;}
        
		unset($_POST["_token"]);
		$_POST['pwd'] = md5($_POST['pwd']);
		if(DB::table('admin_user')->where('id', $id)->update($_POST))
        {
            success_jump('修改成功！', route('admin_user'));
        }
		else
		{
			error_jump('修改失败！');
		}
    }
    
	//修改密码
    /* public function doedit()
    {
		if(!empty($_POST["id"])){$id = $_POST["id"];unset($_POST["id"]);}else {$id="";exit;}
		unset($_POST["_token"]);
		
        if(!empty($_POST["username"])){$data['username'] = $map['username'] = $_POST["username"];}else{error_jump('用户名不能为空');exit;}//用户名
        if(!empty($_POST["oldpwd"])){$map['pwd'] = md5($_POST["oldpwd"]);}else{error_jump('旧密码错误');exit;}
        if($_POST["newpwd"]==$_POST["newpwd2"]){$data['pwd'] = md5($_POST["newpwd"]);}else{error_jump('密码错误');exit;}
        if($_POST["oldpwd"]==$_POST["newpwd"]){error_jump('新旧密码不能一致！');exit;}
        
        $User = object_to_array(DB::table("user")->where($map)->first(), 1);
        
        if($User)
        {
            if(DB::table('user')->where('id', $id)->update($data))
			{
				session_unset();
				session_destroy();
				success_jump('修改成功，请重新登录', route('admin_login'), 3);
			}
        }
        else
        {
            error_jump('修改失败！旧用户名或密码错误');
        }
    } */
    
    public function del()
    {
		if(!empty($_GET["id"])){$id = $_GET["id"];}else{error_jump('删除失败！请重新提交');}
		
		if(DB::table('admin_user')->whereIn("id", explode(',', $id))->delete())
        {
            success_jump('删除成功');
        }
		else
		{
			error_jump('删除失败！请重新提交');
		}
    }
}