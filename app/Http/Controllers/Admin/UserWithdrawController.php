<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\CommonController;
use DB;
use App\Http\Model\UserWithdraw;

class UserWithdrawController extends CommonController
{
    public function __construct()
    {
        parent::__construct();
    }
	
    public function index()
    {
        $posts = parent::pageList('user_withdraw',array('is_delete'=>0));
		
        if($posts)
        {
            foreach($posts as $k=>$v)
            {
                $posts[$k]->user = DB::table('user')->where('id', $v->id)->first();
                $posts[$k]->status_text = UserWithdraw::getStatusText(['status'=>$v->status]);
            }
        }
        
        $data['posts'] = $posts;
        return view('admin.UserWithdraw.index', $data);
    }
    
    public function edit()
    {
        if(!empty($_GET["id"])){$id = $_GET["id"];}else{$id="";}
        if(preg_match('/[0-9]*/',$id)){}else{exit;}
        
        $data['id'] = $id;
		$data['post'] = object_to_array(DB::table('user_withdraw')->where('id', $id)->first(), 1);
        
        return view('admin.UserWithdraw.edit', $data);
    }
	
	public function doedit()
    {
        if(!empty($_POST["id"])){$id = $_POST["id"];unset($_POST["id"]);}else {$id="";exit;}
        
		unset($_POST["_token"]);
		if(DB::table('user_withdraw')->where('id', $id)->update($_POST))
        {
            success_jump('修改成功！', route('admin_user'));
        }
		else
		{
			error_jump('修改失败！');
		}
    }
}