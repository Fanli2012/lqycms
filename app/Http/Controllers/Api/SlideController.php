<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\CommonController;
use Illuminate\Http\Request;
use App\Common\ReturnData;

use App\Http\Model\Slide;

class SlideController extends CommonController
{
    public function __construct()
    {
        parent::__construct();
    }
	
    public function slideList(Request $request)
	{
        //参数
        $data['limit'] = $request->input('limit', 10);
        $data['offset'] = $request->input('offset', 0);
        if($request->input('group_id', null) !== null){$data['group_id'] = $request->input('group_id');};
        
        $res = Slide::getList($data);
		if(!$res)
		{
			return ReturnData::create(ReturnData::SYSTEM_FAIL);
		}
        
		return ReturnData::create(ReturnData::SUCCESS,$res);
    }
}