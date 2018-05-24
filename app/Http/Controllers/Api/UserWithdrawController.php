<?php
namespace App\Http\Controllers\Api;
use Log;
use DB;
use Illuminate\Http\Request;
use App\Common\ReturnData;
use App\Common\Helper;
use App\Common\Token;
use App\Http\Model\UserWithdraw;
use App\Http\Logic\UserWithdrawLogic;

class UserWithdrawController extends CommonController
{
    public function __construct()
    {
        parent::__construct();
    }
    
    public function getLogic()
    {
        return logic('UserWithdraw');
    }
    
    public function userWithdrawList(Request $request)
	{
        //参数
        $limit = $request->input('limit', 10);
        $offset = $request->input('offset', 0);
        if($request->input('status', null) != null){$where['status'] = $request->input('status');}
        if($request->input('method', null) != null){$where['method'] = $request->input('method');}
        $where['delete_time'] = UserWithdraw::UN_DELETE;
        $where['user_id'] = Token::$uid;
        
        $res = $this->getLogic()->getList($where, array('id', 'desc'), '*', $offset, $limit);
		
		return ReturnData::create(ReturnData::SUCCESS,$res);
    }
    
    public function userWithdrawDetail(Request $request)
	{
        //参数
        if(!checkIsNumber($request->input('id',null))){return ReturnData::create(ReturnData::PARAMS_ERROR);}
        $id = $request->input('id');
        $where['id'] = $id;
        $where['delete_time'] = UserWithdraw::UN_DELETE;
        
        $res = $this->getLogic()->getOne($where);
		if(!$res)
		{
			return ReturnData::create(ReturnData::RECORD_NOT_EXIST);
		}
        
		return ReturnData::create(ReturnData::SUCCESS,$res);
    }
    
    //添加
    public function userWithdrawAdd(Request $request)
    {
        if(Helper::isPostRequest())
        {
            $_POST['user_id'] = Token::$uid;
            
            return $this->getLogic()->add($_POST);
        }
    }
    
    //修改
    public function userWithdrawUpdate(Request $request)
    {
        if(!checkIsNumber($request->input('id',null))){return ReturnData::create(ReturnData::PARAMS_ERROR);}
        $id = $request->input('id');
        
        if(Helper::isPostRequest())
        {
            unset($_POST['id']);
            $where['id'] = $id;
            $where['user_id'] = Token::$uid;
            $where['delete_time'] = UserWithdraw::UN_DELETE;
            
            return $this->getLogic()->edit($_POST,$where);
        }
    }
    
    //删除
    public function userWithdrawDelete(Request $request)
    {
        if(!checkIsNumber($request->input('id',null))){return ReturnData::create(ReturnData::PARAMS_ERROR);}
        $id = $request->input('id');
        
        if(Helper::isPostRequest())
        {
            $where['id'] = $id;
            $where['user_id'] = Token::$uid;
            
            return $this->getLogic()->del($where);
        }
    }
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    /* //用户提现列表
    public function userWithdrawList(Request $request)
	{
        //参数
        $data['limit'] = $request->input('limit', 10);
        $data['offset'] = $request->input('offset', 0);
        if($request->input('status', '') != ''){$data['status'] = $request->input('status');}
        if($request->input('method', '') != ''){$data['method'] = $request->input('method');}
        $data['user_id'] = Token::$uid;
        
        $res = UserWithdraw::getList($data);
		if(!$res)
		{
			return ReturnData::create(ReturnData::SYSTEM_FAIL);
		}
        
		return ReturnData::create(ReturnData::SUCCESS,$res);
    }
    
    //添加提现
    public function userWithdrawAdd(Request $request)
	{
        //参数
        $data['method'] = $request->input('method','');
        $data['money'] = $request->input('money','');
        $data['account'] = $request->input('account','');
        $data['name'] = $request->input('name','');
        if($request->input('note', '') != ''){$data['note'] = $request->input('note');}
        if($request->input('status', '') != ''){$data['status'] = $request->input('status');}
        if($request->input('bank_name', '') != ''){$data['bank_name'] = $request->input('bank_name');}
        if($request->input('bank_place', '') != ''){$data['bank_place'] = $request->input('bank_place');}
        $data['add_time'] = time();
        $data['user_id'] = Token::$uid;
        $data['pay_password'] = $request->input('pay_password','');
        
        if($data['method']=='' || $data['money']=='' || $data['account']=='' || $data['name']=='' || $data['pay_password']=='')
		{
            return ReturnData::create(ReturnData::PARAMS_ERROR);
        }
        
        if($data['method'] == 'bank' && (!isset($data['bank_name']) || !isset($data['bank_place'])))
        {
            return ReturnData::create(ReturnData::PARAMS_ERROR);
        }
        
        return UserWithdraw::add($data);
    }
    
    //修改提现
    public function userWithdrawUpdate(Request $request)
	{
        //参数
        $where['user_id'] = Token::$uid;
        $where['id'] = $request->input('id',null);
        
        if($request->input('status',null)!==null){$data['status'] = $request->input('status');}
        if($request->input('money',null)!==null){$data['money'] = $request->input('money');}
        if($request->input('re_note',null)!==null){$data['re_note'] = $request->input('re_note');}
        if($request->input('note',null)!==null){$data['note'] = $request->input('note');}
        if($request->input('account',null)!==null){$data['account'] = $request->input('account');}
        if($request->input('method',null)!==null){$data['method'] = $request->input('method');}
        if($request->input('is_delete',null)!==null){$data['is_delete'] = $request->input('is_delete');}
        if($request->input('bank_name',null)!==null){$data['bank_name'] = $request->input('bank_name');}
        if($request->input('bank_place',null)!==null){$data['bank_place'] = $request->input('bank_place');}
        
        if(!isset($data))
		{
            return ReturnData::create(ReturnData::SUCCESS);
        }
        
        $res = UserWithdraw::modify($where,$data);
		if($res === false)
		{
			return ReturnData::create(ReturnData::SYSTEM_FAIL);
		}
        
		return ReturnData::create(ReturnData::SUCCESS,$res);
    } */
}