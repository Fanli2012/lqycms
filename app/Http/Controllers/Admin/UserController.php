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
        return view('admin.user.index');
    }
    
    public function edit()
    {
		$data['post'] = object_to_array(DB::table('user')->where('id', 1)->first(), 1);
        
        return view('admin.user.edit', $data);
    }
    
    public function doedit()
    {
        if(!empty($_POST["username"])){$data['username'] = $map['username'] = $_POST["username"];}else{error_jump('用户名不能为空');exit;}//用户名
        if(!empty($_POST["oldpwd"])){$map['pwd'] = md5($_POST["oldpwd"]);}else{error_jump('旧密码错误');exit;}
        if($_POST["newpwd"]==$_POST["newpwd2"]){$data['pwd'] = md5($_POST["newpwd"]);}else{error_jump('密码错误');exit;}
        if($_POST["oldpwd"]==$_POST["newpwd"]){error_jump('新旧密码不能一致！');exit;}
        
        $User = object_to_array(DB::table("user")->where($map)->first(), 1);
        
        if($User)
        {
            if(DB::table('user')->where('id', 1)->update($data))
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
    }
}