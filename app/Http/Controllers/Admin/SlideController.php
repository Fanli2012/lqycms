<?php
namespace App\Http\Controllers\Admin;
use DB;
use App\Common\ReturnData;
use App\Common\Helper;
use Illuminate\Http\Request;
use App\Http\Logic\SlideLogic;
use App\Http\Model\Slide;

class SlideController extends CommonController
{
    public function __construct()
    {
        parent::__construct();
    }
    
    public function getLogic()
    {
        return new SlideLogic();
    }
    
    public function index()
    {
        $where = '';
		$posts = $this->getLogic()->getPaginate($where, array('id', 'desc'));
        
        $data['posts'] = $posts;
		return view('admin.slide.index', $data);
    }
    
    public function add()
    {
        return view('admin.slide.add');
    }
    
    public function doadd()
    {
		if(isset($_POST['editorValue'])){unset($_POST['editorValue']);}
		unset($_POST["_token"]);
		
		if(DB::table('slide')->insert(array_filter($_POST)))
        {
            success_jump('添加成功！', route('admin_slide'));
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
		$data['post'] = object_to_array(DB::table('slide')->where('id', $id)->first(), 1);
        
        return view('admin.slide.edit', $data);
    }
    
    public function doedit()
    {
        if(!empty($_POST["id"])){$id = $_POST["id"];unset($_POST["id"]);}else{$id="";exit;}
        
		if(isset($_POST['editorValue'])){unset($_POST['editorValue']);}
		unset($_POST["_token"]);
		
		if(DB::table('slide')->where('id', $id)->update($_POST))
        {
            success_jump('修改成功！', route('admin_slide'));
        }
		else
		{
			error_jump('修改失败！');
		}
    }
    
    public function del()
    {
		if(!empty($_GET["id"])){$id = $_GET["id"];}else{error_jump('删除失败！请重新提交');}
		
		if(DB::table('slide')->whereIn("id", explode(',', $id))->delete())
        {
            success_jump('删除成功');
        }
		else
		{
			error_jump('删除失败！请重新提交');
		}
    }
}