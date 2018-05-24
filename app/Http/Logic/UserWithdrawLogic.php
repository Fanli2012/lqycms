<?php
namespace App\Http\Logic;
use DB;
use App\Common\ReturnData;
use App\Http\Model\UserMoney;
use App\Http\Model\UserWithdraw;
use App\Http\Requests\UserWithdrawRequest;
use Validator;

class UserWithdrawLogic extends BaseLogic
{
    public function __construct()
    {
        parent::__construct();
    }
    
    public function getModel()
    {
        return new UserWithdraw();
    }
    
    public function getValidate($data, $scene_name)
    {
        //数据验证
        $validate = new UserWithdrawRequest();
        return Validator::make($data, $validate->getSceneRules($scene_name), $validate->getSceneRulesMessages());
    }
    
    //列表
    public function getList($where = array(), $order = '', $field = '*', $offset = '', $limit = '')
    {
        $res = $this->getModel()->getList($where, $order, $field, $offset, $limit);
        
        if($res['count'] > 0)
        {
            foreach($res['list'] as $k=>$v)
            {
                $res['list'][$k] = $this->getDataView($v);
            }
        }
        
        return $res;
    }
    
    //分页html
    public function getPaginate($where = array(), $order = '', $field = '*', $limit = '')
    {
        $res = $this->getModel()->getPaginate($where, $order, $field, $limit);
        
        return $res;
    }
    
    //全部列表
    public function getAll($where = array(), $order = '', $field = '*', $limit = '')
    {
        $res = $this->getModel()->getAll($where, $order, $field, $limit);
        
        /* if($res)
        {
            foreach($res as $k=>$v)
            {
                $res[$k] = $this->getDataView($v);
            }
        } */
        
        return $res;
    }
    
    //详情
    public function getOne($where = array(), $field = '*')
    {
        $res = $this->getModel()->getOne($where, $field);
        if(!$res){return false;}
        
        $res = $this->getDataView($res);
        
        return $res;
    }
    
    //添加
    public function add($data = array(), $type=0)
    {
        if(empty($data)){return ReturnData::create(ReturnData::PARAMS_ERROR);}
        
        $validator = $this->getValidate($data, 'add');
        if ($validator->fails()){return ReturnData::create(ReturnData::PARAMS_ERROR, null, $validator->errors()->first());}
        
        if(isset($data['pay_password']) && !empty($data['pay_password'])){}else{return ReturnData::create(ReturnData::PARAMS_ERROR,null,'请输入支付密码');}
        
        $user = model('User')->getOne(array('id'=>$data['user_id'],'pay_password'=>$data['pay_password']));
        if(!$user){return ReturnData::create(ReturnData::PARAMS_ERROR,null,'支付密码错误');}
        unset($data['pay_password']);
        
        $min_withdraw_money = sysconfig('CMS_MIN_WITHDRAWAL_MONEY'); //最低可提现金额
        if($user->money<$data['money']){return ReturnData::create(ReturnData::PARAMS_ERROR,null,'余额不足');}
        if($user->money<$min_withdraw_money){return ReturnData::create(ReturnData::PARAMS_ERROR,null,'用户金额小于最小提现金额');}
        if($data['money']<$min_withdraw_money){return ReturnData::create(ReturnData::PARAMS_ERROR,null,'提现金额不得小于最小提现金额');}
        
        DB::beginTransaction();
        
        $data['add_time'] = time();
        $res = $this->getModel()->add($data,$type);
        if($res)
        {
            //添加用户余额记录并扣除用户余额
            $user_money_data['user_id'] = $data['user_id'];
            $user_money_data['type'] = UserMoney::USER_MONEY_DECREMENT;
            $user_money_data['money'] = $data['money'];
            $user_money_data['des'] = UserWithdraw::USER_WITHDRAW_DES;
            $user_money = logic('UserMoney')->add($user_money_data);
            if($user_money['code'] != ReturnData::SUCCESS){DB::rollBack();return false;}
            
            DB::commit();
            return ReturnData::create(ReturnData::SUCCESS,$res);
        }
        
        DB::rollBack();
        return ReturnData::create(ReturnData::FAIL);
    }
    
    //修改
    public function edit($data, $where = array())
    {
        if(empty($data)){return ReturnData::create(ReturnData::SUCCESS);}
        
        $validator = $this->getValidate($data, 'edit');
        if ($validator->fails()){return ReturnData::create(ReturnData::PARAMS_ERROR, null, $validator->errors()->first());}
        
        $res = $this->getModel()->edit($data,$where);
        if($res){return ReturnData::create(ReturnData::SUCCESS,$res);}
        
        return ReturnData::create(ReturnData::FAIL);
    }
    
    //删除
    public function del($where)
    {
        if(empty($where)){return ReturnData::create(ReturnData::PARAMS_ERROR);}
        
        $validator = $this->getValidate($where,'del');
        if ($validator->fails()){return ReturnData::create(ReturnData::PARAMS_ERROR, null, $validator->errors()->first());}
        
        $res = $this->getModel()->edit(['delete_time'=>time()],$where);
        if($res){return ReturnData::create(ReturnData::SUCCESS,$res);}
        
        return ReturnData::create(ReturnData::FAIL);
    }
    
    /**
     * 数据获取器
     * @param array $data 要转化的数据
     * @return array
     */
    private function getDataView($data = array())
    {
        return getDataAttr($this->getModel(),$data);
    }
    
    /**
     * 取消/拒绝提现
     * @param int $where['id'] 提现id
     * @param int $data['status'] status=3取消或status=4拒绝
     * @param string $data['re_note'] 理由，选填
     * @return array
     */
    public function userWithdrawSuccessConfirm($data, $where)
    {
        if(empty($where) || empty($data)){return ReturnData::create(ReturnData::PARAMS_ERROR);}
        if($data['status']!=3 || $data['status']!=4){return ReturnData::create(ReturnData::PARAMS_ERROR);}
        
        $user_withdraw = $this->getModel()->getOne($where);
        if(!$user_withdraw){return false;}
        
        DB::beginTransaction();
        
        $data['updated_at'] = time();
        $res = $this->getModel()->edit($data,$where);
        if($res)
        {
            //添加用户余额记录并增加用户余额
            $user_money_data['user_id'] = $user_withdraw->user_id;
            $user_money_data['type'] = UserMoney::USER_MONEY_INCREMENT;
            $user_money_data['money'] = $user_withdraw->money;
            $user_money_data['des'] = '提现退回';
            $user_money = logic('UserMoney')->add($user_money_data);
            if($user_money['code'] != ReturnData::SUCCESS){DB::rollBack();return false;}
            
            DB::commit();
            return true;
        }
        
        DB::rollBack();
        return false;
    }
}