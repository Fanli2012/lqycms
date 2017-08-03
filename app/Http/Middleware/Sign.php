<?php
namespace App\Http\Middleware;

use Closure;
use App\Common\ReturnData;
use App\Common\Token;

class Sign
{
    /**
     * Sign验证
     */
    public function handle($request, Closure $next)
    {
		$app_key  = $request->header('app_key') ?: $request->input('app_key');
        $app_time = $request->header('app_time') ?: $request->input('app_time');
        $sign     = $request->header('sign') ?: $request->input('sign');
        
        if (empty($app_key) || empty($app_time) || empty($sign))
		{
            return ReturnData::create(ReturnData::FORBIDDEN);
        }

        if (!Token::checkSign($app_key, $app_time, $sign))
		{
            return ReturnData::create(ReturnData::SIGN_ERROR);
        }
		
        return $next($request);
    }
}