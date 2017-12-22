<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\CommonController;
use DB;
use App\Http\Model\Kuaidi;
use App\Common\Helper;

class KuaidiController extends CommonController
{
    public function __construct()
    {
        parent::__construct();
    }
    
    public function index()
    {
        $data['posts'] = parent::pageList('kuaidi', '', [['status', 'asc'], ['listorder', 'asc']]);
		
        if($data['posts'])
        {
            foreach($data['posts'] as $k=>$v)
            {
                $data['posts'][$k]->status_text = Kuaidi::getStatusText(array('status'=>$v->status));
            }
        }
        
		return view('admin.kuaidi.index', $data);
    }
    
    public function add()
    {
        if(Helper::isPostRequest())
        {
            if(isset($_POST['editorValue'])){unset($_POST['editorValue']);}
            unset($_POST["_token"]);
            
            if(DB::table('kuaidi')->insert(array_filter($_POST)))
            {
                success_jump('添加成功！', route('admin_kuaidi'));
            }
            else
            {
                error_jump('添加失败！请修改后重新添加');
            }
        }
        
        return view('admin.kuaidi.add');
    }
    
    public function edit()
    {
        if(Helper::isPostRequest())
        {
            if(!empty($_POST["id"])){$id = $_POST["id"];unset($_POST["id"]);}else{$id="";exit;}
        
            if(isset($_POST['editorValue'])){unset($_POST['editorValue']);}
            unset($_POST["_token"]);
            
            if(DB::table('kuaidi')->where('id', $id)->update($_POST))
            {
                success_jump('修改成功！', route('admin_kuaidi'));
            }
            else
            {
                error_jump('修改失败！');
            }
        }
        
        if(!empty($_GET["id"])){$id = $_GET["id"];}else{$id="";}
        if(preg_match('/[0-9]*/',$id)){}else{exit;}
        
        $data['id'] = $id;
		$data['post'] = object_to_array(DB::table('kuaidi')->where('id', $id)->first(), 1);
        
        return view('admin.kuaidi.edit', $data);
    }
    
    public function del()
    {
		if(!empty($_GET["id"])){$id = $_GET["id"];}else{error_jump('删除失败！请重新提交');}
		
		if(DB::table('kuaidi')->whereIn("id", explode(',', $id))->delete())
        {
            success_jump('删除成功');
        }
		else
		{
			error_jump('删除失败！请重新提交');
		}
    }
}