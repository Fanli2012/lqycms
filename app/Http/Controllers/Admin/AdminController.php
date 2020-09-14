<?php
namespace App\Http\Controllers\Admin;
use DB;
use App\Common\Helper;
use App\Common\ReturnData;
use Illuminate\Http\Request;
use App\Http\Logic\AdminLogic;
use App\Http\Model\Admin;

class AdminController extends BaseController
{
    public function __construct()
    {
        parent::__construct();
    }
	
    public function getLogic()
    {
        return new AdminLogic();
    }
    
    public function index(Request $request)
    {
        $res = '';
        $where = function ($query) use ($res) {
			if(isset($_REQUEST["keyword"]))
			{
				$query->where('name', 'like', '%'.$_REQUEST['keyword'].'%');
			}
			
			if(isset($_REQUEST["role_id"]))
			{
				$query->where('role_id', $_REQUEST["role_id"]);
			}
            
            if(isset($_REQUEST["status"]))
			{
				$query->where('status', $_REQUEST["status"]);
			}
        };
        
        $posts = $this->getLogic()->getPaginate($where, array('id', 'desc'));
        $data['posts'] = $posts;
		return view('admin.admin.index', $data);
    }
    
    public function add(Request $request)
    {
		$data['rolelist'] = logic('AdminRole')->getAll('', ['listorder','asc']);
		
        return view('admin.admin.add', $data);
    }
    
    public function doadd(Request $request)
    {
        if(Helper::isPostRequest())
        {
            $_POST['pwd'] = md5($_POST['pwd']);
            
            $res = $this->getLogic()->add($_POST);
            if($res['code'] == ReturnData::SUCCESS)
            {
                success_jump($res['msg'], route('admin_admin'));
            }
            
            error_jump($res['msg']);
        }
    }
    
    public function edit(Request $request)
    {
        if(!checkIsNumber($request->input('id',null))){error_jump('参数错误');}
        $id = $request->input('id');
        
        $data['id'] = $where['id'] = $id;
		$data['post'] = $this->getLogic()->getOne($where);
        $data['rolelist'] = logic('AdminRole')->getAll('', ['listorder','asc']);
        
        return view('admin.admin.edit', $data);
    }
	
	public function doedit(Request $request)
    {
        if(!checkIsNumber($request->input('id',null))){error_jump('参数错误');}
        $id = $request->input('id');
        
        if(Helper::isPostRequest())
        {
            $_POST['pwd'] = md5($_POST['pwd']);
            $where['id'] = $id;
            $res = $this->getLogic()->edit($_POST, $where);
            if($res['code'] == ReturnData::SUCCESS)
            {
                success_jump($res['msg'], route('admin_admin'));
            }
            
            error_jump($res['msg']);
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
        if($_POST["oldpwd"]==$_POST["newpwd"]){error_jump('新旧密码不能一致');exit;}
        
        $User = object_to_array(DB::table("admin")->where($map)->first(), 1);
        
        if($User)
        {
            if(DB::table('admin')->where('id', $id)->update($data))
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
    
    public function del(Request $request)
    {
        if(!checkIsNumber($request->input('id',null))){error_jump('参数错误');}
        $id = $request->input('id');
        
        $where['id'] = $id;
        $res = $this->getLogic()->del($where);
        if($res['code'] == ReturnData::SUCCESS)
        {
            success_jump($res['msg']);
        }
        
        error_jump($res['msg']);
    }
}