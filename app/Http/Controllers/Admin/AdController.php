<?php
namespace App\Http\Controllers\Admin;
use DB;
use App\Common\Helper;
use App\Common\ReturnData;
use Illuminate\Http\Request;
use App\Http\Logic\AdLogic;
use App\Http\Model\Ad;

class AdController extends BaseController
{
    public function __construct()
    {
        parent::__construct();
    }
	
    public function getLogic()
    {
        return new AdLogic();
    }
    
    public function index(Request $request)
    {
        $res = '';
        $where = function ($query) use ($res) {
			if(isset($_REQUEST["keyword"]))
			{
				$query->where('name', 'like', '%'.$_REQUEST['keyword'].'%');
			}
        };
        
        $list = $this->getLogic()->getPaginate($where, array('id', 'desc'));
        $data['list'] = $list;
		return view('admin.ad.index', $data);
    }
    
    public function add(Request $request)
    {
		if(Helper::isPostRequest())
        {
            if ($_POST['start_time'] && $_POST['end_time']) {
                $_POST['start_time'] = strtotime($_POST['start_time']);
                $_POST['end_time'] = strtotime($_POST['end_time']);
            }

            $res = $this->getLogic()->add($_POST);
            if($res['code'] == ReturnData::SUCCESS)
            {
                success_jump($res['msg'], route('admin_ad'));
            }
            
            error_jump($res['msg']);
        }

        return view('admin.ad.add');
    }
   
    public function edit(Request $request)
    {
        if(!checkIsNumber($request->input('id',null))){error_jump('参数错误');}
        $id = $request->input('id');

		if(Helper::isPostRequest())
        {
            if ($_POST['start_time'] && $_POST['end_time']) {
                $_POST['start_time'] = strtotime($_POST['start_time']);
                $_POST['end_time'] = strtotime($_POST['end_time']);
            }

            $where['id'] = $id;
            $res = $this->getLogic()->edit($_POST, $where);
            if($res['code'] == ReturnData::SUCCESS)
            {
                success_jump($res['msg'], route('admin_ad'));
            }
            
            error_jump($res['msg']);
        }

        $data['id'] = $where['id'] = $id;
		$post = $this->getLogic()->getOne($where);

        //时间戳转日期格式
        if ($post->start_time > 0) {
            $post->start_time = date('Y-m-d H:i:s', $post->start_time);
        } else {
            $post['start_time'] = '';
        }
        if ($post->end_time > 0) {
            $post->end_time = date('Y-m-d H:i:s', $post->end_time);
        } else {
            $post->end_time = '';
        }

		$data['post'] = $post;
        return view('admin.ad.edit', $data);
    }

    public function del(Request $request)
    {
        if(!checkIsNumber($request->input('id',null))){error_jump('参数错误');}
        $id = $request->input('id');
        
        $where['id'] = $id;
        $res = $this->getLogic()->del($where);
        if($res['code'] != ReturnData::SUCCESS)
        {
            error_jump($res['msg']);
        }
        
        success_jump($res['msg']);
    }
}