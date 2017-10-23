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
	
    //购物车商品类型
    const CART_GENERAL_GOODS        = 0; // 普通商品
    const CART_GROUP_BUY_GOODS      = 1; // 团购商品
    const CART_AUCTION_GOODS        = 2; // 拍卖商品
    const CART_SNATCH_GOODS         = 3; // 夺宝奇兵
    const CART_EXCHANGE_GOODS       = 4; // 积分商城
    
    //获取列表
	public static function getList(array $param)
    {
        extract($param); //参数：limit，offset
        
        $limit  = isset($limit) ? $limit : 10;
        $offset = isset($offset) ? $offset : 0;
        
        $goods = self::join('goods', 'goods.id', '=', 'cart.goods_id')
            ->where('cart.user_id', $user_id)
            ->where('goods.status', Goods::STATUS)
            ->select('cart.*','goods.id as goods_id','goods.title','goods.sn','goods.price as goods_price','goods.market_price','goods.litpic as goods_thumb_img','goods.goods_number as stock','goods.promote_start_date','goods.promote_price','goods.promote_end_date')
            ->skip($offset)->take($limit)
            ->get();
        
        if($goods)
        {
            foreach ($goods as $k => $v) 
            {
                $goods[$k]->is_promote = 0;
                if(Goods::bargain_price($v->goods_price,$v->promote_start_date,$v->promote_end_date) > 0){$goods[$k]->is_promote = 1;}
                
                
                //订货数量大于0
                if ($v->goods_number > 0)
                {
                    $goods[$k]->price = $goods_price = Goods::get_final_price($v->goods_id);

                    //更新购物车中的商品数量
                    self::where('id', $v->id)->update(array('price' => $goods_price));
                }
            }
        }
        
        return $goods;
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
        if (self::whereIn('id', explode(',', $id))->where('user_id',$user_id)->delete() === false)
        {
            return false;
        }
        
        return true;
    }
    
    /**
     * 添加商品到购物车
     *
     * @access  public
     * @param   integer $goods_id   商品编号
     * @param   integer $num        商品数量
     * @param   json   $property    规格值对应的id json数组
     * @return  boolean
     */
    public static function cartAdd(array $attributes)
    {
        extract($attributes);
        
        //获取商品信息
        $goods = Goods::where(['goods_id' => $goods_id, 'status' => Goods::STATUS])->first();
        
        if (!$goods)
        {
            return '商品不存在';
        }
        
        if (isset($property) && json_decode($property,true))
        {
            $property = json_decode($property,true);
        }
        else
        {
            $property = [];
        }
    }
    
    /**
     * 清空购物车
     * 
     * @param int $type 类型：默认普通商品
     */
    public static function clearCart($user_id)
    {
        self::where('user_id',$user_id)->delete();

        return true;
    }
    
    //购物车总价格
    public static function TotalPrice($user_id)
    {
        $goods = self::where('user_id',$user_id)->get();
        $total = 0;
        
        foreach ($goods as $k => $v)
        {
            $total += ($v['goods_number'] * $v['goods_price']);
        }
        
        return (float)$total;
    }
    
    //购物车商品总数量
    public static function TotalGoodsCount($user_id)
    {
        return self::where('user_id',$user_id)->sum('goods_number');
    }
}