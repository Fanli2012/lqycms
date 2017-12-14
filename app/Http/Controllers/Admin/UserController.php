<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\CommonController;
use DB;
use App\Http\Model\User;

class UserController extends CommonController
{
    public function __construct()
    {
        parent::__construct();
    }
	
    public function index()
    {
        $posts = parent::pageList('user');
		
        if($posts)
        {
            foreach($posts as $k=>$v)
            {
                $posts[$k]->sex_text = User::getSexText(['sex'=>$v->sex]);
                $posts[$k]->status_text = User::getStatusText(['status'=>$v->status]);
            }
        }
        
        $data['posts'] = $posts;
        return view('admin.user.index', $data);
    }
    
    //会员账户记录
    public function money()
    {
        $where = '';
        if(isset($_REQUEST["user_id"]))
        {
            $where['user_id'] = $_REQUEST["user_id"];
        }
        
        $posts = parent::pageList('user_money',$where);
		
        if($posts)
        {
            foreach($posts as $k=>$v)
            {
                $posts[$k]->user = DB::table('user')->where('id', $v->user_id)->first();
            }
        }
        
        $data['posts'] = $posts;
        return view('admin.user.money', $data);
    }
    
    public function add()
    {
        return view('admin.user.add');
    }
    
    public function doadd()
    {
		unset($_POST["_token"]);
        if(DB::table('user')->insert($_POST))
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
		$data['post'] = object_to_array(DB::table('user')->where('id', $id)->first(), 1);
        
        return view('admin.user.edit', $data);
    }
	
	public function doedit()
    {
        if(!empty($_POST["id"])){$id = $_POST["id"];unset($_POST["id"]);}else {$id="";exit;}
        
		unset($_POST["_token"]);
		if(DB::table('user')->where('id', $id)->update($_POST))
        {
            success_jump('修改成功！', route('admin_user'));
        }
		else
		{
			error_jump('修改失败！');
		}
    }
    
    public function del()
    {
        if(!empty($_GET["id"])){$id = $_GET["id"];}else{error_jump('删除失败！请重新提交');}
		
		if(DB::table('user')->whereIn("id", explode(',', $id))->update(['status' => 2]))
        {
            success_jump('删除成功');
        }
		else
		{
			error_jump('删除失败！请重新提交');
		}
    }
}