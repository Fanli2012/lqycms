<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\CommonController;
use Illuminate\Http\Request;
use App\Common\ReturnData;
use App\Common\Token;
use App\Http\Model\GoodsBrand;

class GoodsBrandController extends CommonController
{
    public function __construct()
    {
        parent::__construct();
    }
    
    public function goodsBrandDetail(Request $request)
	{
        //参数
        $data['id'] = $request->input('id','');
        if($data['id']==''){return ReturnData::create(ReturnData::PARAMS_ERROR);}
        
        $res = GoodsBrand::getOne($data);
		
		return ReturnData::create(ReturnData::SUCCESS,$res);
    }
    
    public function goodsBrandList(Request $request)
	{
        //参数
        $data['limit'] = $request->input('limit', 10);
        $data['offset'] = $request->input('offset', 0);
        $data['status'] = GoodsBrand::IS_SHOW;
        
        $res = GoodsBrand::getList($data);
		
		return ReturnData::create(ReturnData::SUCCESS,$res);
    }
}