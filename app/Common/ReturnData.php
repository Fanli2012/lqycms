<?php
namespace App\Common;

class ReturnData
{
    //通用
    const SUCCESS               = 0;    //操作成功
    const FAIL                  = 1;    //操作失败
    const FORBIDDEN             = 8001; //权限不足
    const SYSTEM_FAIL           = 8002; //系统错误，如数据写入失败之类的
    const PARAMS_ERROR          = 8003; //参数错误
    const NOT_FOUND             = 8004; //资源未找到
    const TOKEN_ERROR           = 8005; //token错误
    const SIGN_ERROR            = 8006; //签名错误
    const RECORD_EXIST          = 8007; //记录已存在
    const RECORD_NOT_EXIST      = 8008; //记录不存在
    const NOT_MODIFY            = 8009; //没有变动
    const UNKNOWN_ERROR         = 8010; //未知错误
	const INVALID_VERIFYCODE    = 8011; //无效验证码
    
    //参数相关
    const EMAIL_EXIST           = 8201; //邮箱已存在
    const EMAIL_FORMAT_FAIL     = 8202; //邮箱格式不对正确
    const MOBILE_NOT_FIND       = 8204; //手机号码不存在
    const MOBILE_HAS_MORE       = 8205; //存在多个手机号码
    const NAME_EXIST            = 8206; //名称已被使用
    const MOBILE_EXIST          = 8207; //手机号已存在
    const NOT_UP_GRADE          = 8208; //不符合升级条件
    const NOT_DOWN_GRADE        = 8209; //不符合降级条件

    //登录、账号相关
    const USERNAME_REQUIRED      = 8401; //登录账号为必填
    const PASSWORD_REQUIRED      = 8402; //登录密码为必填
    const USERNAME_EXIST         = 8403; //登录账号已被使用
    const ADMINNAME_REQUIRED     = 8404; //管理员姓名不能为空
    const PASSWORD_NOT_MATCH     = 8405; //密码错误
    const OLD_PASSWORD_NOT_MATCH = 8406; //旧密码不匹配
    const PASSWORD_CONFIRM_FAIL  = 8407; //两次输入的密码不匹配
    const PASSWORD_FORMAT_FAIL   = 8408; //密码格式不对
    const APPLY_SIGN_FAIL        = 8510; //注册邀请码错误
	
    //验证码
    const CODE_NOT_EXIST    = 8801; //当前状态不能操作
	
    //app
    const AUTH_FAIL = 9001; //鉴权失败
    const TOKEN_EXP = 9002; //Token失效
    const MOBILE_FORMAT_FAIL    = 9003; //手机格式不正确
    const VERIFY_TYPE_FAIL    = 9004; //验证码业务类型无效
    const BANK_TYPE_FAIL    = 9005; //该银行不支持
    const INVALID_IDCARD = 9006;//身份证无效
    const REQUEST_AMOUNT_MIN_LESS = 9007;//小于最小提现金额
    const SERVICE_AMOUNT_NOT_ENOUGH = 9008;//可提现余额不足

    //中文错误详情
    public static $codeTexts = array(
        0    => '操作成功',
        1    => '操作失败',
        8001 => '权限不足',
        8002 => '系统错误，请联系管理员',
        8003 => '参数错误',
        8004 => '资源未找到',
        8005 => 'token错误',
        8006 => '签名错误',
        8007 => '记录已存在',
        8008 => '记录不存在',
        8009 => '没有变动',
        8010 => '未知错误',
        8011 => '无效验证码',
        
        //参数错误
        8201 => '邮箱已存在',
        8202 => '邮箱格式不对正确',
        8204 => '手机号码不存在',
        8205 => '存在多个手机号码',
        8206 => '名称已被使用',
        8207 => '手机号已存在',
        8208 => '不符合升级条件',
        8209 => '不符合降级条件',
        //登录、账号相关
        8401 => '登录账号为必填',
        8402 => '登录密码为必填',
        8403 => '登录账号已被使用',
        8404 => '管理员姓名不能为空',
        8405 => '登录失败',
        8406 => '原密码不匹配',
        8407 => '两次输入的密码不匹配',
        8408 => '密码格式错误，请输入%s到%s位字符',
        8510 => '注册邀请码不存在或已被使用',
        //app
        9001 => '鉴权失败',
        9002 => 'Token失效',
        9003 => '手机格式不正确',
        9004 => '验证码业务类型无效',
        9005 => '该银行不支持',
        9006 => '身份证无效',
        9007 => '小于最小提现金额',
        9008 => '可提现余额不足',
        //验证码
        8801 =>'验证码无效',
	);
    
    public static function create($code, $data = null, $msg = '')
    {
        if (empty($msg) && isset(self::$codeTexts[$code]))
		{
            $msg = self::$codeTexts[$code];
        }
        
        return self::custom($code, $msg, $data);
    }

    public static function success($data = null, $msg = '')
    {
        
        if (empty($msg) && isset(self::$codeTexts[self::SUCCESS]))
		{
            $msg = self::$codeTexts[self::SUCCESS];
        }
		
        return self::custom(self::SUCCESS, $msg, $data);
    }

    public static function error($code, $data = null, $msg = '')
    {
        if (empty($msg) && isset(self::$codeTexts[$code]))
		{
            $msg = self::$codeTexts[$code];
        }

        if ($code == self::SUCCESS)
		{
            $code = self::SYSTEM_FAIL;
            $msg  = '系统错误';
        }
		
        return self::custom($code, $msg, $data);
    }
    
    public static function custom($code, $msg = '', $data = null)
    {
        return array('code' => $code, 'msg' => $msg, 'data' => $data);
    }
    
    //判断是否成功
    public static function checkSuccess($data)
    {
        if ($data['code'] == self::SUCCESS){return true;}
        
        return false;
    }
    
    public static function getCodeText($code)
    {
        $res = '';
        if (isset(self::$codeTexts[$code]))
		{
            $res = self::$codeTexts[$code];
        }
        
        return $res;
    }
}