<?php
namespace App\Http\Model;
use DB;

class OrderGoods extends BaseModel
{
	//产品模型
	
    /**
     * 关联到模型的数据表
     *
     * @var string
     */
	protected $table = 'order_goods';
	
	/**
     * 表明模型是否应该被打上时间戳
     * 默认情况下，Eloquent 期望 created_at 和updated_at 已经存在于数据表中，如果你不想要这些 Laravel 自动管理的数据列，在模型类中设置 $timestamps 属性为 false
	 * 
     * @var bool
     */
    public $timestamps = false;
    
    //获取退货状态文字：0无退货，1退款中，2退款成功，3不同意退款
    public static function getRefundStatusText($where)
    {
        $res = '';
        if($where['refund_status'] == 0)
        {
            $res = '无退货';
        }
        elseif($where['refund_status'] == 1)
        {
            $res = '退款中';
        }
        elseif($where['refund_status'] == 2)
        {
            $res = '退款成功';
        }
        elseif($where['refund_status'] == 3)
        {
            $res = '不同意退款';
        }
        
        return $res;
    }
}