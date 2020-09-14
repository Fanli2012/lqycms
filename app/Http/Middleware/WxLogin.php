<?php

namespace App\Http\Middleware;

use Closure;

class WxLogin
{
    /**
     * 微信端登录验证
     */
    public function handle($request, Closure $next)
    {
        if (isset($_SESSION['weixin_user_info'])) {

        } else {
            header('Location: ' . route('weixin_login'));
            exit;
        }

        return $next($request);
    }
}