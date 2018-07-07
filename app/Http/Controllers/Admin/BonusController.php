<?php
namespace App\Http\Controllers\Admin;
use DB;
use App\Common\Helper;
use App\Common\ReturnData;
use Illuminate\Http\Request;
use App\Http\Logic\BonusLogic;
use App\Http\Model\Bonus;

class BonusController extends CommonController
{
    public function __construct()
    {
        parent::__construct();
    }
    
    public function getLogic()
    {
        return new BonusLogic();
    }
    
    public function index(Request $request)
    {
        $res = '';
		$where = function ($query) use ($res) {
			if(isset($_REQUEST["keyword"]))
			{
				$query->where('name', 'like', '%'.$_REQUEST['keyword'].'%');
			}
			
			if(isset($_REQUEST["id"]))
			{
				$query->where('typeid', $_REQUEST["id"]);
			}
        };
		
        $posts = $this->getLogic()->getPaginate($where, array('status', 'asc'));
		if($posts)
        {
            foreach($posts as $k=>$v)
            {
                
            }
        }
        
        $data['posts'] = $posts;
		
		return view('admin.bonus.index', $data);
    }
    
    public function add(Request $request)
    {
        if(Helper::isPostRequest())
        {
            if($_POST["start_time"]>=$_POST["end_time"]){error_jump('参数错误');}
            
            $res = $this->getLogic()->add($_POST);
            if($res['code'] == ReturnData::SUCCESS)
            {
                success_jump($res['msg'], route('admin_bonus'));
            }
            
            error_jump($res['msg']);
        }
        
        return view('admin.bonus.add');
    }
    
    public function edit(Request $request)
    {
        if(!checkIsNumber($request->input('id',null))){error_jump('参数错误');}
        $id = $request->input('id');
        
        if(Helper::isPostRequest())
        {
            $where['id'] = $id;
            
            if($_POST["start_time"]>=$_POST["end_time"]){error_jump('参数错误');}
            
            $res = $this->getLogic()->edit($_POST, $where);
            if($res['code'] == ReturnData::SUCCESS)
            {
                success_jump($res['msg'], route('admin_bonus'));
            }
            
            error_jump($res['msg']);
        }
        
        $data['id'] = $where['id'] = $id;
		$data['post'] = $this->getLogic()->getOne($where);
        
        return view('admin.bonus.edit', $data);
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
}