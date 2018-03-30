<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\CommonController;
use Illuminate\Http\Request;
use App\Common\ReturnData;
use App\Common\Token;
use App\Http\Model\FeedBack;

class FeedBackController extends CommonController
{
    public function __construct()
    {
        parent::__construct();
    }
    
    public function feedbackList(Request $request)
	{
        //参数
        $data['limit'] = $request->input('limit', 10);
        $data['offset'] = $request->input('offset', 0);
        
        $res = FeedBack::getList($data);
		if(!$res)
		{
			return ReturnData::create(ReturnData::SYSTEM_FAIL);
		}
        
		return ReturnData::create(ReturnData::SUCCESS,$res);
    }
    
    //添加意见反馈
    public function feedbackAdd(Request $request)
	{
        //参数
        $data['content'] = $request->input('content',null);
        if($request->input('title', null) !== null){$data['title'] = $request->input('title');}
        if($request->input('mobile', null) !== null){$data['mobile'] = $request->input('mobile');}
        if($request->input('type', null) !== null){$data['type'] = $request->input('type');}
        $data['user_id'] = Token::$uid;
        
        if($data['content']===null)
		{
            return ReturnData::create(ReturnData::PARAMS_ERROR);
        }
        
        $res = FeedBack::add($data);
		if(!$res)
		{
			return ReturnData::create(ReturnData::SYSTEM_FAIL);
		}
        
		return ReturnData::create(ReturnData::SUCCESS,$res);
    }
}