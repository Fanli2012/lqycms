<?php
namespace App\Http\Model;

//短信发送记录
class SmsLog extends BaseModel
{
    const SUCCESS = 1;
    const FAIL    = 2;
    
    protected $table = 'sms_log';
    public $guarded = [];
    
    public static function success($mobile, $text, $result)
    {
        self::create([
            'mobile' => $mobile,
            'text'   => $text,
            'status' => self::SUCCESS,
            'result' => json_encode($result)
        ]);
    }

    public static function fail($mobile, $text, $result)
    {
        self::create([
            'mobile' => $mobile,
            'text'   => $text,
            'status' => self::FAIL,
            'result' => json_encode($result)
        ]);
    }
}