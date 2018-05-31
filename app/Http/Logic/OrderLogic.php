<?php
namespace App\Http\Logic;
use Log;
use DB;
use App\Common\ReturnData;
use App\Http\Model\Order;
use App\Http\Requests\OrderRequest;
use Validator;

class OrderLogic extends BaseLogic
{
    public function __construct()
    {
        parent::__construct();
    }
    
    public function getModel()
    {
        return new Order();
    }
    
    public function getValidate($data, $scene_name)
    {
        //数据验证
        $validate = new OrderRequest();
        return Validator::make($data, $validate->getSceneRules($scene_name), $validate->getSceneRulesMessages());
    }
    
    //列表
    public function getList($where = array(), $order = '', $field = '*', $offset = '', $limit = '')
    {
        $res = $this->getModel()->getList($where, $order, $field, $offset, $limit);
        
        if($res['count'] > 0)
        {
            foreach($res['list'] as $k=>$v)
            {
                $res['list'][$k] = $this->getDataView($v);
                
                $order_status_arr = $this->getModel()->getOrderStatusAttr($v);
                $res['list'][$k]->order_status_text = $order_status_arr?$order_status_arr['text']:'';
                $res['list'][$k]->order_status_num = $order_status_arr?$order_status_arr['num']:'';
                $res['list'][$k]->province_name = model('Region')->getRegionName(['id'=>$v->province]);
                $res['list'][$k]->city_name = model('Region')->getRegionName(['id'=>$v->city]);
                $res['list'][$k]->district_name = model('Region')->getRegionName(['id'=>$v->district]);
                
                $order_goods = model('OrderGoods')->getDb()->where(array('order_id'=>$v->id))->get();
                $res['list'][$k]->goods_list = $order_goods;
            }
        }
        
        return $res;
    }
    
    //分页html
    public function getPaginate($where = array(), $order = '', $field = '*', $limit = '')
    {
        $res = $this->getModel()->getPaginate($where, $order, $field, $limit);
        
        return $res;
    }
    
    //全部列表
    public function getAll($where = array(), $order = '', $field = '*', $limit = '')
    {
        $res = $this->getModel()->getAll($where, $order, $field, $limit);
        
        /* if($res)
        {
            foreach($res as $k=>$v)
            {
                $res[$k] = $this->getDataView($v);
            }
        } */
        
        return $res;
    }
    
    //详情
    public function getOne($where = array(), $field = '*')
    {
        $res = $this->getModel()->getOne($where, $field);
        if(!$res){return false;}
        
        $res = $this->getDataView($res);
        
        $order_status_arr = $this->getModel()->getOrderStatusAttr($res);
        $res->order_status_text = $order_status_arr['text'];
        $res->order_status_num = $order_status_arr['num'];
        
        $res->province_name = model('Region')->getRegionName(['id'=>$res->province]);
        $res->city_name = model('Region')->getRegionName(['id'=>$res->city]);
        $res->district_name = model('Region')->getRegionName(['id'=>$res->district]);
        
        $order_goods = model('OrderGoods')->getDb()->where(array('order_id'=>$res->id))->get();
        $res->goods_list = $order_goods;
        
        return $res;
    }
    
    /**
     * 生成订单
     * @param string $data['cartids'] 购物车商品id,格式：1_2_3
     * @param int $data['user_id'] 用户id
     * @param int $data['user_bonus_id'] 用户优惠券id
     * @param string $data['default_address_id'] 用户默认收货地址
     * @param float $data['shipping_costs'] 运费
     * @param string $data['message'] 备注
     * @param int $data['place_type'] 订单来源,1pc，2微信，3app
     * @return array
     */
    public function add($data = array(), $type=0)
    {
        if(empty($data)){return ReturnData::create(ReturnData::PARAMS_ERROR);}
        
        //总的验证规则
        $rules = [
            'cartids' => 'required',
            'user_id' => 'required|integer',
            'user_bonus_id' => 'integer',
            'default_address_id' => 'required|integer',
            'shipping_costs' => ['regex:/^\d{0,10}(\.\d{0,2})?$/'],
            'message' => 'max:150',
            'place_type' => 'integer|between:0,5',
        ];
        
        //总的自定义错误信息
        $messages = [
            'cartids.required' => '购物车商品id必填',
            'user_id.required' => '用户ID必填',
            'user_id.integer' => '用户ID必须为数字',
            'user_bonus_id.integer' => '优惠券ID必须为数字',
            'default_address_id.required' => '收货地址必填',
            'default_address_id.integer' => '收货地址必须为数字',
            'shipping_costs.regex' => '运费格式不正确，运费只能带2位小数的数字',
            'message.max' => '备注不能超过150个字符',
            'place_type.integer' => '订单来源必须是数字',
            'place_type.between' => '订单来源,1pc，2微信，3app',
        ];
        
        $validator = Validator::make($data, $rules, $messages);
        if ($validator->fails()){return ReturnData::create(ReturnData::PARAMS_ERROR, null, $validator->errors()->first());}
        
        //获取订单商品列表
        $cartCheckoutGoods = logic('Cart')->cartCheckoutGoodsList(array('ids'=>$data['cartids'],'user_id'=>$data['user_id']));
        $order_goods = $cartCheckoutGoods['data'];
        if(empty($order_goods['list'])){return ReturnData::create(ReturnData::SYSTEM_FAIL,null,'订单商品不存在');}
        
        //获取收货地址
        $user_address = model('UserAddress')->getOne(['user_id'=>$data['user_id'],'id'=>$data['default_address_id']]);
        if(!$user_address){return ReturnData::create(ReturnData::SYSTEM_FAIL,null,'收货地址不存在');}
        
        //获取优惠券信息
        $user_bonus = logic('UserBonus')->getUserBonusByid(array('user_bonus_id'=>$data['user_bonus_id'],'user_id'=>$data['user_id']));
        
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
            'user_id'      => $data['user_id'],
            'goods_amount' => $order_goods['total_price'], //商品的总金额
            'order_amount' => $order_amount, //应付金额=商品总价+运费-优惠(积分、红包)
            'discount'     => $discount, //优惠金额
            'name'         => $user_address->name,
            //'country'      => $user_address->country,
            'province'     => $user_address->province,
            'city'         => $user_address->city,
            'district'     => $user_address->district,
            'address'      => $user_address->address,
            'zipcode'      => $user_address->zipcode,
            'mobile'       => $user_address->mobile,
            'place_type'   => $data['place_type'], //订单来源
            'bonus_id'     => $user_bonus?$user_bonus['id']:0,
            'bonus_money'  => $user_bonus?$user_bonus['money']:0.00,
            'message'      => $data['message'] ? $data['message'] : '',
		);
        
        //插入订单
        $order_id = $this->getModel()->add($order_info);
        
        if ($order_id)
        {
            //订单生成成功之后，扣除用户的积分和改变优惠券的使用状态
			//改变优惠券使用状态
            model('UserBonus')->getDb()->where(array('user_id'=>$data['user_id'],'id'=>$data['user_bonus_id']))->update(array('status'=>1,'used_time'=>time()));
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
                    'goods_id' => $v->goods_id,
                    'goods_name' => $v->title,
                    'goods_number' => $v->goods_number,
                    'market_price' => $v->market_price,
                    'goods_price' => $v->final_price,
                    //'goods_attr' => '', //商品属性，预留
                    'goods_img' => $v->litpic
                );
                array_push($order_goods_list,$temp_order_goods);
                
                //订单商品直接减库存操作
				model('Goods')->changeGoodsStock(array('goods_id'=>$v->goods_id,'goods_number'=>$v->goods_number));
            }
            $result = model('OrderGoods')->add($order_goods_list,1);
            if($result)
            {
                //删除购物对应的记录
                model('Cart')->getDb()->where(array('user_id'=>$data['user_id']))->whereIn('id', explode("_",$data['cartids']))->delete();
                
                return ReturnData::create(ReturnData::SUCCESS, $order_id);
            }
            else
            {
                return ReturnData::create(ReturnData::SYSTEM_FAIL,null,'订单商品添加失败');
            }
        }
        
        return ReturnData::create(ReturnData::SYSTEM_FAIL,null,'生成订单失败');
    }
    
    //修改
    public function edit($data, $where = array())
    {
        if(empty($data)){return ReturnData::create(ReturnData::SUCCESS);}
        
        $validator = $this->getValidate($data, 'edit');
        if ($validator->fails()){return ReturnData::create(ReturnData::PARAMS_ERROR, null, $validator->errors()->first());}
        
        $res = $this->getModel()->edit($data,$where);
        if($res){return ReturnData::create(ReturnData::SUCCESS,$res);}
        
        return ReturnData::create(ReturnData::FAIL);
    }
    
    //删除
    public function del($where)
    {
        if(empty($where)){return ReturnData::create(ReturnData::PARAMS_ERROR);}
        
        $validator = $this->getValidate($where,'del');
        if ($validator->fails()){return ReturnData::create(ReturnData::PARAMS_ERROR, null, $validator->errors()->first());}
        
        $where2 = function ($query) use ($where) {
            $query->where($where)->where(function ($query2) {$query2->where(array('order_status'=>3,'refund_status'=>0))->orWhere(array('order_status'=>1))->orWhere(array('order_status'=>2));});
        };
        
        $data['is_delete'] = 1;
        $res = $this->getModel()->edit($data, $where2);
        if($res){return ReturnData::create(ReturnData::SUCCESS,$res);}
        
        return ReturnData::create(ReturnData::FAIL);
    }
    
    /**
     * 用户-取消订单
     * @param int $data['id'] 订单id
     * @param int $data['user_id'] 用户id
     * @return array
     */
    public function userCancelOrder($where = array())
    {
        if(empty($where)){return ReturnData::create(ReturnData::SUCCESS);}
        
        $where['order_status'] = 0;
        $where['pay_status'] = 0;
        $order = $this->getModel()->getOne($where);
        if(!$order){return ReturnData::create(ReturnData::PARAMS_ERROR,null,'订单不存在');}
        
        $data['order_status'] = 1;
        $data['updated_at'] = time();
        $res = $this->getModel()->edit($data,$where);
        if($res){return ReturnData::create(ReturnData::SUCCESS,$res);}
        
        return ReturnData::create(ReturnData::FAIL);
    }
    
    /**
     * 订单-余额支付
     * @param int $data['id'] 订单id
     * @param int $data['user_id'] 用户id
     * @return array
     */
    public function orderYuepay($where = array())
    {
        if(empty($where)){return ReturnData::create(ReturnData::SUCCESS);}
        
        $where['order_status'] = 0;
        $where['pay_status'] = 0;
        $order = $this->getModel()->getOne($where);
        if(!$order){return ReturnData::create(ReturnData::PARAMS_ERROR,null,'订单不存在');}
        
        DB::beginTransaction();
        
        $data['pay_status'] = 1;
        $data['pay_money'] = $order->order_amount; //支付金额
        $data['pay_id'] = 1;
        $data['pay_time'] = time();
        $data['updated_at'] = time();
        $res = $this->getModel()->edit($data,$where);
        if($res)
        {
            $user_money_data['user_id'] = $where['user_id'];
            $user_money_data['type'] = 1;
            $user_money_data['money'] = $order->order_amount;
            $user_money_data['des'] = '订单余额支付';
            if(!logic('UserMoney')->add($user_money_data)){DB::rollBack();}
            
            DB::commit();
            return ReturnData::create(ReturnData::SUCCESS,$res,'支付成功');
        }
        
        DB::rollBack();
        return ReturnData::create(ReturnData::FAIL);
    }
    
    /**
     * 订单-确认收货
     * @param int $data['id'] 订单id
     * @param int $data['user_id'] 用户id
     * @return array
     */
    public function orderReceiptConfirm($where = array())
    {
        if(empty($where)){return ReturnData::create(ReturnData::PARAMS_ERROR);}
        
        //判断订单是否存在或本人
        $where['order_status'] = 0;
        $where['refund_status'] = 0;
        $where['pay_status'] = 1;
        $order = $this->getModel()->getOne($where);
        if(!$order){return ReturnData::create(ReturnData::PARAMS_ERROR,null,'订单不存在');}
        
        $data['order_status'] = 3;
        $data['shipping_status'] = 2;
        $data['refund_status'] = 0;
        $data['is_comment'] = 0;
        $data['updated_at'] = time();
        $res = $this->getModel()->edit($data,$where);
        if($res)
        {
            return ReturnData::create(ReturnData::SUCCESS);
        }
        
        return ReturnData::create(ReturnData::FAIL);
    }
    
    /**
     * 订单-退款退货
     * @param int $data['id'] 订单id
     * @param int $data['user_id'] 用户id
     * @return array
     */
    public function orderRefund($where = array())
    {
        if(empty($where)){return ReturnData::create(ReturnData::PARAMS_ERROR);}
        
        $where['order_status'] = 3;
        $where['refund_status'] = 0;
        $order = $this->getModel()->getOne($where);
        if(!$order){return ReturnData::create(ReturnData::PARAMS_ERROR,null,'订单不存在');}
        
        $data['refund_status'] = 1;
        $data['updated_at'] = time();
        $res = $this->getModel()->edit($data,$where);
        if($res)
        {
            return ReturnData::create(ReturnData::SUCCESS);
        }
        
        return ReturnData::create(ReturnData::FAIL);
    }
    
    /**
     * 订单-设为评价
     * @param int $data['id'] 订单id
     * @param int $data['user_id'] 用户id
     * @return array
     */
    public function orderSetComment($where = array())
    {
        if(empty($where)){return ReturnData::create(ReturnData::PARAMS_ERROR);}
        
        $where['order_status'] = 3;
        $where['refund_status'] = 0;
        $data['is_comment'] = Order::ORDER_UN_COMMENT;
        $order = $this->getModel()->getOne($where);
        if(!$order){return ReturnData::create(ReturnData::PARAMS_ERROR,null,'订单不存在，或已评价');}
        
        $data['is_comment'] = Order::ORDER_IS_COMMENT;
        $data['updated_at'] = time();
        $res = $this->getModel()->edit($data,$where);
        if($res)
        {
            return ReturnData::create(ReturnData::SUCCESS);
        }
        
        return ReturnData::create(ReturnData::FAIL);
    }
    
    /**
     * 数据获取器
     * @param array $data 要转化的数据
     * @return array
     */
    private function getDataView($data = array())
    {
        return getDataAttr($this->getModel(),$data);
    }
}