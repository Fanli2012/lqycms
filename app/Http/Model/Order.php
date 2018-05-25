<?php
namespace App\Http\Model;
use DB;
use Log;

class Order extends BaseModel
{
	//订单
	
    protected $table = 'order';
    public $timestamps = false;
    protected $hidden = array();
    protected $guarded = array(); //$guarded包含你不想被赋值的字段数组。
    
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
    
    //获取订单状态文字:1待付款，2待发货,3待收货,4待评价(确认收货，交易成功),5退款/售后,6已取消,7无效
    public function getOrderStatusAttr($data)
    {
        $res = '';
        if($data->order_status == 0 && $data->pay_status ==0)
        {
            $res = array('text'=>'待付款','num'=>1);
        }
        elseif($data->order_status == 0 && $data->shipping_status == 0 && $data->pay_status == 1)
        {
            $res = array('text'=>'待发货','num'=>2);
        }
        elseif($data->order_status == 0 && $data->refund_status == 0 && $data->shipping_status == 1 && $data->pay_status == 1)
        {
            $res = array('text'=>'待收货','num'=>3);
        }
        elseif($data->order_status == 3 && $data->refund_status == 0)
        {
            $res = array('text'=>'交易成功','num'=>4);
        }
        elseif($data->order_status == 3 && $data->refund_status == 1)
        {
            $res = array('text'=>'售后中','num'=>5);
        }
        elseif($data->order_status == 1)
        {
            $res = array('text'=>'已取消','num'=>6);
        }
        elseif($data->order_status == 2)
        {
            $res = array('text'=>'无效','num'=>7);
        }
        elseif($data->order_status == 3 && $data->refund_status == 2)
        {
            $res = array('text'=>'退款成功','num'=>8);
        }
        
        return $res;
    }
    
    //获取发票类型文字：0不索要发票，1个人，2企业
    public function getInvoiceAttr($data)
    {
        $arr = array(0 => '不索要发票', 1 => '个人', 2 => '企业');
        return $arr[$data->invoice];
    }
    
    //获取订单来源文字：1pc，2weixin，3app，4wap
    public function getPlaceTypeAttr($data)
    {
        $arr = array(0 => '未知', 1 => 'pc', 2 => 'weixin', 3 => 'app', 4 => 'wap');
        return $arr[$data->place_type];
    }
    
    //根据订单id返库存
    public function returnStock($order_id)
    {
        $order_goods = model('OrderGoods')->getDb()->where(array('order_id'=>$order_id))->get();
        if(!$order_goods){return false;}
        
        foreach($order_goods as $k=>$v)
        {
            //订单商品直接返库存
            model('Goods')->changeGoodsStock(array('goods_id'=>$v->goods_id,'goods_number'=>$v->goods_number,'type'=>1));
        }
        
        return true;
    }
    
    //订单超时，设为无效
    public function orderSetInvalid($order_id)
    {
        $order = self::where(array('id'=>$order_id,'order_status'=>0,'pay_status'=>0))->update(['order_status'=>2]);
        if(!$order){return false;}
        
        //返库存
        $this->returnStock($order_id);
        
        return true;
    }
    
    /**
     * 打印sql
     */
    public function toSql($where)
    {
        return $this->getDb()->where($where)->toSql();
    }
}