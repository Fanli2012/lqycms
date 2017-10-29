<?php
namespace App\Http\Model;

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
        $goods = Goods::where(['id' => $goods_id, 'status' => Goods::STATUS])->first();
        
        if (!$goods)
        {
            return '商品不存在';
        }
        
        //判断库存 是否足够
        if($goods['goods_number']<$goods_number)
        {
            return '库存不足';
        }
        
        //判断购物车商品数
        if(Cart::where(['user_id'=>$user_id])->count() >= 20)
        {
            return '购物车商品最多20件';
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
            
            self::insertGetId($cartInsert);
        }
        
        return true;
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
    
    //购物车商品总数量
    public static function TotalGoodsCount($user_id)
    {
        return self::where('user_id',$user_id)->sum('goods_number');
    }
}