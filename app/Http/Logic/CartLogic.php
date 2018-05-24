<?php
namespace App\Http\Logic;
use App\Common\ReturnData;
use App\Http\Model\Cart;
use App\Http\Model\Goods;
use App\Http\Requests\CartRequest;
use Validator;

class CartLogic extends BaseLogic
{
    public function __construct()
    {
        parent::__construct();
    }
    
    public function getModel()
    {
        return model('Cart');
    }
    
    public function getValidate($data, $scene_name)
    {
        //数据验证
        $validate = new CartRequest();
        return Validator::make($data, $validate->getSceneRules($scene_name), $validate->getSceneRulesMessages());
    }
    
    //列表
    public function getList($where = array(), $order = '', $field = '*', $offset = '', $limit = '')
    {
        $model = $this->getModel()->getDb();
        
        $model = $model->join('goods', 'goods.id', '=', 'cart.goods_id')
            ->where('cart.user_id', $where['user_id'])
            ->where('goods.status', Goods::GOODS_NORMAL_STATUS)
            ->select('cart.*','goods.id as goods_id','goods.title','goods.sn','goods.price as goods_price','goods.market_price','goods.litpic','goods.goods_number as stock','goods.promote_start_date','goods.promote_price','goods.promote_end_date');
            
        $res['count'] = $model->count();
        $res['list'] = array();
        
        if($res['count']>0)
        {
            $res['list'] = $model->get();
            
            foreach ($res['list'] as $k => $v) 
            {
                $res['list'][$k]->is_promote = 0;
                if(model('Goods')->bargain_price($v->goods_price,$v->promote_start_date,$v->promote_end_date) > 0){$res['list'][$k]->is_promote = 1;}
                
                //订货数量大于0
                if ($v->goods_number > 0)
                {
                    $goods_tmp = ['price'=>$v->goods_price,'promote_price'=>$v->promote_price,'promote_start_date'=>$v->promote_start_date,'promote_end_date'=>$v->promote_end_date];
                    $res['list'][$k]->final_price = model('Goods')->get_goods_final_price((object)$goods_tmp);   //商品最终价格
                    $res['list'][$k]->goods_detail_url = route('weixin_goods_detail',array('id'=>$v->goods_id));
                    
                    //更新购物车中的商品数量
                    //self::where('id', $v->id)->update(array('price' => $goods_price));
                }
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
        
        return $res;
    }
    
    //添加
    public function add($data = array(), $type=0)
    {
        if(empty($data)){return ReturnData::create(ReturnData::PARAMS_ERROR);}
        
        $validator = $this->getValidate($data, 'add');
        if ($validator->fails()){return ReturnData::create(ReturnData::PARAMS_ERROR, null, $validator->errors()->first());}
        
        //获取商品信息
        $goods = model('Goods')->getDb()->where(['id' => $data['goods_id'], 'status' => Goods::GOODS_NORMAL_STATUS])->first();
        
        if (!$goods)
        {
            return ReturnData::create(ReturnData::PARAMS_ERROR,null,'商品不存在');
        }
        
        //判断库存 是否足够
        if($goods->goods_number<$data['goods_number'])
        {
            return ReturnData::create(ReturnData::PARAMS_ERROR,null,'库存不足');
        }
        
        //判断购物车商品数
        if(Cart::where(['user_id'=>$data['user_id']])->count() >= 20)
        {
            return ReturnData::create(ReturnData::PARAMS_ERROR,null,'购物车商品最多20件');
        }
        
        //查看是否已经有购物车插入记录
        $where = array(
            'user_id'	=> $data['user_id'],
            'goods_id'	=> $data['goods_id']
        );
        
        $cart = Cart::where($where)->first();
        
        if($cart)
        {
            //更新购物车
            $updateArr = array(
                'goods_number'		=> $data['goods_number'],
                'add_time'			=> time(),
            );
            
            Cart::where(array('id'=>$cart->id))->update($updateArr);
            
            $cart_id = $cart->id;
        }
        else
        {
            //添加购物车
            $cartInsert = array(
                'user_id'			=> $data['user_id'],
                'goods_id'			=> $data['goods_id'],
                'goods_number'		=> $data['goods_number'],
                'add_time'			=> time(),
            );
            
            $cart_id = Cart::insertGetId($cartInsert);
        }
        
        if(isset($cart_id) && $cart_id){return ReturnData::create(ReturnData::SUCCESS,$cart_id,'购物车添加成功');}
        
        return ReturnData::create(ReturnData::SYSTEM_FAIL);
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
        
        $res = $this->getModel()->del($where);
        if($res){return ReturnData::create(ReturnData::SUCCESS,$res);}
        
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
    
    //购物车结算商品列表
    public function cartCheckoutGoodsList($where)
    {
        $cartIds = explode("_",$where['ids']);
        
        // 获取购物车列表
    	$cartList = Cart::where(array('user_id'=>$where['user_id']))->whereIn('id', $cartIds)->get();
        $total_price = 0; //商品总金额
        $total_goods = 0; //商品总数量
        
        if($cartList)
        {
    		$resultList = array();
    		$checkArr = array();
            
            foreach($cartList as $k=>$v)
            {
                $goods = Goods::where(array('id'=>$v['goods_id']))->first();
                
                $cartList[$k]->is_promote = 0;
                if(model('Goods')->bargain_price($goods->price,$goods->promote_start_date,$goods->promote_end_date) > 0){$cartList[$k]->is_promote = 1;}
                
                $cartList[$k]->final_price = model('Goods')->get_goods_final_price($goods); //商品最终价格
                $cartList[$k]->goods_detail_url = route('weixin_goods_detail',array('id'=>$v['goods_id']));
                $cartList[$k]->title = $goods->title;
                $cartList[$k]->litpic = $goods->litpic;
                $cartList[$k]->market_price = $goods->market_price;
                $cartList[$k]->goods_sn = $goods->sn;
                
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