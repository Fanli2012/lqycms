<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\CommonController;
use Illuminate\Http\Request;
use App\Common\ReturnData;
use App\Common\Token;
use App\Http\Model\GoodsType;

class GoodsTypeController extends CommonController
{
    public function __construct()
    {
        parent::__construct();
    }
    
    public function goodsTypeDetail(Request $request)
	{
        //参数
        $data['id'] = $request->input('id','');
        if($data['id']==''){return ReturnData::create(ReturnData::PARAMS_ERROR);}
        
        $res = GoodsType::getOne($data);
		
		return ReturnData::create(ReturnData::SUCCESS,$res);
    }
    
    public function goodsTypeList(Request $request)
	{
        //参数
        $data['limit'] = $request->input('limit', 10);
        $data['offset'] = $request->input('offset', 0);
        
        $data['pid'] = $request->input('pid', 0);
        
        $res = GoodsType::getList($data);
		
		return ReturnData::create(ReturnData::SUCCESS,$res);
    }
}