<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\CommonController;
use DB;
use App\Http\Model\UserRank;
use App\Common\Helper;

class UserRankController extends BaseController
{
    public function __construct()
    {
        parent::__construct();
    }
    
    public function index()
    {
        $data['posts'] = parent::pageList('user_rank', '', [['listorder', 'asc']]);
		
        if($data['posts'])
        {
            foreach($data['posts'] as $k=>$v)
            {
                
            }
        }
        
		return view('admin.userrank.index', $data);
    }
    
    public function add()
    {
        if(Helper::isPostRequest())
        {
            if(isset($_POST['editorValue'])){unset($_POST['editorValue']);}
            unset($_POST["_token"]);
            
            if(DB::table('user_rank')->where('rank', $_POST["rank"])->first()){error_jump('等级已经存在');}
            if(DB::table('user_rank')->where('title', $_POST["title"])->first()){error_jump('等级名称已经存在');}
            
            if(DB::table('user_rank')->insert(array_filter($_POST)))
            {
                success_jump('添加成功', route('admin_userrank'));
            }
            else
            {
                error_jump('添加失败！请修改后重新添加');
            }
        }
        
        return view('admin.userrank.add');
    }
    
    public function edit()
    {
        if(Helper::isPostRequest())
        {
            if(!empty($_POST["id"])){$id = $_POST["id"];unset($_POST["id"]);}else{$id="";exit;}
        
            if(isset($_POST['editorValue'])){unset($_POST['editorValue']);}
            unset($_POST["_token"]);
            
            if(DB::table('user_rank')->where(['rank'=>$_POST["rank"],'id'=>['<>',$id]])->first()){error_jump('等级已经存在');}
            if(DB::table('user_rank')->where(['title'=>$_POST["title"],'id'=>['<>',$id]])->first()){error_jump('等级名称已经存在');}
            
            if(DB::table('user_rank')->where('id', $id)->update($_POST) !== false)
            {
                success_jump('修改成功', route('admin_userrank'));
            }
            else
            {
                error_jump('修改失败');
            }
        }
        
        if(!empty($_GET["id"])){$id = $_GET["id"];}else{$id="";}
        if(preg_match('/[0-9]*/',$id)){}else{exit;}
        
        $data['id'] = $id;
		$data['post'] = object_to_array(DB::table('user_rank')->where('id', $id)->first(), 1);
        
        return view('admin.userrank.edit', $data);
    }
    
    public function del()
    {
		if(!empty($_GET["id"])){$id = $_GET["id"];}else{error_jump('删除失败！请重新提交');}
		
		if(DB::table('user_rank')->whereIn("id", explode(',', $id))->delete())
        {
            success_jump('删除成功');
        }
		else
		{
			error_jump('删除失败！请重新提交');
		}
    }
}