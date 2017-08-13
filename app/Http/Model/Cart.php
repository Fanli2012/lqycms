<?php
namespace App\Http\Model;

class Cart extends BaseModel
{
	//产品模型
	
    /**
     * 关联到模型的数据表
     *
     * @var string
     */
	protected $table = 'cart';
	
	/**
     * 表明模型是否应该被打上时间戳
     * 默认情况下，Eloquent 期望 created_at 和updated_at 已经存在于数据表中，如果你不想要这些 Laravel 自动管理的数据列，在模型类中设置 $timestamps 属性为 false
	 * 
     * @var bool
     */
    public $timestamps = false;
	
	//protected $guarded = []; //$guarded包含你不想被赋值的字段数组。
	//protected $fillable = ['name']; //定义哪些字段是可以进行赋值的,与$guarded相反
	
	/**
     * The connection name for the model.
     * 默认情况下，所有的 Eloquent 模型使用应用配置中的默认数据库连接，如果你想要为模型指定不同的连接，可以通过 $connection 属性来设置
     * @var string
     */
    //protected $connection = 'connection-name';
	
    const STATUS = 0; //商品是否删除，0未删除
    
    //获取列表
	public static function getList($uid)
    {
        $goods = self::join('goods', 'goods.id', '=', 'cart.goods_id')
            ->where('cart.user_id', $uid)
            ->where('goods.status', 0)
            ->select('cart.*')
            ->get();
        
        if($goods)
        {
            foreach ($goods as $key => $value) 
            {
                //订货数量大于0
                if ($value->goods_number > 0)
                {
                    $goods->goods_price = $goods_price = Goods::get_final_price($value->goods_id);

                    //更新购物车中的商品数量
                    self::where('id', $value->id)->update(array('goods_price' => $goods_price));
                    
                }
            }
        }
        
        return $goods->toArray();
    }
    
    public static function getOne($id)
    {
        if(isset($status)){$where['status'] = $status;}else{$where['status'] = self::STATUS;}
        $where['id'] = $id;
        
        $goods = self::where($where)->first()->toArray();
        
        $goods['price'] = get_final_price($id);
        
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
    public static function remove($id)
    {
        if (!self::whereIn('id', explode(',', $id))->delete())
        {
            return false;
        }
        
        return true;
    }
    
    /**
     * 取得商品最终使用价格
     *
     * @param   string  $goods_id      商品编号
     * @param   string  $goods_num     购买数量
     *
     * @return  商品最终购买价格
     */
    public static function get_final_price($goods_id)
    {
        $final_price   = '0'; //商品最终购买价格
        $promote_price = '0'; //商品促销价格
        $user_price    = '0'; //商品会员价格，预留
        
        //取得商品促销价格列表
        $goods = Goods::where('id',$goods_id)->where('status',0)->first(['promote_price','promote_start_date','promote_end_date','price']);
        $final_price = $goods->price;
        
        // 计算商品的促销价格
        if ($goods->promote_price > 0)
        {
            $promote_price = self::bargain_price($goods->promote_price, $goods->promote_start_date, $goods->promote_end_date);
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
    public static function bargain_price($price, $start, $end)
    {
        if ($price == 0)
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
}