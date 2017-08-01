<?php
namespace App\Common;
use DB;

class Token
{
    const TYPE_APP     = 0;
    const TYPE_ADMIN   = 1;
    const TYPE_WEIXIN  = 2;
    const TYPE_WAP     = 3;
    const TYPE_PC      = 4;
	
    // 已验证的type
    public static $type;
    // 验证为token时的uid
    public static $uid;
    // 验证为sign时的app.id
    public static $app;
    // 已验证的data
    public static $data = [];
	
    /**
     * 验证token
     * 
     * @param $token
     * 
     * @return bool
     */
    public static function checkToken($token)
    {
        $token = DB::table('token')->where('token', $token)->first();
		
        if ($token)
		{
            self::$type = $token->type;
            self::$uid  = $token->uid;
            self::$data = $token->data ? json_decode($token->data, true) : [];
        }
		
        return $token ? true : false;
    }
	
    /**
     * 验证sign，
     * sign生成方式：md5(app_key + app_secret + time)
     * 必传参数：app_key, sign, sign_time
     * 
     * @param $appKey
     * @param $signTime
     * @param $sign
     * 
     * @return bool
     */
    public static function checkSign($appKey, $signTime, $sign)
    {
        if (!$appRes = DB::table('appsign')->where('app_key', $appKey)->first())
		{
            return false;
        }

        //验证sign
        $newSign = md5($appKey . $appRes->app_secret . $signTime);
        if ($sign == $newSign)
		{
            self::$type = self::TYPE_ADMIN;
            self::$app  = $appRes;
            return true;
        }
		
        return false;
    }
	
    /**
     * 生成token
     *
     * @param $type
     * @param $uid
     * @param $data
     *
     * @return string
     */
    public static function getToken($type, $uid, $data = [])
    {
        //支持多账号登录
        if ($token = DB::table('token')->where(['type' => $type, 'uid' => $uid])->orderBy('id', 'desc')->first())
		{
            if($data == $token->data && strtotime($token->expired_at)>time())
			{
                return $token->token;
            }
        }

        //生成新token
        $token = md5($type . '-' . $uid . '-' . microtime() . rand(0, 9999));
        DB::table('token')->insert([
            'token'      => $token,
            'type'       => $type,
            'uid'        => $uid,
            'data'       => $data ? json_encode($data) : '',
            'expired_at' => date('Y-m-d H:i:s')
        ]);
		
        return $token;
    }
}