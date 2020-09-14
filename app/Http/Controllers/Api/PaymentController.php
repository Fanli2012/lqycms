<?php
namespace App\Http\Controllers\Api;
use Log;
use DB;
use Illuminate\Http\Request;
use App\Common\ReturnData;
use App\Common\Helper;
use App\Common\Token;
use App\Http\Model\Payment;
use App\Http\Logic\PaymentLogic;

class PaymentController extends BaseController
{
    public function __construct()
    {
        parent::__construct();
    }
    
    public function getLogic()
    {
        return new PaymentLogic();
    }
    
    public function paymentList(Request $request)
	{
        //参数
        $limit = $request->input('limit', 10);
        $offset = $request->input('offset', 0);
        $where['status'] = Payment::IS_SHOW;
        
        $res = $this->getLogic()->getList($where, array('listorder', 'asc'), '*', $offset, $limit);
		
        /* if($res['count']>0)
        {
            foreach($res['list'] as $k=>$v)
            {
                
            }
        } */
        
		return ReturnData::create(ReturnData::SUCCESS,$res);
    }
    
    //详情
    public function paymentDetail(Request $request)
	{
        //参数
        if(!checkIsNumber($request->input('id',null))){return ReturnData::create(ReturnData::PARAMS_ERROR);}
        $id = $request->input('id');
        
        $where['status'] = Payment::IS_SHOW;
        $where['id'] = $id;
        
		$res = $this->getLogic()->getOne($where);
        if(!$res){return ReturnData::create(ReturnData::RECORD_NOT_EXIST);}
        
		return ReturnData::create(ReturnData::SUCCESS,$res);
    }
    
    //添加
    public function paymentAdd(Request $request)
    {
        if(Helper::isPostRequest())
        {
            $res = $this->getLogic()->add($_POST);
            
            return $res;
        }
    }
    
    //修改
    public function paymentUpdate(Request $request)
    {
        if(!checkIsNumber($request->input('id',null))){return ReturnData::create(ReturnData::PARAMS_ERROR);}
        $id = $request->input('id');
        
        if(Helper::isPostRequest())
        {
            unset($_POST['id']);
            $where['id'] = $id;
            
            $res = $this->getLogic()->edit($_POST,$where);
            
            return $res;
        }
    }
    
    //删除
    public function paymentDelete(Request $request)
    {
        if(!checkIsNumber($request->input('id',null))){return ReturnData::create(ReturnData::PARAMS_ERROR);}
        $id = $request->input('id');
        
        if(Helper::isPostRequest())
        {
            $where['id'] = $id;
            
            $res = $this->getLogic()->del($where);
            
            return $res;
        }
    }
}