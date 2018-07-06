<?php
namespace App\Http\Logic;
use App\Common\ReturnData;
use App\Http\Model\UserBonus;
use App\Http\Requests\UserBonusRequest;
use Validator;

class UserBonusLogic extends BaseLogic
{
    public function __construct()
    {
        parent::__construct();
    }
    
    public function getModel()
    {
        return new UserBonus();
    }
    
    public function getValidate($data, $scene_name)
    {
        //数据验证
        $validate = new UserBonusRequest();
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
                $res['list'][$k]->bonus = model('Bonus')->getOne(['id'=>$v->bonus_id]);
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
        $res->bonus = model('Bonus')->getOne(['id'=>$res->bonus_id]);
        
        return $res;
    }
    
    //用户获取优惠券
    public function add($data = array(), $type=0)
    {
        if(empty($data)){return ReturnData::create(ReturnData::PARAMS_ERROR);}
        
        $validator = $this->getValidate($data, 'add');
        if ($validator->fails()){return ReturnData::create(ReturnData::PARAMS_ERROR, null, $validator->errors()->first());}
        
        $data['get_time'] = time(); //优惠券获取时间
        
        $bonus = model('Bonus')->getOne(['id'=>$data['bonus_id']]);
        if(!$bonus){return ReturnData::create(ReturnData::PARAMS_ERROR,null,'亲，您来晚了啦，已被抢光了');}
        if($bonus->num==-1 || $bonus->num>0){}else{return ReturnData::create(ReturnData::PARAMS_ERROR,null,'亲，您来晚了啦，已被抢光了');}
        
        if($this->getModel()->getOne(['bonus_id'=>$data['bonus_id'],'user_id'=>$data['user_id']])){return ReturnData::create(ReturnData::PARAMS_ERROR,null,'亲，您已获取！');}
        
        $res = $this->getModel()->add($data,$type);
        if($res)
        {
            if($bonus->num>0){model('Bonus')->getDb()->where(array('id'=>$data['bonus_id']))->decrement('num', 1);}
            return ReturnData::create(ReturnData::SUCCESS,$res);
        }
        
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
     * 商品结算时，获取优惠券列表
     * @param float $param['min_amount'] 最小金额可以用的优惠券
     * @return array
     */
	public function getAvailableBonusList(array $param)
    {
        $where['user_bonus.user_id'] = $param['user_id'];
        if(isset($status)){$where['bonus.status'] = 0;}
        
        $model = model('UserBonus')->getDb();
        if(isset($param['min_amount'])){$model = $model->where('bonus.min_amount', '<=', $param['min_amount'])->where('bonus.money', '<=', $param['min_amount']);} //满多少使用
        $model = $model->where('bonus.end_time', '>=', date('Y-m-d H:i:s')); //有效期
        
        $bonus_list = $model->join('bonus', 'bonus.id', '=', 'user_bonus.bonus_id')->where($where)
            ->select('bonus.*', 'user_bonus.user_id', 'user_bonus.used_time', 'user_bonus.get_time', 'user_bonus.status as user_bonus_status', 'user_bonus.id as user_bonus_id')
            ->orderBy('bonus.money','desc')->get();
        
		$res['list'] = $bonus_list;
        
        return $res;
    }
    
    public function getUserBonusByid(array $param)
    {
        $where['user_bonus.user_id'] = $param['user_id'];
        $where['bonus.status'] = 0;
        $where['user_bonus.id'] = $param['user_bonus_id'];
        
        $model = model('UserBonus')->getDb();
        if(isset($param['min_amount'])){$model = $model->where('bonus.min_amount', '<=', $param['min_amount'])->where('bonus.money', '<=', $param['min_amount']);} //满多少使用
        $model = $model->where('bonus.end_time', '>=', date('Y-m-d H:i:s')); //有效期
        
        $bonus = $model->join('bonus', 'bonus.id', '=', 'user_bonus.bonus_id')->where($where)
            ->select('bonus.*', 'user_bonus.user_id', 'user_bonus.used_time', 'user_bonus.get_time', 'user_bonus.status as user_bonus_status', 'user_bonus.id as user_bonus_id')
            ->first();
        
        return $bonus;
    }
}