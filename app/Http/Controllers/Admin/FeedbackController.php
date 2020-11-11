<?php
namespace App\Http\Controllers\Admin;
use Illuminate\Support\Facades\DB;
use App\Common\Helper;
use App\Common\ReturnData;
use Illuminate\Http\Request;
use App\Http\Logic\FeedbackLogic;
use App\Http\Model\Feedback;

class FeedbackController extends BaseController
{
    public function __construct()
    {
        parent::__construct();
    }
    
    public function getLogic()
    {
        return new FeedbackLogic();
    }
    
    public function index()
    {
        $res = '';
        $where = function ($query) use ($res) {
			if(isset($_REQUEST["keyword"]))
			{
				$query->where('title', 'like', '%'.$_REQUEST['keyword'].'%');
			}
			
			if(isset($_REQUEST["user_id"]))
			{
				$query->where('user_id', $_REQUEST["user_id"]);
			}
            
            if(isset($_REQUEST["type"]))
			{
				$query->where('type', $_REQUEST["type"]);
			}
            
            if(isset($_REQUEST["mobile"]))
			{
				$query->where('mobile', $_REQUEST["mobile"]);
			}
        };
        
        $posts = $this->getLogic()->getPaginate($where, array('id', 'desc'));
        $data['posts'] = $posts;
		return view('admin.feedback.index', $data);
    }
    
    public function add()
    {
        return view('admin.feedback.add');
    }
    
    public function doadd(Request $request)
    {
        if(Helper::isPostRequest())
        {
            $res = $this->getLogic()->add($_POST);
            if($res['code'] == ReturnData::SUCCESS)
            {
                success_jump($res['msg'], route('admin_feedback'));
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
        
        return view('admin.feedback.edit', $data);
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
                success_jump($res['msg'], route('admin_feedback'));
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