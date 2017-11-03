<?php
namespace App\Common;

/**
  * OAuth2.0微信授权登录实现
  *
  * @author FLi
  * @文件名：GetWxUserInfo.php
  */
class WechatAuth
{
	//高级功能->开发者模式->获取
    private $app_id = 'xxx';
    private $app_secret = 'xxxxxxx';
	
	//$registration_id = getenv('registration_id');
	
    public static function send($msg, $param='')
    {
        $client = new JPushMsg(self::APP_KEY, self::APP_SECRET, null);
		
		$push_payload = $client->push();
		$push_payload = $push_payload->setPlatform('all');
		if(isset($param['mobile'])){$push_payload = $push_payload->addAlias(md5($param['mobile']));}
		$push_payload = $push_payload->addAllAudience();
		$push_payload = $push_payload->setNotificationAlert($msg);
		
		try
		{
			$push_payload->send();
		}
		catch (JPushMsg\Exceptions\APIConnectionException $e)
		{
			Log::info($e);
			return false;
		}
		catch (JPushMsg\Exceptions\APIRequestException $e)
		{
			Log::info($e);
			return false;
		}
		
		return true;
    }
}