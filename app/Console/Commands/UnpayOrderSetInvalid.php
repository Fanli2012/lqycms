<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use DB;
use Log;

class UnpayOrderSetInvalid extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'unpay_order_set_invalid';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '订单24小时未支付，设为无效订单';

    // 订单多久超时，单位：秒
    protected $timeout = 86400;

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        DB::table('order')->where([['order_status', '=', 0], ['is_delete', '=', 0], ['add_time', '<', (time() - $timeout)]])->update(['order_status' => 2]);
        Log::info('订单24小时未支付，设为无效订单：操作成功');
    }
}