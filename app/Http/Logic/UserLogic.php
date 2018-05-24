<?php
namespace App\Http\Logic;
use App\Common\ReturnData;
use App\Common\Token;
use App\Http\Model\User;
use App\Http\Requests\UserRequest;
use Validator;

class UserLogic extends BaseLogic
{
    public function __construct()
    {
        parent::__construct();
    }
    
    public function getModel()
    {
        return new User();
    }
    
    public function getValidate($data, $scene_name)
    {
        //数据验证
        $validate = new UserRequest();
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
                
                //$res['list'][$k]->user_name = !empty($res['list'][$k]->mobile) ? $res['list'][$k]->mobile : $res['list'][$k]->user_name;
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
        
        $res->reciever_address = model('UserAddress')->getOne(['id'=>$res->address_id]);
        $res->collect_goods_count = model('CollectGoods')->getDb()->where(['user_id'=>$res->id])->count();
        $res->bonus_count = model('UserBonus')->getDb()->where(array('user_id'=>$res->id,'status'=>0))->count();
        
        return $res;
    }
    
    //添加
    public function add($data = array(), $type=0)
    {
        if(empty($data)){return ReturnData::create(ReturnData::PARAMS_ERROR);}
        
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
    
    //修改用户密码、支付密码
    public function userPasswordUpdate($data, $where = array())
    {
        if(empty($data)){return ReturnData::create(ReturnData::SUCCESS);}
        
        $user = $this->getModel()->getOne($where);
        if(!$user){return ReturnData::create(ReturnData::PARAMS_ERROR, null, '用户不存在');}
        
        //密码
        if(isset($data['old_password']))
        {
            if($user->password && $data['old_password']!=$user->password)
            {
                return ReturnData::create(ReturnData::PARAMS_ERROR, null, '旧密码错误');
            }
        }
        
        //支付密码
        if(isset($data['pay_password']))
        {
            if($user->pay_password && $data['old_pay_password']!=$user->pay_password)
            {
                return ReturnData::create(ReturnData::PARAMS_ERROR, null, '旧支付密码错误');
            }
        }
        
        $res = $this->getModel()->edit($data,$where);
        if($res === false){return ReturnData::create(ReturnData::SYSTEM_FAIL);}
        
        return ReturnData::create(ReturnData::SUCCESS,$res);
    }
    
    //签到
	public function signin($where)
    {
        $user = $this->getModel()->getOne($where);
        if(!$user){return ReturnData::create(ReturnData::PARAMS_ERROR, null, '用户不存在');}
		
		$signin_time='';
		if(!empty($user->signin_time)){$signin_time = date('Ymd',strtotime($user->signin_time));} //签到时间
		
		$today = date('Ymd',time()); //今日日期
		
		if($signin_time==$today){return ReturnData::create(ReturnData::PARAMS_ERROR, null, '今日已签到');}
		
		$signin_point = (int)sysconfig('CMS_SIGN_POINT'); //签到积分
		$this->getModel()->edit(['point'=>($user->point+$signin_point),'signin_time'=>date('Y-m-d H:i:s')], ['id'=>$user->id]); //更新用户积分，及签到时间
		model('UserPoint')->add(['type'=>1,'point'=>$signin_point,'des'=>'签到','user_id'=>$user->id]); //添加签到积分记录
		
		return ReturnData::create(ReturnData::SUCCESS, null, '签到成功');
    }
    
    //用户登录
	public function wxLogin($where)
    {
        if(isset($where['openid']) && !empty($where['openid']))
        {
            $user = $this->getOne(array('openid'=>$where['openid']));
        }
        elseif(isset($where['user_name']) && !empty($where['user_name']))
        {
            $user = $this->getOne(function ($query) use ($where) {$query->where(['mobile'=>$where['user_name'],'password'=>$where['password']])->orWhere(['user_name'=>$where['user_name'],'password'=>$where['password']]);});
        }
        
        if(isset($user) && !$user){return ReturnData::create(ReturnData::PARAMS_ERROR, null, '用户不存在或者账号密码错误');}
        
        $token = Token::getToken(Token::TYPE_WEIXIN, $user->id);
        
        foreach($token as $k=>$v)
        {
            $user->$k = $v;
        }
        
		return ReturnData::create(ReturnData::SUCCESS, $user, '登录成功');
    }
    
    //注册
    public function wxRegister($data)
	{
        if(empty($data)){return ReturnData::create(ReturnData::PARAMS_ERROR);}
        
        $data['add_time'] = time();
        
        $validator = $this->getValidate($data, 'wx_register');
        if ($validator->fails()){return ReturnData::create(ReturnData::PARAMS_ERROR, null, $validator->errors()->first());}
        
        $res = $this->getModel()->add($data);
        if($res === false){return ReturnData::create(ReturnData::SYSTEM_FAIL);}
        
        //生成token
        $token = Token::getToken(Token::TYPE_WEIXIN, $res);
        
        return ReturnData::create(ReturnData::SUCCESS,$token, '注册成功');
    }
    
    
}