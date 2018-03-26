<?php
namespace App\Common;

if (!class_exists("WXBizMsgCrypt"))
{
    include_once "aes/wxBizMsgCrypt.php";
}

/**
 * 微信第三方平台代小程序或者公众号
 */
class WxComponent
{
    const API_URL_PREFIX          = 'https://api.weixin.qq.com/cgi-bin/component';
    const GET_ACCESS_TOKEN_URL    = '/api_component_token';
    const GET_PREAUTHCODE_URL     = '/api_create_preauthcode?component_access_token=';
    const GET_WX_AUTH_INFO_URL    = '/api_query_auth?component_access_token=';
    const GET_WX_ACCESS_TOKEN_URL = '/api_authorizer_token?component_access_token=';
    const GET_WX_ACCOUNT_INFO_URL = '/api_get_authorizer_info?component_access_token=';
    const GET_WX_OPTION_INFO_URL  = '/api_get_authorizer_option?component_access_token=';
    const SET_WX_OPTION_INFO_URL  = '/api_set_authorizer_option?component_access_token=';
    const WX_AUTH_CB_URL          = 'https://mp.weixin.qq.com/cgi-bin/componentloginpage?';

    //  代公众号发起网页授权相关
    //  在{网页开发域名}或者下级域名 $APPID$.{网页开发域名} 的形式,可以代公众号发起网页授权。
    const OAUTH_PREFIX        = 'https://open.weixin.qq.com/connect/oauth2';
    const OAUTH_AUTHORIZE_URL = '/authorize?';
    const API_BASE_URL_PREFIX = 'https://api.weixin.qq.com'; //以下API接口URL需要使用此前缀
    const OAUTH_TOKEN_URL     = '/sns/oauth2/component/access_token?';
    const OAUTH_REFRESH_URL   = '/sns/oauth2/component/refresh_token?';
    const OAUTH_USERINFO_URL  = '/sns/userinfo?';
    const OAUTH_AUTH_URL      = '/sns/auth?';
    // 代实现小程序
    const API_URL_PREFIX_MINI_PROGRAM = 'https://api.weixin.qq.com'; // 小程序
    const SET_DOMAIN                  = '/wxa/modify_domain';
    const BIND_TEST_USER              = '/wxa/bind_tester'; // 绑定小程序体验者
    const UNBIND_TEST_USER            = '/wxa/unbind_tester';
    const GET_DRAFT_TEMPLATE          = '/wxa/gettemplatedraftlist';
    const AUDIT_DRAFT_TEMPLATE        = '/wxa/addtotemplate';
    const TEMPLATE_LIST               = '/wxa/gettemplatelist';
    const DELETE_TEMPLATE             = '/wxa/deletetemplate';
    const UPLOAD_TEMPLATE             = '/wxa/commit';
    const TEST_QR_CODE                = '/wxa/get_qrcode';
    const GET_CATEGORY                = '/wxa/get_category';
    const GET_PAGES                   = '/wxa/get_page';
    const AUDIT_TEMPLATE              = '/wxa/submit_audit';
    const PUBLISH_TEMPLATE            = '/wxa/release';
    const AUDIT_STATUS                = '/wxa/get_auditstatus';
    
    public $component_appid;
    public $component_appsecret;
    public $component_verify_ticket;
    public $encodingAesKey = "";
    public $token          = "";
    
    public $debug   = false;
    public $errCode = 40001;
    public $errMsg  = "no access";
    private $_logcallback;
    
	/**
     * 构造函数，填入配置信息
     * @param string $component_appid 平台appId
     * @param string $component_appsecret 平台appsecret
     * @param string $component_verify_ticket 平台票据，微信服务器定时推送过来
     * @param string $encodingAesKey 公众号消息加解密Key
     * @param string $token 公众号消息校验Token
     */
    public function __construct($component_appid, $component_appsecret, $component_verify_ticket, $encodingAesKey, $token)
    {
        $this->component_appid         = $component_appid;
        $this->component_appsecret     = $component_appsecret;
        $this->component_verify_ticket = $component_verify_ticket;
        $this->encodingAesKey          = $encodingAesKey;
        $this->token                   = $token;
    }
    
    /**
     * @return mixed
     */
    public function getLogcallback()
    {
        return $this->_logcallback;
    }

    /**
     * @param callable $logcallback
     */
    public function setLogcallback($logcallback)
    {
        $this->_logcallback = $logcallback;
        return $this;
    }
    
    /**
     * 设置新的票据
     * @param $component_verify_ticket
     */
    public function setComponentVerifyTicket($component_verify_ticket)
    {
        $this->component_verify_ticket = $component_verify_ticket;
    }

    /**
     * 得到公众号服务授权的URL
     * @param string $pre_auth_code
     * @param string $redirect_uri
     * @return string
     */
    public function getAuthCbUrl($pre_auth_code, $redirect_uri)
    {
        return self::WX_AUTH_CB_URL . "component_appid=" . urlencode($this->component_appid)
        . "&pre_auth_code=" . urlencode($pre_auth_code) . "&redirect_uri=" . urlencode($redirect_uri);
    }

    /**
     * 获得服务访问授权key
     * @return bool|mixed {
     *    "component_access_token":"61W3mEpU66027wgNZ_MhGHNQDHnFATkDa9-2llqrMBjUwxRSNPbVsMmyD-yq8wZETSoE5NQgecigDrSHkPtIYA",
     *    "expires_in":7200
     *    }
     */
    public function getAccessToken()
    {
        $arr = array('component_appid' => $this->component_appid,
            'component_appsecret'          => $this->component_appsecret,
            'component_verify_ticket'      => $this->component_verify_ticket,
        );
        $result = $this->httpPost(self::API_URL_PREFIX . self::GET_ACCESS_TOKEN_URL, json_encode($arr));
        if ($result) {
            $json = json_decode($result, true);
            if (!$json || !empty($json['errcode'])) {
                $this->errCode = $json['errcode'];
                $this->errMsg  = $json['errmsg'];
                return false;
            }
            return $json;
        }
        return false;
    }

    /**
     * 获得预授权码
     * @param $access_token
     * @return bool|mixed{
     *    "pre_auth_code":"Cx_Dk6qiBE0Dmx4EmlT3oRfArPvwSQ-oa3NL_fwHM7VI08r52wazoZX2Rhpz1dEw",
     *    "expires_in":600
     *    }
     */
    public function getPreauthCode($access_token)
    {
        $arr    = array('component_appid' => $this->component_appid);
        $result = $this->httpPost(self::API_URL_PREFIX . self::GET_PREAUTHCODE_URL . $access_token, json_encode($arr));
        if ($result) {
            $json = json_decode($result, true);
            if (!$json || !empty($json['errcode'])) {
                $this->errCode = $json['errcode'];
                $this->errMsg  = $json['errmsg'];
                return false;
            }
            return $json;
        }
        return false;
    }

    /**
     * 使用授权码换取公众号的授权信息
     * @param $access_token
     * @param $auth_code
     * @return bool|mixed{ "authorization_info": {
     *    "authorizer_appid": "wxf8b4f85f3a794e77",
     *    "authorizer_access_token": "QXjUqNqfYVH0yBE1iI_7vuN_9gQbpjfK7hYwJ3P7xOa88a89-Aga5x1NMYJyB8G2yKt1KCl0nPC3W9GJzw0Zzq_dBxc8pxIGUNi_bFes0qM",
     *    "expires_in": 7200,
     *    "authorizer_refresh_token": "dTo-YCXPL4llX-u1W1pPpnp8Hgm4wpJtlR6iV0doKdY",
     *    "func_info": [{    "funcscope_category": {    "id": 1    }    },
     *    {"funcscope_category": {"id": 2    }},
     *    {"funcscope_category": {"id": 3}}]
     *    }
     */
    public function getWxAuthInfo($access_token, $auth_code)
    {
        $arr    = array('component_appid' => $this->component_appid, 'authorization_code' => $auth_code);
        $result = $this->httpPost(self::API_URL_PREFIX . self::GET_WX_AUTH_INFO_URL . $access_token, json_encode($arr));
        if ($result) {
            $json = json_decode($result, true);
            if (!$json || !empty($json['errcode'])) {
                $this->log('test--------------' . $result);
                $this->errCode = $json['errcode'];
                $this->errMsg  = $json['errmsg'];
                return false;
            }
            return $json;
        }
        return false;
    }

    /**
     * 获取（刷新）授权公众号的令牌
     * @param $access_token
     * @param $authorizer_appid
     * @param $authorizer_refresh_token
     * @return bool|mixed {
     *    "authorizer_access_token": "aaUl5s6kAByLwgV0BhXNuIFFUqfrR8vTATsoSHukcIGqJgrc4KmMJ-JlKoC_-NKCLBvuU1cWPv4vDcLN8Z0pn5I45mpATruU0b51hzeT1f8",
     *    "expires_in": 7200,
     *    "authorizer_refresh_token": "BstnRqgTJBXb9N2aJq6L5hzfJwP406tpfahQeLNxX0w"
     *    }
     */
    public function getWxAccessToken($access_token, $authorizer_appid, $authorizer_refresh_token)
    {
        $arr = array('component_appid' => $this->component_appid,
            'authorizer_appid'             => $authorizer_appid,
            'authorizer_refresh_token'     => $authorizer_refresh_token);
        $result = $this->httpPost(self::API_URL_PREFIX . self::GET_WX_ACCESS_TOKEN_URL . $access_token, json_encode($arr));
        if ($result) {
            $json = json_decode($result, true);
            if (!$json || !empty($json['errcode'])) {
                $this->errCode = $json['errcode'];
                $this->errMsg  = $json['errmsg'];
                return false;
            }
            return $json;
        }
        return false;
    }

    /**
     * 获取授权方的账户信息
     * @param $access_token
     * @param $authorizer_appid
     * @return bool|mixed {"authorizer_info": {
     *    "nick_name": "微信SDK Demo Special",
     *    "head_img": "http://wx.qlogo.cn/mmopen/GPyw0pGicibl5Eda4GmSSbTguhjg9LZjumHmVjybjiaQXnE9XrXEts6ny9Uv4Fk6hOScWRDibq1fI0WOkSaAjaecNTict3n6EjJaC/0",
     *    "service_type_info": { "id": 2 },
     *    "verify_type_info": { "id": 0 },
     *    "user_name":"gh_eb5e3a772040",
     *    "alias":"paytest01"
     *    },
     *    "authorization_info": {
     *    "appid": "wxf8b4f85f3a794e77",
     *    "func_info": [    { "funcscope_category": { "id": 1 } },    { "funcscope_category": { "id": 2 } },    { "funcscope_category": { "id": 3 } }]
     *    }}
     */
    public function getWxAccountInfo($access_token, $authorizer_appid)
    {
        $arr = array('component_appid' => $this->component_appid,
            'authorizer_appid'             => $authorizer_appid);
        $result = $this->httpPost(self::API_URL_PREFIX . self::GET_WX_ACCOUNT_INFO_URL . $access_token, json_encode($arr));
        if ($result) {
            $json = json_decode($result, true);
            if (!$json || !empty($json['errcode'])) {
                $this->log('test###--------------' . $result);
                $this->errCode = $json['errcode'];
                $this->errMsg  = $json['errmsg'];
                return false;
            }
            return $json;
        }
        return false;
    }

    /**
     * 获取授权方的选项信息
     * @param $access_token
     * @param $authorizer_appid
     * @param $option_name
     * @return bool|mixed {    "authorizer_appid":"wx7bc5ba58cabd00f4",
     *    "option_name":"voice_recognize",
     *    "option_value":"1"    }
     */
    public function getWxOptionInfo($access_token, $authorizer_appid, $option_name)
    {
        $arr = array('component_appid' => $this->component_appid,
            'authorizer_appid'             => $authorizer_appid,
            'option_name'                  => $option_name);
        $result = $this->httpPost(self::API_URL_PREFIX . self::GET_WX_OPTION_INFO_URL . $access_token, json_encode($arr));
        if ($result) {
            $json = json_decode($result, true);
            if (!$json || !empty($json['errcode'])) {
                $this->errCode = $json['errcode'];
                $this->errMsg  = $json['errmsg'];
                return false;
            }
            return $json;
        }
        return false;
    }

    /**
     * 设置授权方的选项信息
     * @param $access_token
     * @param $authorizer_appid
     * @param $option_name
     * @param $option_value
     * @return bool|mixed  {    "errcode":0,    "errmsg":"ok"    }
     */
    public function setWxOptionInfo($access_token, $authorizer_appid, $option_name, $option_value)
    {
        $arr = array('component_appid' => $this->component_appid,
            'authorizer_appid'             => $authorizer_appid,
            'option_name'                  => $option_name,
            'option_value'                 => $option_value);
        $result = $this->httpPost(self::API_URL_PREFIX . self::SET_WX_OPTION_INFO_URL . $access_token, json_encode($arr));
        if ($result) {
            $json = json_decode($result, true);
            if (!$json || $json['errcode'] > 0) {
                $this->errCode = $json['errcode'];
                $this->errMsg  = $json['errmsg'];
                return false;
            }
            return $json;
        }
        return false;
    }

    /**
     * 处理component_verify_ticket
     *
     */

    /**
     * @return array|bool
     * <xml>
     *    <AppId> </AppId>
     *    <CreateTime>1413192605 </CreateTime>
     *    <InfoType> </InfoType>
     *    <ComponentVerifyTicket> </ComponentVerifyTicket>
     *    </xml>
     */
    public function processEventNotify($raw = '')
    {
        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            $dec_msg = "";

            $postStr = $raw ?? file_get_contents("php://input");
            if (!$postStr) {
                $postStr = $GLOBALS['HTTP_RAW_POST_DATA'];
            }

            if (!$postStr) {
                return false;
            }

            $pc  = new \WXBizMsgCrypt($this->token, $this->encodingAesKey, $this->component_appid);
            $ret = $pc->decryptMsg($_GET['msg_signature'], $_GET['timestamp'], $_GET['nonce'], $postStr, $dec_msg);
            if ($ret === 0) {
                $arr = (array) simplexml_load_string($dec_msg, 'SimpleXMLElement', LIBXML_NOCDATA);
                return $arr;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public function responseEvent()
    {
        die("success");
    }

    /**
     * 代公众号发起网页授权 oauth 授权跳转接口
     * @param string $appid 公众号appId
     * @param string $callback 跳转URL
     * @param string $state 状态信息，最多128字节
     * @param string $scope 授权作用域 snsapi_base或者snsapi_userinfo 或者 snsapi_base,snsapi_userinfo
     * @return string
     */
    public function getOauthRedirect($appid, $callback, $state = '', $scope = 'snsapi_base')
    {
        return self::OAUTH_PREFIX . self::OAUTH_AUTHORIZE_URL . 'appid=' . $appid . '&redirect_uri=' . urlencode($callback) .
        '&response_type=code&scope=' . $scope . '&state=' . $state . '&component_appid=' . urlencode($this->component_appid)
            . '#wechat_redirect';
    }

    /**
     * 代公众号发起网页授权 回调URL时，通过code获取Access Token
     * @return array|boolean {access_token,expires_in,refresh_token,openid,scope}
     */
    public function getOauthAccessToken($appid, $component_access_token)
    {
        $code = isset($_GET['code']) ? $_GET['code'] : '';
        if (!$code) {
            return false;
        }

        $result = $this->httpPost(self::API_BASE_URL_PREFIX . self::OAUTH_TOKEN_URL . 'appid=' . $appid
            . '&code=' . $code . '&grant_type=authorization_code'
            . '&component_appid=' . urlencode($this->component_appid)
            . '&component_access_token=' . $component_access_token);
        if ($result) {
            $json = json_decode($result, true);
            if (!$json || !empty($json['errcode'])) {
                $this->errCode = $json['errcode'];
                $this->errMsg  = $json['errmsg'];
                return false;
            }
            return $json;
        }
        return false;
    }

    /**
     * 代公众号发起网页授权  刷新access token并续期
     * @param string $refresh_token
     * @return boolean|mixed
     */
    public function getOauthRefreshToken($appId, $refresh_token, $component_access_token)
    {
        $result = $this->httpPost(self::API_BASE_URL_PREFIX . self::OAUTH_REFRESH_URL
            . 'appid=' . $appId . '&grant_type=refresh_token&refresh_token=' . $refresh_token
            . '&component_appid=' . urlencode($this->component_appid)
            . '&component_access_token=' . $component_access_token
        );
        if ($result) {
            $json = json_decode($result, true);
            if (!$json || !empty($json['errcode'])) {
                $this->errCode = $json['errcode'];
                $this->errMsg  = $json['errmsg'];
                return false;
            }
            return $json;
        }
        return false;
    }

    /**
     * 获取授权后的用户资料
     * @param string $access_token
     * @param string $openid
     * @return array|boolean {openid,nickname,sex,province,city,country,headimgurl,privilege,[unionid]}
     * 注意：unionid字段 只有在用户将公众号绑定到微信开放平台账号后，才会出现。建议调用前用isset()检测一下
     */
    public function getOauthUserinfo($access_token, $openid)
    {
        $result = $this->httpPost(self::API_BASE_URL_PREFIX . self::OAUTH_USERINFO_URL . 'access_token=' . $access_token . '&openid=' . $openid);
        if ($result) {
            $json = json_decode($result, true);
            if (!$json || !empty($json['errcode'])) {
                $this->errCode = $json['errcode'];
                $this->errMsg  = $json['errmsg'];
                return false;
            }
            return $json;
        }
        return false;
    }

    /**
     * 检验授权凭证是否有效
     * @param string $access_token
     * @param string $openid
     * @return boolean 是否有效
     */
    public function getOauthAuth($access_token, $openid)
    {
        $result = $this->httpPost(self::API_BASE_URL_PREFIX . self::OAUTH_AUTH_URL . 'access_token=' . $access_token . '&openid=' . $openid);
        if ($result) {
            $json = json_decode($result, true);
            if (!$json || !empty($json['errcode'])) {
                $this->errCode = $json['errcode'];
                $this->errMsg  = $json['errmsg'];
                return false;
            } else
            if ($json['errcode'] == 0) {
                return true;
            }

        }
        return false;
    }
    
    public function setMiniProgramDomain($appID, $params, $accessToken)
    {
        $result = $this->httpPost(static::API_URL_PREFIX_MINI_PROGRAM . static::SET_DOMAIN . '?access_token=' . $accessToken, json_encode($params));
        if ($result) {
            $json = json_decode($result, true);
            if (!$json || !empty($json['errcode'])) {
                $this->errCode = $json['errcode'];
                $this->errMsg  = $json['errmsg'];
                return false;
            } else {
                if ($json['errcode'] == 0) {
                    return true;
                }
            }
        }
        return false;
    }
    
    public function uploadTemplate($params, $accessToken)
    {
        $result = $this->httpPost(static::API_URL_PREFIX_MINI_PROGRAM . static::UPLOAD_TEMPLATE . '?access_token=' . $accessToken, json_encode($params, JSON_UNESCAPED_UNICODE));
        if ($result) {
            $json = json_decode($result, true);
            if (!$json || !empty($json['errcode'])) {
                $this->errCode = $json['errcode'];
                $this->errMsg  = $json['errmsg'];
                return false;
            } else {
                if ($json['errcode'] == 0) {
                    return true;
                }
            }
        }
        return false;
    }

    public function getDraftTemplateList($accessToken)
    {
        $result = $this->httpPost(static::API_URL_PREFIX_MINI_PROGRAM . static::GET_DRAFT_TEMPLATE . '?access_token=' . $accessToken, '');
        if ($result) {
            $json = json_decode($result, true);
            return $json;
        }
        return false;
    }

    public function getTemplateList($accessToken)
    {
        $result = $this->httpPost(static::API_URL_PREFIX_MINI_PROGRAM . static::TEMPLATE_LIST . '?access_token=' . $accessToken, '');
        if ($result) {
            $json = json_decode($result, true);
            return $json;
        }
        return false;
    }

    public function auditDraftTemplate($accessToken, $draftID)
    {
        $result = $this->httpPost(static::API_URL_PREFIX_MINI_PROGRAM . static::AUDIT_DRAFT_TEMPLATE . '?access_token=' . $accessToken, json_encode(['draft_id' => $draftID]));
        if ($result) {
            $json = json_decode($result, true);
            if (!$json || !empty($json['errcode'])) {
                $this->errCode = $json['errcode'];
                $this->errMsg  = $json['errmsg'];
                return false;
            } else {
                if ($json['errcode'] == 0) {
                    return true;
                }
            }
        }
        return false;
    }

    public function deleteTemplate($accessToken, $templateID)
    {
        $result = $this->httpPost(static::API_URL_PREFIX_MINI_PROGRAM . static::DELETE_TEMPLATE . '?access_token=' . $accessToken, json_encode(['template_id' => $templateID]));
        if ($result) {
            $json = json_decode($result, true);
            if (!$json || !empty($json['errcode'])) {
                $this->errCode = $json['errcode'];
                $this->errMsg  = $json['errmsg'];
                return false;
            } else {
                if ($json['errcode'] == 0) {
                    return true;
                }
            }
        }
        return false;
    }
    
    public function getQrCode($accessToken)
    {
        $result = $this->httpPost(static::API_URL_PREFIX_MINI_PROGRAM . static::TEST_QR_CODE . '?access_token=' . $accessToken, '');
        if ($result) {
            return $result; // 图片二进制流
        }
        return false;
    }
    public function getCategory($accessToken)
    {
        $result = $this->httpPost(static::API_URL_PREFIX_MINI_PROGRAM . static::GET_CATEGORY . '?access_token=' . $accessToken, '');
        if ($result) {
            $json = json_decode($result, true);
            return $json;
        }
        return false;
    }

    public function getPages($accessToken)
    {
        $result = $this->httpPost(static::API_URL_PREFIX_MINI_PROGRAM . static::GET_PAGES . '?access_token=' . $accessToken, '');
        if ($result) {
            $json = json_decode($result, true);
            return $json;
        }
        return false;
    }
    
    public function auditTemplate($params, $accessToken)
    {
        $result = $this->httpPost(static::API_URL_PREFIX_MINI_PROGRAM . static::AUDIT_TEMPLATE . '?access_token=' . $accessToken, json_encode($params, JSON_UNESCAPED_UNICODE));
        if ($result) {
            $json = json_decode($result, true);
            if (!$json || !empty($json['errcode'])) {
                $this->errCode = $json['errcode'];
                $this->errMsg  = $json['errmsg'];
                return false;
            } else {
                if ($json['errcode'] == 0) {
                    return $json;
                }
            }
        }
        return false;
    }
    
    public function bindTestUser($params, $accessToken)
    {
        $result = $this->httpPost(static::API_URL_PREFIX_MINI_PROGRAM . static::BIND_TEST_USER . '?access_token=' . $accessToken, json_encode($params));
        if ($result) {
            $json = json_decode($result, true);
            if (!$json || !empty($json['errcode'])) {
                $this->errCode = $json['errcode'];
                $this->errMsg  = $json['errmsg'];
                return false;
            } else {
                if ($json['errcode'] == 0) {
                    return true;
                }
            }
        }
        return false;
    }

    public function unbindTestUser($params, $accessToken)
    {
        $result = $this->httpPost(static::API_URL_PREFIX_MINI_PROGRAM . static::UNBIND_TEST_USER . '?access_token=' . $accessToken, json_encode($params));
        if ($result) {
            $json = json_decode($result, true);
            if (!$json || !empty($json['errcode'])) {
                $this->errCode = $json['errcode'];
                $this->errMsg  = $json['errmsg'];
                return false;
            } else {
                if ($json['errcode'] == 0) {
                    return true;
                }
            }
        }
        return false;
    }
    
    public function publishTemplate($accessToken)
    {
        $result = $this->httpPost(static::API_URL_PREFIX_MINI_PROGRAM . static::PUBLISH_TEMPLATE . '?access_token=' . $accessToken, json_encode(new stdClass()));
        if ($result) {
            $json = json_decode($result, true);
            if (!$json || !empty($json['errcode'])) {
                $this->errCode = $json['errcode'];
                $this->errMsg  = $json['errmsg'];
                return false;
            } else {
                if ($json['errcode'] == 0) {
                    return true;
                }
            }
        }
        return false;
    }
    
    public function getAuditStatus($auditid, $accessToken)
    {
        $result = $this->httpPost(static::API_URL_PREFIX_MINI_PROGRAM . static::AUDIT_STATUS . '?access_token=' . $accessToken, json_encode(['auditid' => $auditid]));
        if ($result) {
            $json = json_decode($result, true);
            if (!$json || !empty($json['errcode'])) {
                $this->errCode = $json['errcode'];
                $this->errMsg  = $json['errmsg'];
                return false;
            } else {
                if ($json['errcode'] == 0) {
                    return $json;
                }
            }
        }
        return false;
    }

    protected function log($log)
    {
        if ($this->debug && is_callable($this->_logcallback)) {
            if (is_array($log)) {
                $log = print_r($log, true);
            }

            return call_user_func($this->_logcallback, $log);
        }
        return true;
    }

    /**
     * POST 请求
     * @param string $url
     * @param string|array $param
     * @param boolean $post_file 是否文件上传
     * @return string content
     */
    private function httpPost($url, $param = "", $post_file = false)
    {
        $oCurl = curl_init();
        if (stripos($url, "https://") !== false) {
            curl_setopt($oCurl, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($oCurl, CURLOPT_SSL_VERIFYHOST, false);
            curl_setopt($oCurl, CURLOPT_SSLVERSION, 1); //CURL_SSLVERSION_TLSv1
        }
        if (is_string($param) || $post_file) {
            $strPOST = $param;
        } else {
            $aPOST = array();
            foreach ($param as $key => $val) {
                if (is_array($val)) {
                    foreach ($val as $_k => $_v) {
                        $aPOST[] = $key . "[]=" . urlencode($_v);
                    }
                } else {
                    $aPOST[] = $key . "=" . urlencode($val);
                }
            }
            $strPOST = join("&", $aPOST);
        }
        curl_setopt($oCurl, CURLOPT_URL, $url);
        curl_setopt($oCurl, CURLOPT_RETURNTRANSFER, 1);
        if ($strPOST != "") {
            curl_setopt($oCurl, CURLOPT_POST, true);
            curl_setopt($oCurl, CURLOPT_POSTFIELDS, $strPOST);
        }
        $sContent = curl_exec($oCurl);
        $aStatus  = curl_getinfo($oCurl);
        curl_close($oCurl);
        if (intval($aStatus["http_code"]) == 200) {
            $this->log("wxcomponent httpPost: {$strPOST} recv:" . $sContent);
            return $sContent;
        } else {
            $this->log("wxcomponent httpPost: {$strPOST} recv error {$url}, param:{$param} aStatus:" . print_r($aStatus, true));
            return false;
        }
    }

    /**
     * 微信api不支持中文转义的json结构
     * @param array $arr
     */
    public static function jsonEncode($arr)
    {
        $parts   = array();
        $is_list = false;
        //Find out if the given array is a numerical array
        $keys       = array_keys($arr);
        $max_length = count($arr) - 1;
        if (($keys[0] === 0) && ($keys[$max_length] === $max_length)) { //See if the first key is 0 and last key is length - 1
            $is_list = true;
            for ($i = 0; $i < count($keys); $i++) { //See if each key correspondes to its position
                if ($i != $keys[$i]) { //A key fails at position check.
                    $is_list = false; //It is an associative array.
                    break;
                }
            }
        }
        foreach ($arr as $key => $value) {
            if (is_array($value)) { //Custom handling for arrays
                if ($is_list) {
                    $parts[] = self::jsonEncode($value);
                }
                /* :RECURSION: */
                else {
                    $parts[] = '"' . $key . '":' . self::jsonEncode($value);
                }
                /* :RECURSION: */
            } else {
                $str = '';
                if (!$is_list) {
                    $str = '"' . $key . '":';
                }

                //Custom handling for multiple data types
                if (!is_string($value) && is_numeric($value) && $value < 2000000000) {
                    $str .= $value;
                }
                //Numbers
                elseif ($value === false) {
                    $str .= 'false';
                }
                //The booleans
                elseif ($value === true) {
                    $str .= 'true';
                } else {
                    $str .= '"' . addslashes($value) . '"';
                }
                //All other things
                // :TODO: Is there any more datatype we should be in the lookout for? (Object?)
                $parts[] = $str;
            }
        }
        $json = implode(',', $parts);
        if ($is_list) {
            return '[' . $json . ']';
        }
        //Return numerical JSON
        return '{' . $json . '}'; //Return associative JSON
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