<?php
namespace App\Common;

use JPush\Client as JPushMsg;
use Illuminate\Support\Facades\Log;

//极光推送，"jpush/jpush": "v3.5.*"
class JPush
{
	const APP_KEY = 'b82cd9fcd0cbb92866d6d726';
	const APP_SECRET = 'ac92d336f90842051dc12f49';
	
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