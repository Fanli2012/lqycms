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
	
    //获取订单列表
    public static function getList(array $param)
    {
        extract($param);
        
        $limit  = isset($limit) ? $limit : 10;
        $offset = isset($offset) ? $offset : 0;
        
        $where['user_id'] = $user_id;
        $where['is_delete'] = 0;
        
        //0或者不传表示全部，1待付款，2待发货,3待收货,4待评价(确认收货，交易成功),5退款/售后
        if($status == 1)
        {
            $where['order_status'] = 0;
            $where['pay_status'] = 0;
        }
        elseif($status == 2)
        {
            $where['order_status'] = 0;
            $where['shipping_status'] = 0;
            $where['pay_status'] = 1;
        }
        elseif($status == 3)
        {
            $where['order_status'] = 0;
            $where['refund_status'] = 0;
            $where['shipping_status'] = 1;
            $where['pay_status'] = 1;
        }
        elseif($status == 4)
        {
            $where['order_status'] = 3;
            $where['refund_status'] = 0;
            $where['shipping_status'] = 2;
            $where['is_comment'] = 0;
        }
        elseif($status == 5)
        {
            $where['order_status'] = 3;
            $where['refund_status'] = 1;
        }
        
        $model = self::where($where);
        
        $res['count'] = $model->count();
        $res['list'] = array();
        
		if($res['count']>0)
        {
            $order_list = $model->skip($offset)->take($limit)->get();
            
            if($order_list)
            {
                foreach($order_list as $k=>$v)
                {
                    $order_list[$k]['order_status_text'] = self::getOrderStatusText($v);
                    
                    $order_goods = OrderGoods::where(array('order_id'=>$v['id']))->get();
                    $order_list[$k]['goods_list'] = $order_goods;
                }
            }
            
            $res['list'] = $order_list;
        }
        
        return ReturnData::create(ReturnData::SUCCESS,$res);
    }
    
    public static function getOne(array $param)
    {
        extract($param);
        
        $where['id'] = $order_id;
        $where['user_id'] = $user_id;
        
        if(isset($order_status)){$where['order_status'] = $order_status;}
        if(isset($pay_status)){$where['pay_status'] = $pay_status;}
        
        $res = self::where($where)->first();
        
        if(!$res)
        {
            return ReturnData::create(ReturnData::SYSTEM_FAIL);
        }
        
        $res['order_status_text'] = self::getOrderStatusText($res);
        
        $res['province_name'] = Region::getRegionName($res['province']);
        $res['city_name'] = Region::getRegionName($res['city']);
        $res['district_name'] = Region::getRegionName($res['district']);
        
        $order_goods = OrderGoods::where(array('order_id'=>$res['id']))->get();
        $res['goods_list'] = $order_goods;
        
        return ReturnData::create(ReturnData::SUCCESS,$res);
    }
    
    //生成订单
    public static function add(array $param)
    {
        extract($param);
        
        //获取订单商品列表
        $cartCheckoutGoods = Cart::cartCheckoutGoodsList(array('ids'=>$cartids,'user_id'=>$user_id));
        $order_goods = $cartCheckoutGoods['data'];
        if(empty($order_goods['list'])){return ReturnData::create(ReturnData::SYSTEM_FAIL,null,'订单商品不存在');}
        
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
            //'country'      => $user_address['country'],
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
    
    //获取订单状态文字，1待付款，2待发货,3待收货,4待评价(确认收货，交易成功),5退款/售后
    public static function getOrderStatusText($where)
    {
        $res = '';
        if($where['order_status'] == 0 && $where['pay_status'] ==0)
        {
            $res = '待付款';
        }
        elseif($where['order_status'] == 0 && $where['shipping_status'] == 0 && $where['pay_status'] == 1)
        {
            $res = '待发货';
        }
        elseif($where['order_status'] == 0 && $where['refund_status'] == 0 && $where['shipping_status'] == 1 && $where['pay_status'] == 1)
        {
            $res = '待收货';
        }
        elseif($where['order_status'] == 3 && $where['refund_status'] == 0 && $where['shipping_status'] == 2 && $where['is_comment'] == 0)
        {
            $res = '交易成功';
        }
        elseif($where['order_status'] == 3 && $where['refund_status'] == 1)
        {
            $res = '售后';
        }
        
        return $res;
    }
}