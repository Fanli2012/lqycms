<?php
namespace App\Http\Model;
use DB;
use Log;

class Cart extends BaseModel
{
	//购物车模型
	
    /**
     * 关联到模型的数据表
     *
     * @var string
     */
	protected $table = 'cart';
    public $timestamps = false;
    protected $hidden = array();
    protected $guarded = array(); //$guarded包含你不想被赋值的字段数组。
    
    //购物车商品类型
    const CART_GENERAL_GOODS        = 0; // 普通商品
    const CART_GROUP_BUY_GOODS      = 1; // 团购商品
    const CART_AUCTION_GOODS        = 2; // 拍卖商品
    const CART_SNATCH_GOODS         = 3; // 夺宝奇兵
    const CART_EXCHANGE_GOODS       = 4; // 积分商城
    
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
        
        $model = self::join('goods', 'goods.id', '=', 'cart.goods_id')
            ->where('cart.user_id', $user_id)
            ->where('goods.status', Goods::STATUS)
            ->select('cart.*','goods.id as goods_id','goods.title','goods.sn','goods.price as goods_price','goods.market_price','goods.litpic','goods.goods_number as stock','goods.promote_start_date','goods.promote_price','goods.promote_end_date');
            
        $res['count'] = $model->count();
        $res['list'] = array();
        
        if($res['count']>0)
        {
            $res['list'] = $model->get();
            
            foreach ($res['list'] as $k => $v) 
            {
                $res['list'][$k]->is_promote = 0;
                if(Goods::bargain_price($v->goods_price,$v->promote_start_date,$v->promote_end_date) > 0){$res['list'][$k]->is_promote = 1;}
                
                //订货数量大于0
                if ($v->goods_number > 0)
                {
                    $res['list'][$k]->final_price = Goods::get_final_price($v->goods_id);   //商品最终价格
                    $res['list'][$k]->goods_detail_url = route('weixin_goods_detail',array('id'=>$v->goods_id));
                    
                    //更新购物车中的商品数量
                    //self::where('id', $v->id)->update(array('price' => $goods_price));
                }
            }
        }
        else
        {
            return false;
        }
        
        return $res;
    }
    
    public static function getOne($where)
    {
        $goods = self::where($where)->first();
        
        return $goods;
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
    public static function remove($id,$user_id)
    {
        if(!is_array($id)){$id = explode(',', $id);}
        if (self::whereIn('id', $id)->where('user_id',$user_id)->delete() === false)
        {
            return false;
        }
        
        return true;
    }
    */
    
    /**
     * 添加商品到购物车
     *
     * @access  public
     * @param   integer $goods_id     商品编号
     * @param   integer $goods_number 商品数量
     * @param   json   $property      规格值对应的id json数组
     * @return  boolean
     */
    public function cartAdd(array $attributes)
    {
        extract($attributes);
        
        //获取商品信息
        $goods = Goods::where(['id' => $goods_id, 'status' => Goods::GOODS_NORMAL_STATUS])->first();
        
        if (!$goods)
        {
            return ReturnData::create(ReturnData::PARAMS_ERROR,null,'商品不存在');
        }
        
        //判断库存 是否足够
        if($goods['goods_number']<$goods_number)
        {
            return ReturnData::create(ReturnData::PARAMS_ERROR,null,'库存不足');
        }
        
        //判断购物车商品数
        if(Cart::where(['user_id'=>$user_id])->count() >= 20)
        {
            return ReturnData::create(ReturnData::PARAMS_ERROR,null,'购物车商品最多20件');
        }
        
        //查看是否已经有购物车插入记录
        $where = array(
            'user_id'	=> $user_id,
            'goods_id'	=> $goods_id
        );
        
        $cart = Cart::where($where)->first();
        
        if($cart)
        {
            //更新购物车
            $updateArr = array(
                'goods_number'		=> $goods_number,
                'add_time'			=> time(),
            );
            
            self::where(array('id'=>$cart->id))->update($updateArr);
            
            $cart_id = $cart->id;
        }
        else
        {
            //添加购物车
            $cartInsert = array(
                'user_id'			=> $user_id,
                'goods_id'			=> $goods_id,
                'goods_number'		=> $goods_number,
                'add_time'			=> time(),
            );
            
            $cart_id = self::insertGetId($cartInsert);
        }
        
        return ReturnData::create(ReturnData::SUCCESS,$cart_id,'购物车添加成功');
    }
    
    /**
     * 用户购物车商品总数量
     *
     * @access  public
     * @param   int $user_id 用户ID
     * @return  int
     */
    public function TotalGoodsCount($where)
    {
        return self::where($where)->sum('goods_number');
    }
}