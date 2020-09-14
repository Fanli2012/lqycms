<?php

namespace App\Listeners;

use App\Events\OrderShipped;

class SendShipmentNotification
{
    /**
     * 创建事件监听器
     *
     * @return void
     */
    public function __construct()
    {
		\Log::info('----SendShipmentNotification Listeners Init----');
    }

    /**
     * 处理事件
     *
     * @param  OrderShipped  $event
     * @return void
     */
    public function handle(OrderShipped $event)
    {
        // 使用 $event->order 发访问订单
		\Log::info('----SendShipmentNotification Listeners handle----');
		\Log::info('order_id:' . $event->order_id);
    }
}