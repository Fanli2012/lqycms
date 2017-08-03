<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\CommonController;
use Illuminate\Http\Request;
use App\Common\ReturnData;

use App\Http\Model\Region;

class RegionController extends CommonController
{
    public function __construct()
    {
        parent::__construct();
    }
	
	public function regionList(Request $request)
	{
        //参数
		$id = $request->input('id', null);
		if ($id == null)
		{
			return ReturnData::create(ReturnData::PARAMS_ERROR);
		}
        
		$res = Region::getList($id);
		if(!$res)
		{
			return ReturnData::create(ReturnData::SYSTEM_FAIL);
		}
        
		return ReturnData::create(ReturnData::SUCCESS,$res);
	}
    
    public function regionDetail(Request $request)
	{
        //参数
		$id = $request->input('id', null);
		if ($id == null)
		{
			return ReturnData::create(ReturnData::PARAMS_ERROR);
		}
        
		$res = Region::getOne($id);
		if(!$res)
		{
			return ReturnData::create(ReturnData::SYSTEM_FAIL);
		}
        
		return ReturnData::create(ReturnData::SUCCESS,$res);
	}
}