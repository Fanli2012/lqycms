<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class SendEmail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'email:send {user}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send e-mail to a user';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
		// 获取指定参数
		// $user_id = $this->argument('user');

		// 获取指定选项
		// $user_id = $this->option('user');
    }
}