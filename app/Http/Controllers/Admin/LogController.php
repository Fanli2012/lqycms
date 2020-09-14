<?php

namespace App\Http\Controllers\Admin;

use DB;
use App\Common\Helper;
use App\Common\ReturnData;
use Illuminate\Http\Request;
use App\Http\Logic\LogLogic;
use App\Http\Model\Log;

class LogController extends BaseController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getLogic()
    {
        return new LogLogic();
    }

    public function index(Request $request)
    {
        $res = '';
        $where = function ($query) use ($res) {
			if (!empty($_REQUEST["keyword"])) {
				$query->where('login_name', 'like', '%' . $_REQUEST['keyword'] . '%')->orWhere('ip', 'like', '%' . $_REQUEST['keyword'] . '%')->orWhere('url', 'like', '%' . $_REQUEST['keyword'] . '%')->orWhere('content', 'like', '%' . $_REQUEST['keyword'] . '%');
			}
			//用户ID
			if (isset($_REQUEST['login_id'])) {
				$query->where('login_id', $_REQUEST["login_id"]);
			}
			//IP
			if (isset($_REQUEST['ip'])) {
				$query->where('ip', $_REQUEST["ip"]);
			}
			//模块
			if (isset($_REQUEST['type']) && $_REQUEST['type'] !== '') {
				$query->where('type', $_REQUEST["type"]);
			}
			//请求方式
			if (isset($_REQUEST['http_method'])) {
				$query->where('http_method', $_REQUEST["http_method"]);
			}
        };

        $list = $this->getLogic()->getPaginate($where, array('id', 'desc'));
        $data['list'] = $list;
        return view('admin.log.index', $data);
    }

    public function add(Request $request)
    {
        return view('admin.log.add');
    }

    public function doadd(Request $request)
    {
        if (Helper::isPostRequest()) {
            $res = $this->getLogic()->add($_POST);
            if ($res['code'] == ReturnData::SUCCESS) {
                success_jump($res['msg'], route('admin_slide'));
            }

            error_jump($res['msg']);
        }
    }

    public function edit(Request $request)
    {
        if (!checkIsNumber($request->input('id', null))) {
            error_jump('参数错误');
        }
        $id = $request->input('id');

        $data['id'] = $where['id'] = $id;
        $data['post'] = $this->getLogic()->getOne($where);

        return view('admin.log.edit', $data);
    }

    public function doedit(Request $request)
    {
        if (!checkIsNumber($request->input('id', null))) {
            error_jump('参数错误');
        }
        $id = $request->input('id');

        if (Helper::isPostRequest()) {
            $where['id'] = $id;
            $res = $this->getLogic()->edit($_POST, $where);
            if ($res['code'] == ReturnData::SUCCESS) {
                success_jump($res['msg'], route('admin_slide'));
            }

            error_jump($res['msg']);
        }
    }

    public function del(Request $request)
    {
        if (!checkIsNumber($request->input('id', null))) {
            error_jump('参数错误');
        }
        $id = $request->input('id');

        $where['id'] = $id;
        $res = $this->getLogic()->del($where);
        if ($res['code'] == ReturnData::SUCCESS) {
            success_jump($res['msg']);
        }

        error_jump($res['msg']);
    }
}