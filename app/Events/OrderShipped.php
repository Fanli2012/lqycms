<?php

namespace App\Events;

use App\Http\Model\Order;
use Illuminate\Queue\SerializesModels;

class OrderShipped
{
    use SerializesModels;

	public $order_id;

    /**
     * 创建一个新的事件实例
     *
     * @param Order $order
     * @return void
     */
    public function __construct($order_id)
    {
        $this->order_id = $order_id;
		\Log::info('----OrderShipped Event Init----');
    }
}