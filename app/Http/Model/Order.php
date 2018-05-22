<?php
namespace App\Http\Model;
use DB;
use Log;

class Order extends BaseModel
{
	//订单
	
    protected $table = 'order';
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
    //获取订单列表
    public static function getList(array $param)
    {
        extract($param);
        
        $limit  = isset($limit) ? $limit : 10;
        $offset = isset($offset) ? $offset : 0;
        
        $model = new self();
        
        if(isset($user_id)){$where['user_id'] = $user_id;}
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
            $model = $model->where('refund_status','<>',0);
        }
        
        $model = $model->where($where);
        
        $res['count'] = $model->count();
        $res['list'] = array();
        
		if($res['count']>0)
        {
            $order_list = $model->orderBy('id', 'desc')->skip($offset)->take($limit)->get();
            
            if($order_list)
            {
                foreach($order_list as $k=>$v)
                {
                    $order_status_arr = self::getOrderStatusText($v);
                    $order_list[$k]['order_status_text'] = $order_status_arr?$order_status_arr['text']:'';
                    $order_list[$k]['order_status_num'] = $order_status_arr?$order_status_arr['num']:'';
                    
                    $order_list[$k]['province_name'] = Region::getRegionName($v['province']);
                    $order_list[$k]['city_name'] = Region::getRegionName($v['city']);
                    $order_list[$k]['district_name'] = Region::getRegionName($v['district']);
                    
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
        
        $order_status_arr = self::getOrderStatusText($res);
        $res['order_status_text'] = $order_status_arr['text'];
        $res['order_status_num'] = $order_status_arr['num'];
        
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
            'order_sn'     => date('YmdHis').rand(1000,9999),
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
            'message'      => !empty($message)?$message:'',
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
                
                //订单商品直接减库存操作
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
        if (self::where($where)->update($data) === false)
        {
            return false;
        }
        
        return true;
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
    } */
    
    //获取订单状态文字:1待付款，2待发货,3待收货,4待评价(确认收货，交易成功),5退款/售后,6已取消,7无效
    public function getOrderStatusAttr($where)
    {
        $res = '';
        if($where['order_status'] == 0 && $where['pay_status'] ==0)
        {
            $res = array('text'=>'待付款','num'=>1);
        }
        elseif($where['order_status'] == 0 && $where['shipping_status'] == 0 && $where['pay_status'] == 1)
        {
            $res = array('text'=>'待发货','num'=>2);
        }
        elseif($where['order_status'] == 0 && $where['refund_status'] == 0 && $where['shipping_status'] == 1 && $where['pay_status'] == 1)
        {
            $res = array('text'=>'待收货','num'=>3);
        }
        elseif($where['order_status'] == 3 && $where['refund_status'] == 0)
        {
            $res = array('text'=>'交易成功','num'=>4);
        }
        elseif($where['order_status'] == 3 && $where['refund_status'] == 1)
        {
            $res = array('text'=>'售后中','num'=>5);
        }
        elseif($where['order_status'] == 1)
        {
            $res = array('text'=>'已取消','num'=>6);
        }
        elseif($where['order_status'] == 2)
        {
            $res = array('text'=>'无效','num'=>7);
        }
        elseif($where['order_status'] == 3 && $where['refund_status'] == 2)
        {
            $res = array('text'=>'退款成功','num'=>8);
        }
        
        return $res;
    }
    
    //获取发票类型文字：0不索要发票，1个人，2企业
    public function getInvoiceAttr($where)
    {
        $res = '';
        if($where['invoice'] == 0)
        {
            $res = '不索要发票';
        }
        elseif($where['invoice'] == 1)
        {
            $res = '个人';
        }
        elseif($where['invoice'] == 2)
        {
            $res = '企业';
        }
        
        return $res;
    }
    
    //获取订单来源文字：1pc，2weixin，3app，4wap
    public function getPlaceTypeAttr($where)
    {
        $res = '';
        if($where['place_type'] === 1)
        {
            $res = 'pc';
        }
        elseif($where['place_type'] === 2)
        {
            $res = 'weixin';
        }
        elseif($where['place_type'] === 3)
        {
            $res = 'app';
        }
        elseif($where['place_type'] === 4)
        {
            $res = 'wap';
        }
        
        return $res;
    }
    
    //根据订单id返库存
    public function returnStock($order_id)
    {
        $order_goods = OrderGoods::where(array('order_id'=>$order_id))->get();
        if(!$order_goods){return false;}
        
        foreach($order_goods as $k=>$v)
        {
            //订单商品直接返库存
            Goods::changeGoodsStock(array('goods_id'=>$v['goods_id'],'goods_number'=>$v['goods_number'],'type'=>1));
        }
        
        return true;
    }
    
    //订单超时，设为无效
    public function orderSetInvalid($order_id)
    {
        $order = self::where(array('id'=>$order_id,'order_status'=>0,'pay_status'=>0))->update(['order_status'=>2]);
        if(!$order){return false;}
        
        //返库存
        self::returnStock($order_id);
        
        return true;
    }
}