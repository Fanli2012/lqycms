<?php
namespace App\Http\Controllers\Admin;
use DB;
use App\Common\Helper;
use App\Common\ReturnData;
use Illuminate\Http\Request;
use App\Http\Logic\FriendlinkLogic;
use App\Http\Model\Friendlink;

class FriendlinkController extends CommonController
{
    public function __construct()
    {
        parent::__construct();
    }
	
    public function getLogic()
    {
        return new FriendlinkLogic();
    }
    
    public function index(Request $request)
    {
        $res = '';
        $where = function ($query) use ($res) {
			if(isset($_REQUEST["keyword"]))
			{
				$query->where('webname', 'like', '%'.$_REQUEST['keyword'].'%');
			}
			
			if(isset($_REQUEST["group_id"]))
			{
				$query->where('group_id', $_REQUEST["group_id"]);
			}
        };
        
        $posts = $this->getLogic()->getPaginate($where, array('listorder', 'asc'));
        $data['posts'] = $posts;
		return view('admin.friendlink.index', $data);
    }
    
    public function add(Request $request)
    {
        return view('admin.friendlink.add');
    }
    
    public function doadd(Request $request)
    {
        if(Helper::isPostRequest())
        {
            $res = $this->getLogic()->add($_POST);
            if($res['code'] == ReturnData::SUCCESS)
            {
                success_jump($res['msg'], route('admin_friendlink'));
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
        
        return view('admin.friendlink.edit', $data);
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
                success_jump($res['msg'], route('admin_friendlink'));
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
}