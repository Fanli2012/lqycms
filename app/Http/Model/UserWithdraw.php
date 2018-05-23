<?php
namespace App\Http\Model;
use DB;
use Log;

class UserWithdraw extends BaseModel
{
	//用户余额明细
	
    protected $table = 'user_withdraw';
    public $timestamps = false;
    protected $hidden = array();
    protected $guarded = array(); //$guarded包含你不想被赋值的字段数组。
    
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
    /* 
    //获取列表
	public static function getList(array $param)
    {
        extract($param); //参数：limit，offset
        
        $limit  = isset($limit) ? $limit : 10;
        $offset = isset($offset) ? $offset : 0;
        $where['user_id'] = $user_id;
        $where['is_delete'] = 0;
        
        $model = new self;
        
        if(isset($status) && !empty($status)){if($status==-1){}else{$where['status'] = $status;}}
        if(isset($method)){$where['method'] = $method;}
        
        $model = $model->where($where);
        
        $res['count'] = $model->count();
        $res['list'] = array();
        
		if($res['count']>0)
        {
            $res['list']  = $model->skip($offset)->take($limit)->orderBy('id','desc')->get();
            
            foreach($res['list'] as $k=>$v)
            {
                $res['list'][$k]['status_text'] = self::getStatusText($v);
            }
        }
        else
        {
            return false;
        }
        
        return $res;
    }
    
    public static function getOne(array $param)
    {
        extract($param);
        
        $where['id'] = $id;
        $where['is_delete'] = 0;
        
        return self::where($where)->first();
    }
    
    public static function add(array $data)
    {
        $user = User::where(array('id'=>$data['user_id'],'pay_password'=>$data['pay_password']))->first();
        if(!$user){return ReturnData::create(ReturnData::PARAMS_ERROR,null,'支付密码错误');}
        unset($data['pay_password']);
        
        $min_withdraw_money = sysconfig('CMS_MIN_WITHDRAWAL_MONEY'); //最低可提现金额
        if($user['money']<$data['money']){return ReturnData::create(ReturnData::PARAMS_ERROR,null,'余额不足');}
        if($user['money']<$min_withdraw_money){return ReturnData::create(ReturnData::PARAMS_ERROR,null,'用户金额小于最小提现金额');}
        if($data['money']<$min_withdraw_money){return ReturnData::create(ReturnData::PARAMS_ERROR,null,'提现金额不得小于最小提现金额');}
        
        if ($id = self::insertGetId($data))
        {
            //扣除用户余额
            DB::table('user')->where(array('id'=>$data['user_id']))->decrement('money', $data['money']);
            //增加用户余额记录
            DB::table('user_money')->insert(array('user_id'=>$data['user_id'],'type'=>1,'money'=>$data['money'],'des'=>'提现','user_money'=>DB::table('user')->where(array('id'=>$data['user_id']))->value('money'),'add_time'=>time()));
            
            return ReturnData::create(ReturnData::SUCCESS,$id);
        }

        return ReturnData::create(ReturnData::SYSTEM_FAIL);
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
    public static function remove($id,$user_id)
    {
        if (!self::whereIn('id', explode(',', $id))->where('user_id',$user_id)->update(array('is_delete'=>1)))
        {
            return false;
        }
        
        return true;
    }
    
    //获取提现状态文字:0未处理,1处理中,2成功,3取消，4拒绝
    public static function getStatusText($where)
    {
        $res = '';
        if($where['status'] == 0)
        {
            $res = '未处理';
        }
        elseif($where['status'] == 1)
        {
            $res = '处理中';
        }
        elseif($where['status'] == 2)
        {
            $res = '成功';
        }
        elseif($where['status'] == 3)
        {
            $res = '取消';
        }
        elseif($where['status'] == 4)
        {
            $res = '拒绝';
        }
        
        return $res;
    } */
}