<?php

namespace App\Http\Controllers\Wap;

use App\Http\Controllers\Controller;

class CommonController extends Controller
{
    /**
     * 初始化
     * @param void
     * @return void
     */
    public function __construct()
    {
        parent::__construct();

        // 添加操作记录
        $this->operation_log_add();
    }

    // 添加操作记录
    public function operation_log_add($login_info = [])
    {
        $time = time();
        // 记录操作
        if ($login_info) {
            $data['login_id'] = $login_info['id'];
            $data['login_name'] = $login_info['user_name'];
        }
        $data['type'] = 4;
        $data['ip'] = request()->ip();
        $data['url'] = mb_strcut(request()->url(), 0, 255, 'UTF-8');
        $data['http_method'] = request()->method();
        $data['domain_name'] = mb_strcut($_SERVER['SERVER_NAME'], 0, 60, 'UTF-8');
        if ($data['http_method'] != 'GET') {
            $data['content'] = mb_strcut(json_encode(request()->toArray(), JSON_UNESCAPED_SLASHES), 0, 255, 'UTF-8');
        }
        if (!empty($_SERVER['HTTP_REFERER'])) {
            $data['http_referer'] = mb_strcut($_SERVER['HTTP_REFERER'], 0, 255, 'UTF-8');
        }
        $data['add_time'] = $time;
        logic('Log')->add($data);
    }
}
