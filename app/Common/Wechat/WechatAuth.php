<?php
namespace App\Common\Wechat;

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
     * 获取access_token，access_token是公众号的全局唯一接口调用凭据，公众号调用各接口时都需使用access_token。access_token的存储至少要保留512个字符空间。access_token的有效期目前为2个小时，需定时刷新，重复获取将导致上次获取的access_token失效。
     */
    public function get_token()
    {
        $token_url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid={$this->app_id}&secret={$this->app_secret}";
        $token_data = $this->http($token_url);
        return json_decode($token_data, true);
    }
    
    /**
     * 获取小程序码，适用于需要的码数量较少的业务场景，通过该接口生成的小程序码，永久有效，数量限制见文末说明，请谨慎使用。
     * @param string $path 不能为空，最大长度 128 字节
     * @param int $width 二维码的宽度，默认430
     */
    public function getwxacode($path, $width = 430)
    {
        $access_token = $this->get_token();
        $url = 'https://api.weixin.qq.com/wxa/getwxacode?access_token='.$access_token['access_token'];
        $path ="pages/mine/mine/mine?query=1";
        $data ='{"path":"'.$path.'","width":'.$width.'}';
        $res = $this->http($url, $data);
        
        return $res;
        //将生成的小程序码存入相应文件夹下
        //file_put_contents('./public/wxyido/img/'.time().'.jpg',$return);
    }
    
    /**
     * 获取小程序码，通过该接口生成的小程序码，永久有效，数量暂无限制。用户扫描该码进入小程序后，开发者需在对应页面获取的码中 scene 字段的值，再做处理逻辑。
     * @param string $data['scene'] 二维码场景值
     * @param string $data['page'] 必须是已经发布的小程序存在的页面（否则报错），例如 "pages/index/index" ,根路径前不要填加'/',不能携带参数（参数请放在scene字段里），如果不填写这个字段，默认跳主页面
     * @param int $data['width'] 二维码的宽度，默认430
     * @param int $data['type'] 0路径存储，1base64
     */
    public function getwxacodeunlimit($data)
    {
        $access_token = $this->get_token();
        $url = 'https://api.weixin.qq.com/wxa/getwxacodeunlimit?access_token='.$access_token['access_token'];
        
        $post_data = array();
        $post_data['scene'] = $data['scene'];
        $post_data['page'] = $data['page'];
        $post_data['width'] = $data['width'];
        
        $res = $this->http($url, json_encode($post_data));
        if($data['type']==0)
        {
            file_put_contents($data['image_path'], $res);
        }
        else
        {
            $res = $this->data_uri($res);
        }
        
        return $res;
        //将生成的小程序码存入相应文件夹下
        //file_put_contents('./public/wxyido/img/'.time().'.jpg',$res);
    }
    
    public function data_uri($contents, $mime = 'image/png')  
    {
        $base64 = base64_encode($contents);
        return ('data:' . $mime . ';base64,' . $base64);
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
    
    /**
     * 小程序登录凭证校验
     * 小程序调用wx.login() 获取 临时登录凭证code ，并回传到开发者服务器。
     * 开发者服务器以code换取 用户唯一标识openid 和 会话密钥session_key。
     * 临时登录凭证校验接口是一个 HTTPS 接口，开发者服务器使用 临时登录凭证code 获取 session_key 和 openid 等。
     * @param string $js_code 小程序登录时获取的code
     */
    public function miniprogram_wxlogin($js_code)
    {
        $url = "https://api.weixin.qq.com/sns/jscode2session?appid={$this->app_id}&secret={$this->app_secret}&js_code=$js_code&grant_type=authorization_code";
        $res = $this->http($url);
        
        return json_decode($res, true);
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