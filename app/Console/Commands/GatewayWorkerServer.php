<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use GatewayWorker\BusinessWorker;
use GatewayWorker\Gateway;
use GatewayWorker\Register;
use Workerman\Worker;

class GatewayWorkerServer extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'gateway-worker {action} {--d}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Start a GatewayWorker server.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        global $argv;
        $action = $this->argument('action');
        if (!in_array($action, ['start', 'stop', 'restart', 'reload', 'status'])) {
            exit('Arguments Error');
        }

        $argv[0] = 'artisan gateway-worker';
        $argv[1] = $action;
        $argv[2] = $this->option('d') ? '-d' : '';   //必须是一个-，上面定义命令两个--，后台启动用两个--

        $this->start();
    }

    private function start()
    {
        $this->startGateWay();
        $this->startBusinessWorker();
        $this->startRegister();
        Worker::runAll();
    }

    private function startBusinessWorker()
    {
        $worker = new BusinessWorker();
        $worker->name = 'BusinessWorker';
        $worker->count = 1;
        $worker->registerAddress = '127.0.0.1:1236';
        $worker->eventHandler = \App\GatewayWorker\Events::class; //设置使用哪个类来处理业务,业务类至少要实现onMessage静态方法，onConnect和onClose静态方法可以不用实现
    }

    private function startGateWay()
    {
        $gateway = new Gateway("websocket://0.0.0.0:2346");
        $gateway->name = 'Gateway'; //设置BusinessWorker进程的名称
        $gateway->count = 1; //设置BusinessWorker进程的数量
        $gateway->lanIp = '127.0.0.1'; #内网ip,多服务器分布式部署的时候需要填写真实的内网ip
        $gateway->startPort = 2300; //监听本机端口的起始端口
        $gateway->pingInterval = 30; //心跳间隔时间(秒)
        $gateway->pingNotResponseLimit = 0; //心跳检测的时间间隔数
        $gateway->pingData = '{"type":"ping"}'; //心跳消息
        $gateway->registerAddress = '127.0.0.1:1236'; //注册服务地址
    }

    private function startRegister()
    {
        new Register('text://0.0.0.0:1236');
    }

    private function init()
    {

    }

    //php artisan gateway-worker start --d之后，打开浏览器F12将内容复制到console里return就行
    /* ws = new WebSocket("ws://127.0.0.1:2346?token=123456");
    ws.onopen = function() {
        ws.send('{"name":"one","user_id":"111"}');
        ws.send('{"name":"two","user_id":"222"}');
        //定义一个定时器，每10秒钟发送一个包，包的内容随意，一般发送心跳包的间隔在60秒以内
        setInterval(function () {
            ws.send('{"type":"heart","msg":"Heartbeat reply"}');
        }, 10000);
     };
     ws.onmessage = function(e) {
        console.log("收到服务端的消息：" + e.data);
     };
     ws.onclose = function(e) {
        console.log("服务已断开" );
     }; */
}
