<?php

namespace App\GatewayWorker;

use GatewayWorker\Lib\Gateway;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Common\ReturnData;
use App\Common\Helper;

class Events
{
    /**
     * 当businessWorker进程启动时触发，每个进程生命周期内都只会触发一次
     * 可以在这里为每一个businessWorker进程做一些全局初始化工作，例如设置定时器，初始化redis等连接等
     * 不要在onWorkerStart内执行长时间阻塞或者耗时的操作，这样会导致BusinessWorker无法及时与Gateway建立连接，造成应用异常
     * @param mixed $worker Worker对象
     */
    public static function onWorkerStart($businessWorker)
    {
        echo "onWorkerStart\r\n";
    }

    /**
     * 当客户端连接上gateway进程时(TCP三次握手完毕时)触发的回调函数
     * onConnect事件仅仅代表客户端与gateway完成了TCP三次握手，这时客户端还没有发来任何数据，此时除了通过$_SERVER['REMOTE_ADDR']获得对方ip，没有其他可以鉴别客户端的数据或者信息，所以在onConnect事件里无法确认对方是谁。要想知道对方是谁，需要客户端发送鉴权数据，例如某个token或者用户名密码之类，在onMesssge里做鉴权
     * @param int $client_id
     */
    public static function onConnect($client_id)
    {
        echo "onConnect\r\n";
        Gateway::sendToClient($client_id, json_encode(['type' => 'onConnect', 'client_id' => $client_id]));
    }

    /**
     * 当客户端连接上gateway完成websocket握手时触发的回调函数
     * 注意：此回调只有gateway为websocket协议并且gateway没有设置onWebSocketConnect时才有效
     * @param int $client_id
     * @param mixed $data websocket握手时的http头数据，包含get、server等变量
     */
    public static function onWebSocketConnect($client_id, $data)
    {
        Log::info('onWebSocketConnect，client_id:' . $client_id . '-' . json_encode($data));
        echo "onWebSocketConnect\r\n";
        if (!isset($data['get']['token'])) {
            echo "closeClient\r\n";
            return Gateway::closeClient($client_id);
        }
        $access_token = $data['get']['token'];
        //通过client_id绑定用户ID
        $res = self::bing_client($client_id, ['access_token' => $access_token]);
        if ($res['code'] != ReturnData::SUCCESS) {
            return Gateway::sendToClient($client_id, json_encode($res));
        }
        Gateway::sendToClient($client_id, json_encode(ReturnData::create(ReturnData::SUCCESS)));
    }

    /**
     * 有消息时
     * @param int $client_id 发消息的client_id
     * @param mixed $message 完整的客户端请求数据，数据类型取决于Gateway所使用协议的decode方法返的回值类型
     */
    public static function onMessage($client_id, $data)
    {
        echo "onMessage\r\n";
        // Debug输出
        echo "client:{$_SERVER['REMOTE_ADDR']}:{$_SERVER['REMOTE_PORT']} gateway:{$_SERVER['GATEWAY_ADDR']}:{$_SERVER['GATEWAY_PORT']}  client_id:$client_id session:" . json_encode($_SESSION) . " onMessage:" . $message . "\n";

        // data = {"type":"login", "uid":"666"}
        $data = json_decode($data, true);
        Log::info('onMessage，client_id:' . $client_id . '-' . json_encode($data));

        // 没有传消息类型视为非法请求，关闭连接
        if (!isset($data['type'])) {
            return Gateway::closeClient($client_id);
        }

        $uid = Gateway::getUidByClientId($client_id);

        // 判断绑定的UID为空，消息类型不是心跳视为非法请求，关闭连接
        if (empty($uid) && $data['type'] !== 'heart') {
            return Gateway::closeClient($client_id);
        }

        switch ($data['type']) {
            case 'heart': //心跳回复
                Gateway::sendToCurrentClient(json_encode(ReturnData::create(ReturnData::SUCCESS)));
                break;
            default:
                Gateway::sendToCurrentClient(json_encode(ReturnData::create(ReturnData::PARAMS_ERROR)));
        }
    }

    /**
     * 当客户端断开连接时
     * @param integer $client_id 断开连接的客户端client_id
     * @return void
     */
    public static function onClose($client_id)
    {
        // debug
        echo "client:{$_SERVER['REMOTE_ADDR']}:{$_SERVER['REMOTE_PORT']} gateway:{$_SERVER['GATEWAY_ADDR']}:{$_SERVER['GATEWAY_PORT']} client_id:$client_id onClose:''\n";

        Log::info('Workerman close connection，client_id:' . $client_id);
        echo "onClose\r\n";
    }

    /**
     * 通过client_id绑定用户ID
     * @param int $client_id
     * @param mixed $message ['access_token']
     */
    public static function bing_client($client_id, $message)
    {
        if (!Gateway::isOnline($client_id)) {
            return ReturnData::create(ReturnData::PARAMS_ERROR, null, 'client_id错误');
        }

        //client_id绑定用户ID
        $token = DB::table('token')->where(['token' => $message['access_token']])->first();
        if (!$token) {
            return ReturnData::create(ReturnData::PARAMS_ERROR, null, '鉴权失败');
        }
        Gateway::bindUid($client_id, $token->uid);

        return ReturnData::create(ReturnData::SUCCESS);
    }

}
