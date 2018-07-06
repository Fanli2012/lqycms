<?php
namespace App\Http\Logic;
use App\Common\ReturnData;
use App\Http\Model\UserRecharge;
use App\Http\Model\UserMoney;
use App\Http\Requests\UserRechargeRequest;
use Validator;

class UserRechargeLogic extends BaseLogic
{
    public function __construct()
    {
        parent::__construct();
    }
    
    public function getModel()
    {
        return new UserRecharge();
    }
    
    public function getValidate($data, $scene_name)
    {
        //数据验证
        $validate = new UserRechargeRequest();
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
        
        if($res->count() > 0)
        {
            foreach($res as $k=>$v)
            {
                $res[$k] = $this->getDataView($v);
            }
        }
        
        return $res;
    }
    
    //全部列表
    public function getAll($where = array(), $order = '', $field = '*', $limit = '')
    {
        $res = $this->getModel()->getAll($where, $order, $field, $limit);
        
        if($res)
        {
            foreach($res as $k=>$v)
            {
                $res[$k] = $this->getDataView($v);
            }
        }
        
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
        
        $data['recharge_sn'] = date('YmdHis').rand(1000,9999);
        $data['created_at'] = $data['updated_at'] = time();
        
        $validator = $this->getValidate($data, 'add');
        if ($validator->fails()){return ReturnData::create(ReturnData::PARAMS_ERROR, null, $validator->errors()->first());}
        
        $res = $this->getModel()->add($data,$type);
        if($res){return ReturnData::create(ReturnData::SUCCESS,$res);}
        
        return ReturnData::create(ReturnData::FAIL);
    }
    
    //修改
    public function edit($data, $where = array())
    {
        if(empty($data)){return ReturnData::create(ReturnData::SUCCESS);}
        
        $validator = $this->getValidate($data, 'edit');
        if ($validator->fails()){return ReturnData::create(ReturnData::PARAMS_ERROR, null, $validator->errors()->first());}
        
        $data['updated_at'] = time();
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
        
        $res = $this->getModel()->del($where);
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
     * 充值成功之后修改记录信息,回调信息
     * @param int $data['pay_time'] 实际充值时间
     * @param int $data['pay_type'] 充值类型：1微信，2支付宝
     * @param float $data['pay_money'] 充值金额
     * @param string $data['trade_no'] 支付流水号
     * @return array
     */
    public function paySuccessChangeRechargeInfo($data, $where)
    {
        if(empty($where) || empty($data)){return ReturnData::create(ReturnData::PARAMS_ERROR);}
        
        $user_recharge = $this->getModel()->getOne($where);
        if(!$user_recharge){return false;}
        
        DB::beginTransaction();
        
        $data['updated_at'] = time();
        $data['status'] = UserRecharge::COMPLETE_PAY;
        $res = $this->getModel()->edit($data,$where);
        if($res)
        {
            //添加用户余额记录并增加用户余额
            $user_money_data['user_id'] = $user_recharge->user_id;
            $user_money_data['type'] = UserMoney::USER_MONEY_INCREMENT;
            $user_money_data['money'] = $data['pay_money'];
            $user_money_data['des'] = UserRecharge::USER_RECHARGE_DES;
            $user_money = logic('UserMoney')->add($user_money_data);
            if($user_money['code'] != ReturnData::SUCCESS){DB::rollBack();return false;}
            
            DB::commit();
            return true;
        }
        
        DB::rollBack();
        return false;
    }
}