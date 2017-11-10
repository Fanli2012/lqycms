<?php
namespace App\Common;

/**
 * 微信自定义菜单
 */
class WechatMenu
{
	//高级功能->开发者模式->获取
    private $app_id;
    private $app_secret;
	private $access_token;
    private $expires_in;
    
	public function __construct($app_id, $app_secret)
    {
        $this->app_id = $app_id;
        $this->app_secret = $app_secret;
        
        $token = $this->get_access_token();
        $this->access_token = $token['access_token'];
        $this->expires_in = $token['expires_in'];
    }
    
    /**
     * 获取授权access_token
     * 
     */
    public function get_access_token()
    {
        $token_url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid={$this->app_id}&secret={$this->app_secret}";
        $token_data = $this->http($token_url);
        
        return json_decode($token_data, true);
    }
    
    //获取关注者列表
    public function get_user_list($next_openid = NULL)
    {
        $url = "https://api.weixin.qq.com/cgi-bin/user/get?access_token=".$this->access_token."&next_openid=".$next_openid;
        $res = $this->http($url);
        return json_decode($res, true);
    }
    
    /**
     * 自定义菜单创建
     * 
     * @param string $jsonmenu
     */
    public function create_menu($jsonmenu)
    {
        $url = "https://api.weixin.qq.com/cgi-bin/menu/create?access_token=".$this->access_token; 
        return $this->http($url, $jsonmenu);
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