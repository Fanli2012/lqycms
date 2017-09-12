<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\CommonController;

//微信auth2.0授权
class WechatAuthController extends CommonController
{
    public $appid = 'wxba09d9f0fed4b84b'; //微信APPID，公众平台获取
    public $appsecret = '332c2b1fc1eb282c0136b73723db4237'; //微信APPSECREC，公众平台获取
    public $redirect_uri = "http://www.你的域名.cn/项目目录/index.php?m=分组&c=控制器&a=方法"; //微信回调地址，要跟公众平台的配置域名相同
    public $code;
    public $openid;
    public $state = 123; //重定向后会带上state参数，开发者可以填写a-zA-Z0-9的参数值，最多128字节
    
    public function auth(Request $request)
    {
        //如果$_SESSION中没有openid，说明用户刚刚登陆，就执行getCode、getOpenId、getUserInfo获取他的信息
        if (!isset($_SESSION['openid']))
        {
            $this->code = $this->getCode();
            $this->access_token = $this->getOpenId();
            $userInfo = $this->getUserInfo();
            
            //把用户的微信信息存到数据库中
            /* if ($userInfo)
            {
                $ins = M('Wechat_user_info');
                $map['openid'] = $userInfo['openid'];
                $result = $ins->where($map)->find(); //根据OPENID查找数据库中是否有这个用户，如果没有就写数据库。继承该类的其他类，用户都写入了数据库中。
                
                if (!$result)
                {
                    $ins->add($userInfo);
                }
                
                $_SESSION['openid'] = $userInfo['openid']; //写到$_SESSION中。微信缓存很坑爹，调试时请及时清除缓存再试。
            } */
        }
    }

    /** 
     * @explain 
     * 获取code,用于获取openid和access_token 
     * @remark 
     * code只能使用一次，当获取到之后code失效,再次获取需要重新进入 
     * 不会弹出授权页面，适用于关注公众号后自定义菜单跳转等，如果不关注，那么只能获取openid 
     **/
    public function getCode()
    {
        if (isset($_REQUEST["code"]))
        {
            return $_REQUEST["code"];
        }
        else
        {
            $str = "location: https://open.weixin.qq.com/connect/oauth2/authorize?appid=" . $this->appid . "&redirect_uri=" . $this->redirect_uri . "&response_type=code&scope=snsapi_userinfo&state=". $this->state ."#wechat_redirect";
            header($str);
            exit;
        }
    }

    /** 
     * @explain 
     * 用于获取用户openid 
     **/
    public function getOpenId()
    {
        $access_token_url = "https://api.weixin.qq.com/sns/oauth2/access_token?appid=" . $this->appid . "&secret=" . $this->appsecret . "&code=" . $this->code . "&grant_type=authorization_code";
        $access_token_json = $this->https_request($access_token_url);
        $access_token_array = json_decode($access_token_json, TRUE);
        
        return $access_token_array;
    }

    /** 
     * @explain 
     * 通过code获取用户openid以及用户的微信号信息 
     * @return 
     * @remark 
     * 获取到用户的openid之后可以判断用户是否有数据，可以直接跳过获取access_token,也可以继续获取access_token 
     * access_token每日获取次数是有限制的，access_token有时间限制，可以存储到数据库7200s. 7200s后access_token失效 
     **/
    public function getUserInfo()
    {
        $userinfo_url = "https://api.weixin.qq.com/sns/userinfo?access_token=".$this->access_token['access_token'] ."&openid=" . $this->access_token['openid']."&lang=zh_CN";
        $userinfo_json = $this->https_request($userinfo_url);
        $userinfo_array = json_decode($userinfo_json, TRUE);
        
        return $userinfo_array;
    }


    /** 
     * @explain 
     * 发送http请求，并返回数据 
     **/
    public function https_request($url, $data = null)
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