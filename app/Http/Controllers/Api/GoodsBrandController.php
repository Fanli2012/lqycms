<?php
namespace App\Http\Controllers\Api;
use Log;
use DB;
use Illuminate\Http\Request;
use App\Common\ReturnData;
use App\Common\Helper;
use App\Common\Token;
use App\Http\Model\GoodsBrand;
use App\Http\Logic\GoodsBrandLogic;

class GoodsBrandController extends BaseController
{
    public function __construct()
    {
        parent::__construct();
    }
    
    public function getLogic()
    {
        return logic('GoodsBrand');
    }
    
    public function goodsBrandList(Request $request)
	{
        //参数
        $limit = $request->input('limit', 10);
        $offset = $request->input('offset', 0);
        $where['status'] = GoodsBrand::IS_SHOW;
        if($request->input('pid', null) != null){$where['pid'] = $request->input('pid');}
        
        $res = $this->getLogic()->getList($where, array('listorder', 'asc'), '*', $offset, $limit);
		
        /* if($res['count']>0)
        {
            foreach($res['list'] as $k=>$v)
            {
                
            }
        } */
        
		return ReturnData::create(ReturnData::SUCCESS,$res);
    }
    
    public function goodsBrandDetail(Request $request)
	{
        //参数
        if(!checkIsNumber($request->input('id',null))){return ReturnData::create(ReturnData::PARAMS_ERROR);}
        $id = $request->input('id');
        
        $where['id'] = $id;
        $where['status'] = GoodsBrand::IS_SHOW;
        
        $res = $this->getLogic()->getOne($where);
		if(!$res)
		{
			return ReturnData::create(ReturnData::RECORD_NOT_EXIST);
		}
        
		return ReturnData::create(ReturnData::SUCCESS,$res);
    }
    
    //添加
    public function goodsBrandAdd(Request $request)
    {
        if(Helper::isPostRequest())
        {
            //$_POST['user_id'] = Token::$uid;
            
            return $this->getLogic()->add($_POST);
        }
    }
    
    //修改
    public function goodsBrandUpdate(Request $request)
    {
        if(!checkIsNumber($request->input('id',null))){return ReturnData::create(ReturnData::PARAMS_ERROR);}
        $id = $request->input('id');
        
        if(Helper::isPostRequest())
        {
            unset($_POST['id']);
            $where['id'] = $id;
            //$where['user_id'] = Token::$uid;
            
            return $this->getLogic()->edit($_POST,$where);
        }
    }
    
    //删除
    public function goodsBrandDelete(Request $request)
    {
        if(!checkIsNumber($request->input('id',null))){return ReturnData::create(ReturnData::PARAMS_ERROR);}
        $id = $request->input('id');
        
        if(Helper::isPostRequest())
        {
            $where['id'] = $id;
            //$where['user_id'] = Token::$uid;
            
            return $this->getLogic()->del($where);
        }
    }
}