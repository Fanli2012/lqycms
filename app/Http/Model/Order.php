<?php
namespace App\Http\Model;
use App\Common\ReturnData;
use DB;

class Order extends BaseModel
{
	//购物车模型
	
    /**
     * 关联到模型的数据表
     *
     * @var string
     */
	protected $table = 'order';
    
    public $timestamps = false;
	
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
    
    public static function add(array $param)
    {
        extract($param);
        
        //获取订单商品列表
        $order_goods = Cart::cartCheckoutGoodsList(array('ids'=>$cartids,'user_id'=>$user_id));
        if(!$order_goods){return ReturnData::create(ReturnData::SYSTEM_FAIL,null,'订单商品不存在');}
        return $order_goods;
        //获取收货地址
        $user_address = UserAddress::getOne($user_id,$default_address_id);
        if(!$user_address){return ReturnData::create(ReturnData::SYSTEM_FAIL,null,'收货地址不存在');}
        
        //获取优惠券信息
        $user_bonus = UserBonus::getUserBonusByid(array('user_bonus_id'=>$user_bonus_id,'user_id'=>$user_id));
        
        $discount = !empty($user_bonus)?$user_bonus['money']:0.00; //优惠金额=优惠券
        
        $order_amount = $order_goods['total_price'] - $discount;
        $pay_status = 0; //未付款
        
        //如果各种优惠金额大于订单实际金额跟运费之和，则默认订单状态为已付款
        if($order_amount < 0)
        {
            $order_amount = 0;
            $pay_status = 1; //已付款
        }
        
        //构造订单字段
		$order_info = array(
            'order_sn'     => date('YmdHis'.rand(1000,9999)),
            'add_time'     => time(),
            'pay_status'   => $pay_status,
            'user_id'      => $user_id,
            'goods_amount' => $order_goods['total_price'], //商品的总金额
            'order_amount' => $order_amount, //应付金额=商品总价+运费-优惠(积分、红包)
            'discount'     => $discount, //优惠金额
            'name'         => $user_address['name'],
            'country'      => $user_address['country'],
            'province'     => $user_address['province'],
            'city'         => $user_address['city'],
            'district'     => $user_address['district'],
            'address'      => $user_address['address'],
            'zipcode'      => $user_address['zipcode'],
            'mobile'       => $user_address['mobile'],
            'place_type'   => $place_type, //订单来源
            'bonus_id'     => !empty($user_bonus)?$user_bonus['id']:0,
            'bonus_money'  => !empty($user_bonus)?$user_bonus['money']:0.00,
            'message'      => $message
		);
        
        //插入订单
        $order_id = self::insertGetId($order_info);
        
        if ($order_id)
        {
            //订单生成成功之后，扣除用户的积分和改变优惠券的使用状态
			//改变优惠券使用状态
            UserBonus::where(array('user_id'=>$user_id,'id'=>$user_bonus_id))->update(array('status'=>1,'used_time'=>time()));
			//扣除用户积分，预留
			//$updateMember['validscore'] = $addressInfo['validscore']-$PointPay;
			//M("Member")->where(array('id'=>$CustomerSysNo))->save($updateMember);
			//增加一条积分支出记录，一条购物获取积分记录
            
            //插入订单商品
            $order_goods_list = array();
            foreach($order_goods['list'] as $k=>$v)
            {
                $temp_order_goods = array(
                    'order_id' => $order_id,
                    'goods_id' => $v['goods_id'],
                    'goods_name' => $v['title'],
                    'goods_number' => $v['goods_number'],
                    'market_price' => $v['market_price'],
                    'goods_price' => $v['final_price'],
                    //'goods_attr' => '', //商品属性，预留
                    'goods_img' => $v['litpic']
                );
                array_push($order_goods_list,$temp_order_goods);
                
                //订单商品直行减库存操作
				Goods::changeGoodsStock(array('goods_id'=>$v['goods_id'],'goods_number'=>$v['goods_number']));
            }
            $result = DB::table('order_goods')->insert($order_goods_list);
            if($result)
            {
                //删除购物对应的记录
                Cart::where(array('user_id'=>$user_id))->whereIn('id', explode("_",$cartids))->delete();
                
                return ReturnData::create(ReturnData::SUCCESS,$order_id);
            }
            else
            {
                return ReturnData::create(ReturnData::SYSTEM_FAIL,null,'订单商品添加失败');
            }
        }
        else
        {
			return ReturnData::create(ReturnData::SYSTEM_FAIL,null,'生成订单失败');
		}
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
    
    //购物车结算商品列表
    public static function cartCheckoutGoodsList(array $param)
    {
        extract($param);
        
        $cartIds = explode("_",$ids);
        
        // 获取购物车列表
    	$cartList = self::where(array('user_id'=>$user_id))->whereIn('id', $cartIds)->get();
        $total_price = 0; //商品总金额
        $total_goods = 0; //商品总数量
        
        if(!empty($cartList))
        {
    		$resultList = array();
    		$checkArr = array();
            
            foreach($cartList as $k=>$v)
            {
                $goods = Goods::where(array('id'=>$v['goods_id']))->first();
                
                $cartList[$k]->is_promote = 0;
                if(Goods::bargain_price($goods->price,$goods->promote_start_date,$goods->promote_end_date) > 0){$cartList[$k]->is_promote = 1;}
                
                $cartList[$k]->final_price = Goods::get_final_price($v['goods_id']); //商品最终价格
                $cartList[$k]->goods_detail_url = route('weixin_goods_detail',array('id'=>$v['goods_id']));
                $cartList[$k]->title = $goods->title;
                $cartList[$k]->litpic = $goods->litpic;
                
                $total_price = $total_price + $cartList[$k]->final_price*$cartList[$k]->goods_number;
                $total_goods = $total_goods + $cartList[$k]->goods_number;
            }
        }
        
        $res['list'] = $cartList;
        $res['total_price'] = $total_price;
        $res['total_goods'] = $total_goods;
        
        return ReturnData::create(ReturnData::SUCCESS,$res);
    }
}