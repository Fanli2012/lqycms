<?php
namespace App\Http\Controllers\Admin;
use DB;
use App\Common\Helper;
use App\Common\ReturnData;
use Illuminate\Http\Request;
use App\Http\Logic\AdminRoleLogic;
use App\Http\Model\AdminRole;

class AdminRoleController extends CommonController
{
    public function __construct()
    {
        parent::__construct();
    }
	
    public function getLogic()
    {
        return new AdminRoleLogic();
    }
    
    public function index(Request $request)
    {
        $res = '';
        $where = function ($query) use ($res) {
			if(isset($_REQUEST["keyword"]))
			{
				$query->where('name', 'like', '%'.$_REQUEST['keyword'].'%');
			}
			
			if(isset($_REQUEST["pid"]))
			{
				$query->where('pid', $_REQUEST["pid"]);
			}
            
            if(isset($_REQUEST["status"]))
			{
				$query->where('status', $_REQUEST["status"]);
			}
        };
        
        $posts = $this->getLogic()->getPaginate($where, array('listorder', 'asc'));
        $data['posts'] = $posts;
		return view('admin.adminrole.index', $data);
    }
    
    public function add(Request $request)
    {
        return view('admin.adminrole.add');
    }
    
    public function doadd(Request $request)
    {
        if(Helper::isPostRequest())
        {
            $res = $this->getLogic()->add($_POST);
            if($res['code'] == ReturnData::SUCCESS)
            {
                success_jump($res['msg'], route('admin_adminrole'));
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
        
        return view('admin.adminrole.edit', $data);
    }
	
    public function doedit(Request $request)
    {
        if(!checkIsNumber($request->input('id',null))){error_jump('参数错误');}
        $id = $request->input('id');
        
        if(Helper::isPostRequest())
        {
            $where['id'] = $id;
            $res = $this->getLogic()->edit($_POST, $where);
            if($res['code'] == ReturnData::SUCCESS)
            {
                success_jump($res['msg'], route('admin_adminrole'));
            }
            
            error_jump($res['msg']);
        }
    }
    
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
	
	//角色权限设置视图
	public function permissions()
    {
		if(!empty($_GET["id"])){$data['role_id'] = $_GET["id"];}else{error_jump('您访问的页面不存在或已被删除！');}
		
		$menu = [];
		$access = model('Access')->getAll(['role_id'=>$data['role_id']]);
		if($access)
		{
			foreach($access as $k=>$v)
			{
				$menu[] = $v->menu_id;
			}
		}
		
		$data['menus'] = category_tree(get_category('menu',0));
		foreach($data['menus'] as $k=>$v)
		{
			$data['menus'][$k]['is_access'] = 0;
			
			if(!empty($menu) && in_array($v['id'], $menu))
			{
				$data['menus'][$k]['is_access'] = 1;
			}
		}
		
		return view('admin.adminrole.permissions', $data);
    }
	
	//角色权限设置
	public function dopermissions()
    {
		$menus = [];
		if($_POST['menuid'] && $_POST['role_id'])
		{
			foreach($_POST['menuid'] as $row)
			{
				$menus[] = [
					'role_id' => $_POST['role_id'],
					'menu_id' => $row
				];
			}
		}
		else
		{
			error_jump('操作失败');
		}
        
		DB::beginTransaction();
		model('Access')->del(['role_id'=>$_POST['role_id']]);
        
		if(model('Access')->add($menus, 1))
        {
			DB::commit();
            success_jump('操作成功');
        }
        
		DB::rollBack();
		error_jump('操作失败');
    }
}