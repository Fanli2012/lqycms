<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\CommonController;
use Illuminate\Http\Request;
use App\Common\ReturnData;
use App\Common\Token;
use App\Http\Model\UserMessage;

class UserMessageController extends CommonController
{
    public function __construct()
    {
        parent::__construct();
    }
    
    //用户消息列表
    public function userMessageList(Request $request)
	{
        //参数
        $data['limit'] = $request->input('limit', 10);
        $data['offset'] = $request->input('offset', 0);
        if($request->input('type', '') != ''){$data['type'] = $request->input('type');}
        if($request->input('status', '') != ''){$data['status'] = $request->input('status');}
        $data['user_id'] = Token::$uid;
        
        $res = UserMessage::getList($data);
		if(!$res)
		{
			return ReturnData::create(ReturnData::SYSTEM_FAIL);
		}
        
		return ReturnData::create(ReturnData::SUCCESS,$res);
    }
    
    //添加用户消息
    public function userMessageAdd(Request $request)
	{
        //参数
        $data['des'] = $request->input('des','');
        if($request->input('type', '') != ''){$data['type'] = $request->input('type');}
        if($request->input('title', '') != ''){$data['title'] = $request->input('title');}
        if($request->input('litpic', '') != ''){$data['litpic'] = $request->input('litpic');}
        $data['add_time'] = time();
        $data['user_id'] = Token::$uid;
        
        if($data['des']=='')
		{
            return ReturnData::create(ReturnData::PARAMS_ERROR);
        }
        
        $res = UserMessage::add($data);
		if(!$res)
		{
			return ReturnData::create(ReturnData::SYSTEM_FAIL);
		}
        
		return ReturnData::create(ReturnData::SUCCESS,$res);
    }
    
    //修改用户消息
    public function userMessageUpdate(Request $request)
	{
        //参数
        if($request->input('des', '') != ''){$data['des'] = $request->input('des');}
        if($request->input('type', '') != ''){$data['type'] = $request->input('type');}
        if($request->input('title', '') != ''){$data['title'] = $request->input('title');}
        if($request->input('litpic', '') != ''){$data['litpic'] = $request->input('litpic');}
        if($request->input('status', '') != ''){$data['status'] = $request->input('status');}
        
        $where['id'] = $request->input('id');
        $where['user_id'] = Token::$uid;
        
        $res = UserMessage::modify($where,$data);
		if($res === false)
		{
			return ReturnData::create(ReturnData::SYSTEM_FAIL);
		}
        
		return ReturnData::create(ReturnData::SUCCESS,$res);
    }
}