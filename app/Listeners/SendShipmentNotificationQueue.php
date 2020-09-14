<?php

namespace App\Listeners;

use App\Events\OrderShipped;
use Illuminate\Contracts\Queue\ShouldQueue;

// 事件监听器队列
class SendShipmentNotificationQueue implements ShouldQueue
{
    /**
     * 创建事件监听器
     *
     * @return void
     */
    public function __construct()
    {
        \Log::info('----SendShipmentNotificationQueue Listeners Init----');
    }

    /**
     * 处理事件
     *
     * @param  OrderShipped  $event
     * @return void
     */
    public function handle(OrderShipped $event)
    {
		\Log::info('----SendShipmentNotificationQueue Listeners handle----');
    }

	// 处理失败任务
	public function failed(OrderShipped $event, $exception)
    {
        //
    }
}