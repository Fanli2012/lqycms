<?php
namespace App\Http\Model;
use DB;
use Log;

class Goods extends BaseModel
{
	//产品模型
	
    /**
     * 关联到模型的数据表
     *
     * @var string
     */
	protected $table = 'goods';
    
	/**
     * 表明模型是否应该被打上时间戳
     * 默认情况下，Eloquent 期望 created_at 和updated_at 已经存在于数据表中，如果你不想要这些 Laravel 自动管理的数据列，在模型类中设置 $timestamps 属性为 false
	 * 
     * @var bool
     */
    public $timestamps = false;
    protected $hidden = array();
    
	//protected $guarded = []; //$guarded包含你不想被赋值的字段数组。
	//protected $fillable = ['name']; //定义哪些字段是可以进行赋值的,与$guarded相反
	
	/**
     * The connection name for the model.
     * 默认情况下，所有的 Eloquent 模型使用应用配置中的默认数据库连接，如果你想要为模型指定不同的连接，可以通过 $connection 属性来设置
     * @var string
     */
    //protected $connection = 'connection-name';
	
    //常用字段
    public $common_field = array(
        'id', 'typeid', 'tuijian', 'click', 'title', 'description', 'sn', 'price','litpic', 'pubdate', 'add_time', 'market_price', 'goods_number', 'sale', 'comments','promote_start_date','promote_price','promote_end_date','goods_img','spec','point'
    );
    
    const GOODS_NORMAL_STATUS = 0; //商品状态 0正常 1已删除 2下架 3申请上架
    
	/**
     * 获取关联到产品的分类
     */
    public function goodstype()
    {
        return $this->belongsTo(GoodsType::class, 'typeid', 'id');
    }
	
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
        //return $model->toSql();//打印sql语句
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
     * @return int
     */
    public function edit($data, $where = array())
    {
        $res = $this->getDb();
        return $res->where($where)->update(parent::filterTableColumn($data, $this->table));
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
     * 取得商品最终使用价格
     *
     * @param   string  $goods_id      商品编号
     * @param   string  $goods_num     购买数量
     *
     * @return  商品最终购买价格
     */
    /* public function get_final_price($goods_id)
    {
        $final_price   = '0'; //商品最终购买价格
        $promote_price = '0'; //商品促销价格
        $user_price    = '0'; //商品会员价格，预留
        
        //取得商品促销价格列表
        $goods = Goods::where('id',$goods_id)->where('status', self::GOODS_NORMAL_STATUS)->first(['promote_price','promote_start_date','promote_end_date','price']);
        $final_price = $goods->price;
        
        // 计算商品的促销价格
        if ($goods->promote_price > 0)
        {
            $promote_price = $this->bargain_price($goods->promote_price, $goods->promote_start_date, $goods->promote_end_date);
        }
        else
        {
            $promote_price = 0;
        }
        
        if ($promote_price != 0)
        {
            $final_price = $promote_price;
        }
        
        //返回商品最终购买价格
        return $final_price;
    } */
    
    /**
     * 取得商品最终使用价格
     *
     * @param   string  $goods_id      商品编号
     * @param   string  $goods_num     购买数量
     *
     * @return  商品最终购买价格
     */
    public function get_goods_final_price($goods)
    {
        $final_price   = '0'; //商品最终购买价格
        $promote_price = '0'; //商品促销价格
        $user_price    = '0'; //商品会员价格，预留
        
        //取得商品促销价格列表
        $final_price = $goods->price;
        
        // 计算商品的促销价格
        if ($goods->promote_price > 0)
        {
            $promote_price = $this->bargain_price($goods->promote_price, $goods->promote_start_date, $goods->promote_end_date);
        }
        else
        {
            $promote_price = 0;
        }
        
        if ($promote_price != 0)
        {
            $final_price = $promote_price;
        }
        
        //返回商品最终购买价格
        return $final_price;
    }
    
    /**
     * 判断某个商品是否正在特价促销期
     *
     * @access  public
     * @param   float   $price      促销价格
     * @param   string  $start      促销开始日期
     * @param   string  $end        促销结束日期
     * @return  float   如果还在促销期则返回促销价，否则返回0
     */
    public function bargain_price($price, $start, $end)
    {
        if ($price <= 0)
        {
            return 0;
        }
        else
        {
            $time = time();
            
            if ($time >= $start && $time <= $end)
            {
                return $price;
            }
            else
            {
                return 0;
            }
        }
    }
    
    /**
     * 增加或减少商品库存
     *
     * @access  public
     * @param   int   $id  商品ID
     * @param   int  $type 1增加库存
     * @return  bool
     */
    public function changeGoodsStock($where)
    {
        if(isset($where['type']) && $where['type']==1)
        {
            //增加库存
            return $this->getDb()->where(array('id'=>$where['goods_id']))->increment('goods_number', $where['goods_number']);
        }
        
        //减少库存
        return $this->getDb()->where(array('id'=>$where['goods_id']))->decrement('goods_number', $where['goods_number']);
    }
    
    //获取栏目名称
    public function getTypenameAttr($data)
    {
        return DB::table('goods_type')->where(array('id'=>$data['typeid']))->value('name');
    }
    
    /**
     * 打印sql
     */
    public function toSql($where)
    {
        return $this->getDb()->where($where)->toSql();
    }
}