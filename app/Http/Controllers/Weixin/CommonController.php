<?php
namespace App\Http\Controllers\Weixin;

use App\Http\Controllers\Controller;
use App\Common\Helper;

class CommonController extends Controller
{
    protected $isWechatBrowser;
    
    public function __construct()
    {
        parent::__construct();
        
        $this->isWechatBrowser = Helper::isWechatBrowser();
        view()->share('isWechatBrowser', $this->isWechatBrowser);
    }
    
    /**
     * 操作错误跳转的快捷方法
     * @access protected
     * @param string $msg 错误信息
     * @param string $url 页面跳转地址
     * @param mixed $time 当数字时指定跳转时间
     * @return void
     */
    public function error_jump($msg='', $url='', $time=3)
    {
        if ($url=='' && isset($_SERVER["HTTP_REFERER"]))
        {
            $url = $_SERVER["HTTP_REFERER"];
        }
        
        if(!headers_sent())
        {
            header("Location:".route('weixin_jump')."?error=$msg&url=$url&time=$time");
            exit();
        }
        else
        {
            $str = "<meta http-equiv='Refresh' content='URL=".route('weixin_jump')."?error=$msg&url=$url&time=$time"."'>";
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
    public function success_jump($msg='', $url='', $time=1)
    {
        if ($url=='' && isset($_SERVER["HTTP_REFERER"]))
        {
            $url = $_SERVER["HTTP_REFERER"];
        }
        
        if(!headers_sent())
        {
            header("Location:".route('weixin_jump')."?message=$msg&url=$url&time=$time");
            exit();
        }
        else
        {
            $str = "<meta http-equiv='Refresh' content='URL=".route('weixin_jump')."?message=$msg&url=$url&time=$time"."'>";
            exit($str);
        }
    }
}