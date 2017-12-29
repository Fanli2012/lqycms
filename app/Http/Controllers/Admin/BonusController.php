<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\CommonController;
use DB;
use App\Http\Model\Bonus;
use App\Common\Helper;

class BonusController extends CommonController
{
    public function __construct()
    {
        parent::__construct();
    }
    
    public function index()
    {
        $data['posts'] = parent::pageList('bonus', '', [['status', 'asc']]);
		
        if($data['posts'])
        {
            foreach($data['posts'] as $k=>$v)
            {
                
            }
        }
        
		return view('admin.bonus.index', $data);
    }
    
    public function add()
    {
        if(Helper::isPostRequest())
        {
            if(isset($_POST['editorValue'])){unset($_POST['editorValue']);}
            unset($_POST["_token"]);
            
            if($_POST["start_time"]>=$_POST["end_time"]){error_jump('参数错误');}
            
            if(DB::table('bonus')->insert(array_filter($_POST)))
            {
                success_jump('添加成功！', route('admin_bonus'));
            }
            else
            {
                error_jump('添加失败！请修改后重新添加');
            }
        }
        
        return view('admin.bonus.add');
    }
    
    public function edit()
    {
        if(Helper::isPostRequest())
        {
            if(!empty($_POST["id"])){$id = $_POST["id"];unset($_POST["id"]);}else{$id="";exit;}
        
            if(isset($_POST['editorValue'])){unset($_POST['editorValue']);}
            unset($_POST["_token"]);
            
            if($_POST["start_time"]>=$_POST["end_time"]){error_jump('参数错误');}
            
            if(DB::table('bonus')->where('id', $id)->update($_POST))
            {
                success_jump('修改成功！', route('admin_bonus'));
            }
            else
            {
                error_jump('修改失败！');
            }
        }
        
        if(!empty($_GET["id"])){$id = $_GET["id"];}else{$id="";}
        if(preg_match('/[0-9]*/',$id)){}else{exit;}
        
        $data['id'] = $id;
		$data['post'] = object_to_array(DB::table('bonus')->where('id', $id)->first(), 1);
        
        return view('admin.bonus.edit', $data);
    }
    
    public function del()
    {
		if(!empty($_GET["id"])){$id = $_GET["id"];}else{error_jump('删除失败！请重新提交');}
		
		if(DB::table('bonus')->whereIn("id", explode(',', $id))->delete())
        {
            success_jump('删除成功');
        }
		else
		{
			error_jump('删除失败！请重新提交');
		}
    }
}