<?php
namespace App\Http\Controllers\Api;
use Log;
use DB;
use Illuminate\Http\Request;
use App\Common\ReturnData;
use App\Common\Helper;
use App\Common\Token;
use App\Http\Model\GoodsType;
use App\Http\Logic\GoodsTypeLogic;

class GoodsTypeController extends CommonController
{
    public function __construct()
    {
        parent::__construct();
    }
	
    public function getLogic()
    {
        return logic('GoodsType');
    }
    
    public function goodsTypeList(Request $request)
	{
        //参数
        $limit = $request->input('limit', 10);
        $offset = $request->input('offset', 0);
        $data['pid'] = $request->input('pid', 0);
        $where['status'] = GoodsType::GOODSTYPE_SHOW;
        
        $res = $this->getLogic()->getList($where, array('listorder', 'asc'), '*', $offset, $limit);
		
		return ReturnData::create(ReturnData::SUCCESS, $res);
    }
    
    public function goodsTypeDetail(Request $request)
	{
        //参数
        if(!checkIsNumber($request->input('id',null))){return ReturnData::create(ReturnData::PARAMS_ERROR);}
        $id = $request->input('id');
        
        $where['id'] = $id;
        $where['status'] = GoodsType::GOODSTYPE_SHOW;
        
        $res = $this->getLogic()->getOne($where);
		if(!$res)
		{
			return ReturnData::create(ReturnData::RECORD_NOT_EXIST);
		}
        
		return ReturnData::create(ReturnData::SUCCESS,$res);
    }
    
    //添加
    public function goodsTypeAdd(Request $request)
    {
        if(Helper::isPostRequest())
        {
            return $this->getLogic()->add($_POST);
        }
    }
    
    //修改
    public function goodsTypeUpdate(Request $request)
    {
        if(!checkIsNumber($request->input('id',null))){return ReturnData::create(ReturnData::PARAMS_ERROR);}
        $id = $request->input('id');
        
        if(Helper::isPostRequest())
        {
            unset($_POST['id']);
            $where['id'] = $id;
            
            return $this->getLogic()->edit($_POST,$where);
        }
    }
    
    //删除
    public function goodsTypeDelete(Request $request)
    {
        if(!checkIsNumber($request->input('id',null))){return ReturnData::create(ReturnData::PARAMS_ERROR);}
        $id = $request->input('id');
        
        if(Helper::isPostRequest())
        {
            $where['id'] = $id;
            
            return $this->getLogic()->del($where);
        }
    }
}