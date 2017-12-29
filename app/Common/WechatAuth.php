<?php
namespace App\Common;

/**
 * OAuth2.0微信授权登录实现/微信PC扫码授权登录
 * 微信/PC扫码登录，两种的方式是一样的，先跳转到微信网页获取code，通过code获取token，通过token获取用户信息
 */
class WechatAuth
{
	//高级功能->开发者模式->获取
    private $app_id;
    private $app_secret;
	
	public function __construct($app_id, $app_secret)
    {
        $this->app_id = $app_id;
        $this->app_secret = $app_secret;
    }
    
    /**
     * 获取微信授权链接
     * 
     * @param string $redirect_uri 回调地址，授权后重定向的回调链接地址，请使用urlEncode对链接进行处理
     * @param mixed $state 可以为空，重定向后会带上state参数，开发者可以填写a-zA-Z0-9的参数值，最多128字节
     */
    public function get_authorize_url($redirect_uri = '', $state = '')
    {
        return "https://open.weixin.qq.com/connect/oauth2/authorize?appid=".$this->app_id."&redirect_uri=".urlencode($redirect_uri)."&response_type=code&scope=snsapi_userinfo&state=".$state."#wechat_redirect";
    }
    
    /**
     * 微信PC扫码授权登录链接
     * 
     * @param string $redirect_uri 回调地址，授权后重定向的回调链接地址，请使用urlEncode对链接进行处理
     * @param mixed $state 可以为空，重定向后会带上state参数，开发者可以填写a-zA-Z0-9的参数值，最多128字节
     */
    public function get_qrconnect_url($redirect_uri = '', $state = '')
    {
        return "https://open.weixin.qq.com/connect/qrconnect?appid".$this->app_id."&redirect_uri=".urlencode($redirect_uri)."&response_type=code&scope=snsapi_login&state=".$state."#wechat_redirect";
    }
    
    /**
     * 获取授权token
     * 
     * @param string $code 通过get_authorize_url获取到的code
     */
    public function get_access_token($code = '')
    {
        $token_url = "https://api.weixin.qq.com/sns/oauth2/access_token?appid={$this->app_id}&secret={$this->app_secret}&code={$code}&grant_type=authorization_code";
        $token_data = $this->http($token_url);
        
        return json_decode($token_data, true);
    }
    
    /**
     * 获取授权后的微信用户信息
     * 
     * @param string $access_token
     * @param string $open_id
     */
    public function get_user_info($access_token = '', $open_id = '')
    {
        $info_url = "https://api.weixin.qq.com/sns/userinfo?access_token={$access_token}&openid={$open_id}&lang=zh_CN";
        $info_data = $this->http($info_url);
            
        return json_decode($info_data, true);
    }
    
    /**
     * 获取用户基本信息（包括UnionID机制）
     * 
     * @param string $access_token
     * @param string $open_id
     */
    public function get_user_unionid($access_token = '', $open_id = '')
    {
        $info_url = "https://api.weixin.qq.com/cgi-bin/user/info?access_token={$access_token}&openid={$open_id}&lang=zh_CN";
        $info_data = $this->http($info_url);
        
        return json_decode($info_data, true);
    }
    
    // cURL函数简单封装
    public function http($url, $data = null)
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
        
        if (!empty($data))
        {
            curl_setopt($curl, CURLOPT_POST, 1);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        }
        
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $output = curl_exec($curl);
        curl_close($curl);
        
        return $output;
    }
}