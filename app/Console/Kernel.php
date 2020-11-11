<?php

namespace App\Console;

use DB;
use Log;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Console\Commands\GatewayWorkerServer;

class Kernel extends ConsoleKernel
{
	/**
     * 应用提供的Artisan命令
     * 
     * @var array
     */
    protected $commands = [
        GatewayWorkerServer::class,
        Commands\UnpayOrderSetInvalid::class,
        Commands\SendEmail::class,
    ];

	/**
     * 定义应用的命令调度
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
		Log::info('----Schedule----');
		// 使用 command 方法通过命令名或类来调度一个 Artisan 命令
        // $schedule->command('unpay_order_set_invalid')->hourly();
		// 使用 exec 命令可用于发送命令到操作系统
		// $schedule->exec('node /home/forge/script.js')->daily();
    }

    /**
     * Register the Closure based commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        require base_path('routes/console.php');
    }
}
