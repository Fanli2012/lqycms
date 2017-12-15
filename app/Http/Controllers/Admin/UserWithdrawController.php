<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\CommonController;
use DB;
use App\Http\Model\UserWithdraw;
use App\Common\ReturnData;

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
    
    public function changeStatus()
    {
        if(!empty($_POST["id"])){$id = $_POST["id"];unset($_POST["id"]);}else {$id="";exit;}
        
		unset($_POST["_token"]);
        
        if(!isset($_POST["type"])){return ReturnData::create(ReturnData::PARAMS_ERROR);}
        
        $user_withdraw = DB::table('user_withdraw')->where(['id'=>$id,'status'=>0])->first();
        if(!$user_withdraw){return ReturnData::create(ReturnData::PARAMS_ERROR);}
        
        //0拒绝，1成功
        if($_POST["type"]==0)
        {
            $data['status'] = 4;
            
            
        }
        elseif($_POST["type"]==1)
        {
            $data['status'] = 2;
        }
        
        if(!isset($data)){$res = DB::table('user_withdraw')->where('id', $id)->update($data);}
        
        if(!isset($res)){return ReturnData::create(ReturnData::SYSTEM_FAIL);}
        
		return ReturnData::create(ReturnData::SUCCESS);
    }
}