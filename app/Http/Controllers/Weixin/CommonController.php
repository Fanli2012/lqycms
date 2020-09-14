<?php

namespace App\Http\Controllers\Weixin;

use App\Http\Controllers\Controller;
use App\Common\Helper;

class CommonController extends Controller
{
    protected $isWechatBrowser;
	protected $login_info;

    public function __construct()
    {
        parent::__construct();

        $this->isWechatBrowser = Helper::isWechatBrowser();
        view()->share('isWechatBrowser', $this->isWechatBrowser);

		$this->login_info = array();
		if (isset($_SESSION['weixin_user_info'])) {
			$this->login_info = $_SESSION['weixin_user_info'];
        }

		// 添加操作记录
		$this->operation_log_add();
    }

    /**
     * 操作错误跳转的快捷方法
     * @access protected
     * @param string $msg 错误信息
     * @param string $url 页面跳转地址
     * @param mixed $time 当数字时指定跳转时间
     * @return void
     */
    public function error_jump($msg = '', $url = '', $time = 3)
    {
        if ($url == '' && isset($_SERVER["HTTP_REFERER"])) {
            $url = $_SERVER["HTTP_REFERER"];
        }

        if (!headers_sent()) {
            header("Location:" . route('weixin_jump') . "?error=$msg&url=$url&time=$time");
            exit();
        } else {
            $str = "<meta http-equiv='Refresh' content='URL=" . route('weixin_jump') . "?error=$msg&url=$url&time=$time" . "'>";
            exit($str);
        }
    }

    /**
     * 操作成功跳转的快捷方法
     * @access protected
     * @param string $msg 提示信息
     * @param string $url 页面跳转地址
     * @param mixed $time 当数字时指定跳转时间
     * @return void
     */
    public function success_jump($msg = '', $url = '', $time = 1)
    {
        if ($url == '' && isset($_SERVER["HTTP_REFERER"])) {
            $url = $_SERVER["HTTP_REFERER"];
        }

        if (!headers_sent()) {
            header("Location:" . route('weixin_jump') . "?message=$msg&url=$url&time=$time");
            exit();
        } else {
            $str = "<meta http-equiv='Refresh' content='URL=" . route('weixin_jump') . "?message=$msg&url=$url&time=$time" . "'>";
            exit($str);
        }
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
        $data['type'] = 5;
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