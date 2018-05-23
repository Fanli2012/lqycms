<?php
namespace App\Http\Model;
use DB;
use Log;

class User extends BaseModel
{
	//用户模型
	
    protected $table = 'user';
	public $timestamps = false;
	protected $hidden = array('password','pay_password');
	protected $guarded = []; //$guarded包含你不想被赋值的字段数组。
	
    public function getDb()
    {
        return DB::table($this->table);
    }
    
    /**
     * 列表
     * @param array $where 查询条件
     * @param string $order 排序
     * @param string $field 字段
     * @param int $offset 偏移量
     * @param int $limit 取多少条
     * @return array
     */
    public function getList($where = array(), $order = '', $field = '*', $offset = 0, $limit = 10)
    {
        $model = $this->getDb();
        if($where){$model = $model->where($where);}
        
        $res['count'] = $model->count();
        $res['list'] = array();
        
        if($res['count'] > 0)
        {
            if($field){if(is_array($field)){$model = $model->select($field);}else{$model = $model->select(\DB::raw($field));}}
            if($order){$model = parent::getOrderByData($model, $order);}
            if($offset){}else{$offset = 0;}
            if($limit){}else{$limit = 10;}
            
            $res['list'] = $model->skip($offset)->take($limit)->get();
        }
        
        return $res;
    }
    
    /**
     * 分页，用于前端html输出
     * @param array $where 查询条件
     * @param string $order 排序
     * @param string $field 字段
     * @param int $limit 每页几条
     * @param int $page 当前第几页
     * @return array
     */
    public function getPaginate($where = array(), $order = '', $field = '*', $limit = 10)
    {
        $res = $this->getDb();
        
        if($where){$res = $res->where($where);}
        if($field){if(is_array($field)){$res = $res->select($field);}else{$res = $res->select(\DB::raw($field));}}
        if($order){$res = parent::getOrderByData($res, $order);}
        if($limit){}else{$limit = 10;}
        
        return $res->paginate($limit);
    }
    
    /**
     * 查询全部
     * @param array $where 查询条件
     * @param string $order 排序
     * @param string $field 字段
     * @param int $limit 取多少条
     * @return array
     */
    public function getAll($where = array(), $order = '', $field = '*', $limit = '', $offset = '')
    {
        $res = $this->getDb();
        
        if($where){$res = $res->where($where);}
        if($field){if(is_array($field)){$res = $res->select($field);}else{$res = $res->select(\DB::raw($field));}}
        if($order){$res = parent::getOrderByData($res, $order);}
        if($offset){$res = $res->skip($offset);}
        if($limit){$res = $res->take($limit);}
        
        $res = $res->get();
        
        return $res;
    }
    
    /**
     * 获取一条
     * @param array $where 条件
     * @param string $field 字段
     * @return array
     */
    public function getOne($where, $field = '*')
    {
        $res = $this->getDb();
        
        if($where){$res = $res->where($where);}
        if($field){if(is_array($field)){$res = $res->select($field);}else{$res = $res->select(\DB::raw($field));}}
        
        $res = $res->first();
        
        return $res;
    }
    
    /**
     * 添加
     * @param array $data 数据
     * @return int
     */
    public function add(array $data,$type = 0)
    {
        if($type==0)
        {
            // 新增单条数据并返回主键值
            return self::insertGetId(parent::filterTableColumn($data,$this->table));
        }
        elseif($type==1)
        {
            /**
             * 添加单条数据
             * $data = ['foo' => 'bar', 'bar' => 'foo'];
             * 添加多条数据
             * $data = [
             *     ['foo' => 'bar', 'bar' => 'foo'],
             *     ['foo' => 'bar1', 'bar' => 'foo1'],
             *     ['foo' => 'bar2', 'bar' => 'foo2']
             * ];
             */
            return self::insert($data);
        }
    }
    
    /**
     * 修改
     * @param array $data 数据
     * @param array $where 条件
     * @return bool
     */
    public function edit($data, $where = array())
    {
        $res = $this->getDb();
        $res = $res->where($where)->update(parent::filterTableColumn($data, $this->table));
        
        if ($res === false)
        {
            return false;
        }
        
        return true;
    }
    
    /**
     * 删除
     * @param array $where 条件
     * @return bool
     */
    public function del($where)
    {
        $res = $this->getDb();
        $res = $res->where($where)->delete();
        
        return $res;
    }
    
	/**
     * 获取关联到用户的角色
     */
    public function userrole()
    {
        return $this->belongsTo(UserRole::class, 'role_id', 'id');
    }
    /* 
    //签到
	public function signin()
    {
        $user = self::where(['id'=>Token::$uid])->first();
		
		$signin_time='';
		if(!empty($user->signin_time)){$signin_time = date('Ymd',strtotime($user->signin_time));} //签到时间
		
		$today = date('Ymd',time()); //今日日期
		
		if($signin_time==$today){return '今日已签到！';}
		
		$signin_point = (int)Sysconfig::where(['varname'=>'CMS_SIGN_POINT'])->value('value'); //签到积分
		User::where(['id'=>Token::$uid])->update(['point'=>($user->point+$signin_point),'signin_time'=>date('Y-m-d H:i:s')]); //更新用户积分，及签到时间
		UserPoint::insert(['type'=>1,'point'=>$signin_point,'des'=>'签到','user_id'=>Token::$uid]); //添加签到积分记录
		
		return true;
    }
    
    //获取列表
	public static function getList(array $param)
    {
        extract($param); //参数：limit，offset
        
        $limit  = isset($limit) ? $limit : 10;
        $offset = isset($offset) ? $offset : 0;
        
        $model = new User;
        
        if(isset($group_id)){$where['group_id'] = $group_id;}
        if(isset($parent_id)){$where['parent_id'] = $parent_id;}
        
        if(isset($where)){$model = $model->where($where);}
        
        $res['count'] = $model->count();
        $res['list'] = array();
        
		if($res['count']>0)
        {
            $res['list'] = $model->select('id','user_name','email','sex','money','commission','point','mobile','nickname','head_img','add_time')->skip($offset)->take($limit)->orderBy('id','desc')->get();
            
            foreach($res['list'] as $k=>$v)
            {
                $res['list'][$k]['user_name'] = !empty($res['list'][$k]['mobile']) ? $res['list'][$k]['mobile'] : $res['list'][$k]['user_name'];
            }
        }
        else
        {
            return false;
        }
        
        return $res;
    }
    
    //获取一条用户信息
	public static function getOne($id)
    {
        $user = self::where('id', $id)->first();
        if(!$user){return false;}
        $user['reciever_address'] = UserAddress::getOne($user->address_id);
        
		return $user;
    }
    
    public static function add(array $data)
    {
        if ($id = self::insertGetId($data))
        {
            return $id;
        }

        return false;
    }
    
    public static function modify($where, array $data)
    {
        if (self::where($where)->update($data))
        {
            return true;
        }
        
        return false;
    }
    
    //删除一条记录
    public static function remove($id)
    {
        if (!self::whereIn('id', explode(',', $id))->delete())
        {
            return false;
        }
        
        return true;
    }
     */
    
    //获取用户信息
    public static function getUserInfo($user_id)
    {
        $user = self::where('id', $user_id)->first();
        if(!$user){return false;}
        $user->reciever_address = UserAddress::getOne($user->address_id);
        $user->collect_goods_count = CollectGoods::where('user_id', $user_id)->count();
        $user->bonus_count = UserBonus::where(array('user_id'=>$user_id,'status'=>0))->count();
        
        $userinfo = $user->makeVisible(array('pay_password'))->toArray();
        $user->pay_password = 0;
        if($userinfo['pay_password']){$user->pay_password = 1;}

        return $user;
    }

    //修改用户密码、支付密码
    public static function userPasswordUpdate($where,array $param)
    {
        extract($param);
        $data = '';

        $user = self::where($where)->first();
        if(!$user){return false;}

        $user = $user->makeVisible(array('password','pay_password'))->toArray();

        if(isset($old_password) && $old_password!=$user['password']){return false;} //旧密码错误
        if(isset($password) && $password==''){return false;} //新密码为空

        if(isset($old_pay_password) && $old_pay_password!=$user['pay_password']){return false;}
        if(isset($pay_password) && $pay_password==''){return false;}

        if(isset($password)){$data['password'] = $password;}
        if(isset($pay_password)){$data['pay_password'] = $pay_password;}

        if ($data != '' && self::where($where)->update($data))
        {
            return true;
        }

        return false;
    }
    
    //注册
    public static function wxRegister(array $param)
	{
        extract($param); //参数
        
        if(isset($user_name)){$data['user_name'] = $user_name;}
        if(isset($mobile)){$data['mobile'] = $mobile;}
        if(isset($password)){$data['password'] = $password;} //md5加密
        if(isset($parent_id) && !empty($parent_id)){$data['parent_id'] = $parent_id;}
        if(isset($openid)){$data['openid'] = $openid;}
        if(isset($unionid)){$data['unionid'] = $unionid;}
        if(isset($sex)){$data['sex'] = $sex;}
        if(isset($head_img)){$data['head_img'] = $head_img;}
        if(isset($nickname)){$data['nickname'] = $nickname;}
        $data['add_time'] = time();
        
        if (isset($data) && $id = self::add($data))
        {
            //生成token
			return Token::getToken(Token::TYPE_WEIXIN, $id);
        }
        
        return false;
    }
    
    //用户登录
	public static function wxLogin(array $param)
    {
        extract($param); //参数
        
        if(isset($openid) && !empty($openid))
        {
            $user = self::where(array('openid'=>$openid))->first();
        }
        else
        {
            $user = self::where(array('mobile'=>$user_name,'password'=>$password))->orWhere(array('user_name'=>$user_name,'password'=>$password))->first();
        }
        
        if(!isset($user)){return false;}
        
        $res = self::getUserInfo($user->id);
        $token = Token::getToken(Token::TYPE_WEIXIN, $user->id);
        
        foreach($token as $k=>$v)
        {
            $res->$k = $v;
        }
        
		return $res;
    }
    
    //性别1男2女
    public function getSexAttr($data)
    {
        $arr = [0 => '未知', 1 => '男', 2 => '女'];
        return $arr[$data->sex];
    }
    
    //用户状态 1正常状态 2 删除至回收站 3锁定
    public function getStatusAttr($data)
    {
        $arr = [1 => '正常', 2 => '删除', 3 => '锁定'];
        return $arr[$data->status];
    }
}