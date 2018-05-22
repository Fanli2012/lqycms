<?php
namespace App\Http\Model;
use DB;
use Log;

class UserBonus extends BaseModel
{
	//用户优惠券
	
    protected $table = 'user_bonus';
	public $timestamps = false;
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
    public function getAll($where = array(), $order = '', $field = '*', $limit = 10, $offset = 0)
    {
        $res = $this->getDb();
        
        if($where){$res = $res->where($where);}
        if($field){if(is_array($field)){$res = $res->select($field);}else{$res = $res->select(\DB::raw($field));}}
        if($order){$res = parent::getOrderByData($res, $order);}
        if($offset){}else{$offset = 0;}
        if($limit){}else{$limit = 10;}
        
        $res = $res->skip($offset)->take($limit)->get();
        
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
        
        $where['user_id'] = $user_id;
        $limit  = isset($limit) ? $limit : 10;
        $offset = isset($offset) ? $offset : 0;
        
        $model = new UserBonus;
        
        if(isset($status)){$where['status'] = $status;}
        
        $model = $model->where($where);
        
        $res['count'] = $model->count();
        $res['list'] = array();
        
		if($res['count']>0)
        {
            $bonus_list = $model->skip($offset)->take($limit)->orderBy('id','desc')->get();
            foreach($bonus_list as $k=>$v)
            {
                $bonus_list[$k]->bonus = Bonus::where('id',$v->bonus_id)->first();
            }
            
            $res['list'] = $bonus_list;
        }
        else
        {
            return false;
        }
        
        return $res;
    }
    
    public static function getOne($where)
    {
        $res = self::where($where)->first();
        if($res){$res->bonus = Bonus::where('id',$res->bonus_id)->first();}
        
        return $res;
    }
    
    public static function add(array $data)
    {
        $bonus1 = Bonus::where(['id'=>$data['bonus_id']])->where('num',-1)->first();
        $bonus2 = Bonus::where(['id'=>$data['bonus_id']])->where('num','>',0)->first();
        
        if(!$bonus1 && !$bonus2)
        {
            return ReturnData::create(ReturnData::PARAMS_ERROR,null,'亲，您来晚了啦，已被抢光了');
        }
        
        if(self::where(['bonus_id'=>$data['bonus_id'],'user_id'=>$data['user_id']])->first()){return ReturnData::create(ReturnData::PARAMS_ERROR,null,'亲，您已获取！');}
        
        $data['get_time'] = time(); //优惠券获取时间
        if ($id = self::insertGetId($data))
        {
            if(!$bonus1){DB::table('bonus')->where(array('id'=>$data['bonus_id']))->decrement('num', 1);}
            
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
    public static function remove($id)
    {
        if (!self::whereIn('id', explode(',', $id))->delete())
        {
            return false;
        }
        
        return true;
    }
    
    //商品结算时，获取优惠券列表
	public static function getAvailableBonusList(array $param)
    {
        extract($param);
        
        $where['user_bonus.user_id'] = $user_id;
        if(isset($status)){$where['bonus.status'] = 0;}
        
        $model = new UserBonus;
        if(isset($min_amount)){$model = $model->where('bonus.min_amount', '<=', $min_amount)->where('bonus.money', '<=', $min_amount);} //满多少使用
        if(isset($bonus_end_time)){$model = $model->where('bonus.end_time', '>=', date('Y-m-d H:i:s'));} //有效期
        
        $bonus_list = $model->join('bonus', 'bonus.id', '=', 'user_bonus.bonus_id')->where($where)
            ->select('bonus.*', 'user_bonus.user_id', 'user_bonus.used_time', 'user_bonus.get_time', 'user_bonus.status as user_bonus_status', 'user_bonus.id as user_bonus_id')
            ->orderBy('bonus.money','desc')->get();
        
		$res['list'] = $bonus_list;
        
        return $res;
    }
    
    public static function getUserBonusByid(array $param)
    {
        extract($param);
        
        $where['user_bonus.user_id'] = $user_id;
        $where['bonus.status'] = 0;
        $where['user_bonus.id'] = $user_bonus_id;
        
        $model = new UserBonus;
        if(isset($min_amount)){$model = $model->where('bonus.min_amount', '<=', $min_amount)->where('bonus.money', '<=', $min_amount);} //满多少使用
        $model = $model->where('bonus.end_time', '>=', date('Y-m-d H:i:s')); //有效期
        
        $bonus = $model->join('bonus', 'bonus.id', '=', 'user_bonus.bonus_id')->where($where)
            ->select('bonus.*', 'user_bonus.user_id', 'user_bonus.used_time', 'user_bonus.get_time', 'user_bonus.status as user_bonus_status', 'user_bonus.id as user_bonus_id')
            ->first();
        
        return $bonus;
    } */
}