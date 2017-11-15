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
    
    /**
     * 自定义菜单创建
     * @param string $jsonmenu
     */
    public function create_menu($jsonmenu)
    {
        $url = "https://api.weixin.qq.com/cgi-bin/menu/create?access_token=".$this->access_token; 
        return $this->http($url, $jsonmenu);
    }
    
    /**
     * 查询菜单
     * @param $access_token 已获取的ACCESS_TOKEN
     */
    public function getmenu($access_token)
    {
        # code...
        $url = "https://api.weixin.qq.com/cgi-bin/menu/get?access_token=".$this->access_token;
        $data = file_get_contents($url);
        return $data;
    }
    
    /**
     * 删除菜单
     * @param $access_token 已获取的ACCESS_TOKEN
     */
    public function delmenu($access_token)
    {
        # code...
        $url = "https://api.weixin.qq.com/cgi-bin/menu/delete?access_token=".$this->access_token;
        $data = json_decode(file_get_contents($url),true);
        if ($data['errcode']==0)
        {
            # code...
            return true;
        }
        else
        {
            return false;
        }
    }
    
    /**
     * 获取最新5天关注用户发过来的消息，消息id，用户fakeid，昵称，消息内容
     *
     * 返回结构:id:msgId; fakeId; nickName; content;
     *
     * @return array
     */
    public function newmesg()
    {
        $url = 'https://mp.weixin.qq.com/cgi-bin/getmessage?t=wxm-message&token='.$this->access_token.'&lang=zh_CN&count=50&rad='.rand(10000, 99999);
        $stream = $this->http($url);

        preg_match('/< type="json" id="json-msgList">(.*?)<\/>/is', $stream, $match);
        $json = json_decode($match[1], true);
        $returns = array();
        foreach ( $json as $val)
        {
            if ( $val['starred'] == '0')
            {
                $returns[] = $val;
            }
        }
        
        return $returns;
    }

    /**
     * 设置标记
     *
     * @param integer $msgId 消息标记
     * @return boolean
     */
    public function start($msgId)
    {
        $url = 'https://mp.weixin.qq.com/cgi-bin/setstarmessage?t=ajax-setstarmessage&rad='.rand(10000, 99999);
        $post = 'msgid='.$msgId.'&value=1&token='.$this->access_token.'&ajax=1';
        $stream = $this->http($url, $post);

        // 是不是设置成功
        $html = preg_replace("/^.*\{/is", "{", $stream);
        $json = json_decode($html, true);

        return (boolean)$json['msg'] == 'sys ok';
    }
    
    /**
     * 发送消息
     *
     * 结构 $param = array(fakeId, content, msgId);
     * @param array $param
     * @return boolean
     */
    public function sendmesg($param)
    {
		$url  = 'https://mp.weixin.qq.com/cgi-bin/singlesend?t=ajax-response';
		$post = 'error=false&tofakeid='.$param['fakeId'].'&type=1&content='.$param['content'].'&quickreplyid='.$param['msgId'].'&token='.$this->access_token.'&ajax=1';

		$stream = $this->http($url, $post);
		$this->start($param['msgId']);

		// 是不是设置成功
		$html = preg_replace("/^.*\{/is", "{", $stream);
		$json = json_decode($html, true);
		return (boolean)$json['msg'] == 'ok';
    }
    
    /**
     * 主动发消息结构
     *  $param = array(fakeId, content);
     *  @param array $param
     *  @return [type] [description]
     */
    public function send($param)
    {
        $url  = 'https://mp.weixin.qq.com/cgi-bin/singlesend?t=ajax-response&lang=zh_CN';
        //$post = 'ajax=1&appmsgid='.$param['msgid'].'&error=false&fid='.$param['msgid'].'&tofakeid='.$param['fakeId'].'&token='.$this->access_token.'&type=10';
        $post = 'ajax=1&content='.$param['content'].'&error=false&tofakeid='.$param['fakeId'].'&token='.$this->access_token.'&type=1';
        $stream = $this->html($url, $post);
        // 是不是设置成功
        $html = preg_replace("/^.*\{/is", "{", $stream);
        $json = json_decode($html, true);
        return (boolean)$json['msg'] == 'ok';
    }
    
    /**
     * 批量发送(可能需要设置超时)
     * $param = array(fakeIds, content);
     * @param array $param
     * @return [type] [description]
     */
    public function batSend($param)
    {   $url  = 'https://mp.weixin.qq.com/cgi-bin/masssend?t=ajax-response';
        $post = 'ajax=1&city=&content='.$param['content'].'&country=&error=false&groupid='.$param['groupid'].'&needcomment=0&province=&sex=0&token='.$this->access_token.'&type=1';
        $stream = $this->html($url, $post);
        // 是不是设置成功
        $html = preg_replace("/^.*\{/is", "{", $stream);
        $json = json_decode($html, true);
        return (boolean)$json['msg'] == 'ok';
    }
    
    /**
     * 新建图文消息
     */
    public function setNews($param, $post_data)
    {
        $url = 'https://mp.weixin.qq.com/cgi-bin/sysnotify?lang=zh_CN&f=json&begin=0&count=5';
        $post = 'ajax=1&token='.$this->access_token.'';
        $stream = $this->html($url, $post);
        //上传图片
        $url = 'https://mp.weixin.qq.com/cgi-bin/uploadmaterial?cgi=uploadmaterial&type='.$param['type'].'&token='.$this->access_token.'&t=iframe-uploadfile&lang=zh_CN&formId=1';
        $stream = $this->_uploadFile($url, $post_data);
        echo '</pre>';
        print_r($stream);
        echo '</pre>';
        exit;
    }

    /**
     * 获得用户发过来的消息（消息内容和消息类型）
     */
    public function getMsg()
    {
        $postStr = $GLOBALS["HTTP_RAW_POST_DATA"];
        if ($this->debug) {
            $this->write_log($postStr);
        }
        if (!empty($postStr)) {
            $this->msg = (array)simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
            $this->msgtype = strtolower($this->msg['MsgType']);//获取用户信息的类型
			$this->eventkey = strtolower($this->msg['EventKey']);//获取key值
        }
    }
    /**
     * 回复文本消息
     * @param string $text
     * @return string
     */
    public function makeText($text='')
    {
        $createtime = time();
        $funcflag = $this->setFlag ? 1 : 0;
        $textTpl = "<xml>
            <ToUserName><![CDATA[{$this->msg['FromUserName']}]]></ToUserName>
            <FromUserName><![CDATA[{$this->msg['ToUserName']}]]></FromUserName>
            <CreateTime>{$createtime}</CreateTime>
            <MsgType><![CDATA[text]]></MsgType>
            <Content><![CDATA[%s]]></Content>
            <FuncFlag>%s</FuncFlag>
            </xml>";
        return sprintf($textTpl,$text,$funcflag);
    }
     /**
     * 回复图文消息
     * @param array $newsData
     * @return string
     */
     public function makeNews($newsData=array())
    {
        $createtime = time();
        $funcflag = $this->setFlag ? 1 : 0;
        $newTplHeader = "<xml>
            <ToUserName><![CDATA[{$this->msg['FromUserName']}]]></ToUserName>
            <FromUserName><![CDATA[{$this->msg['ToUserName']}]]></FromUserName>
            <CreateTime>{$createtime}</CreateTime>
            <MsgType><![CDATA[news]]></MsgType>
            <Content><![CDATA[%s]]></Content>
            <ArticleCount>%s</ArticleCount><Articles>";
        $newTplItem = "<item>
            <Title><![CDATA[%s]]></Title>
            <Description><![CDATA[%s]]></Description>
            <PicUrl><![CDATA[%s]]></PicUrl>
            <Url><![CDATA[%s]]></Url>
            </item>";
        $newTplFoot = "</Articles>
            <FuncFlag>%s</FuncFlag>
            </xml>";
        $content = '';
        $itemsCount = count($newsData['items']);
        $itemsCount = $itemsCount < 10 ? $itemsCount : 10;//微信公众平台图文回复的消息一次最多10条
        if ($itemsCount) {
            foreach ($newsData['items'] as $key => $item) {
                $content .= sprintf($newTplItem,$item['title'],$item['description'],$item['picUrl'],$item['url']);//微信的信息数据

            }
        }
        $header = sprintf($newTplHeader,$newsData['content'],$itemsCount);
        $footer = sprintf($newTplFoot,$funcflag);
        return $header . $content . $footer;
    }
	/**
     * 回复音乐消息
     * @param array $newsData
     * @return string
     */
    public function makeMusic($newsData=array())
    {
        $createtime = time();
        $funcflag = $this->setFlag ? 1 : 0;
        $textTpl = "<xml>
            <ToUserName><![CDATA[{$this->msg['FromUserName']}]]></ToUserName>
            <FromUserName><![CDATA[{$this->msg['ToUserName']}]]></FromUserName>
            <CreateTime>{$createtime}</CreateTime>
            <MsgType><![CDATA[music]]></MsgType>
            <Music>
			<Title><![CDATA[{$newsData['title']}]]></Title>
            <Description><![CDATA[{$newsData['description']}]]></Description>
            <MusicUrl><![CDATA[{$newsData['MusicUrl']}]]></MusicUrl>
            <HQMusicUrl><![CDATA[{$newsData['HQMusicUrl']}]]></HQMusicUrl>
			</Music>
			<FuncFlag>%s</FuncFlag>
			</xml>";
        return sprintf($textTpl,'',$funcflag);
    }
    
	/**
     * 得到制定分组的用户列表
     * @param number $groupid
	 * @param number $pagesize，每页人数
     * @param number $pageidx，起始位置
     * @return Ambigous <boolean, string, mixed>
     */
    public function getfriendlist($groupid=0,$pagesize=500,$pageidx=0)
    {
        $url = 'https://mp.weixin.qq.com/cgi-bin/contactmanagepage?token='.$this->access_token.'&t=wxm-friend&lang=zh_CN&pagesize='.$pagesize.'&pageidx='.$pageidx.'&groupid='.$groupid;
        $referer = "https://mp.weixin.qq.com/";
        $response = $this->html($url, $referer);
        if (preg_match('%< id="json-friendList" type="json/text">([\s\S]*?)</>%', $response, $match))
        {
         $tmp = json_decode($match[1], true);
        }
        
        return $tmp;
    }

    /**
     * 返回给用户信息
     *
     */
   public function reply($data)
   {
       echo $data;
   }
   
    /**
     *@param type: text 文本类型, news 图文类型
     *@param value_arr array(内容),array(ID)
     *@param o_arr array(array(标题,介绍,图片,超链接),...小于10条),array(条数,ID)
     */
    private function make_xml($type,$value_arr,$o_arr=array(0))
    {
        //=================xml header============
        $con="<xml>
                    <ToUserName><![CDATA[{$this->fromUsername}]]></ToUserName>
                    <FromUserName><![CDATA[{$this->toUsername}]]></FromUserName>
                    <CreateTime>{$this->times}</CreateTime>
                    <MsgType><![CDATA[{$type}]]></MsgType>";
        
        //=================type content============
        switch($type)
        {
            case "text" : 
                $con.="<Content><![CDATA[{$value_arr[0]}]]></Content>
                    <FuncFlag>{$o_arr}</FuncFlag>";
            break;
            
            case "news" : 
                $con.="<ArticleCount>{$o_arr[0]}</ArticleCount>
                     <Articles>";
                foreach($value_arr as $id=>$v){
                    if($id>=$o_arr[0]) break; else null; //判断数组数不超过设置数
                    $con.="<item>
                         <Title><![CDATA[{$v[0]}]]></Title>
                         <Description><![CDATA[{$v[1]}]]></Description>
                         <PicUrl><![CDATA[{$v[2]}]]></PicUrl>
                         <Url><![CDATA[{$v[3]}]]></Url>
                         </item>";
                }
                $con.="</Articles>
                     <FuncFlag>{$o_arr[1]}</FuncFlag>";
            break;
        } //end switch
        //=================end return============
        $con.="</xml>";
        
        return $con;
    }
    
    //获取关注者列表
    public function get_user_list($next_openid = null)
    {
        $url = "https://api.weixin.qq.com/cgi-bin/user/get?access_token=".$this->access_token."&next_openid=".$next_openid;
        $res = $this->http($url);
        return json_decode($res, true);
    }
    
    //获取用户基本信息
    public function get_user_info($openid)
    {
        $url = "https://api.weixin.qq.com/cgi-bin/user/info?access_token=".$this->access_token."&openid=".$openid."&lang=zh_CN";
        $res = $this->http($url);
        return json_decode($res, true);
    }
    
    //发送客服消息，已实现发送文本，其他类型可扩展
    public function send_custom_message($touser, $type, $data)
    {
        $msg = array('touser' =>$touser);
        switch($type)
        {
            case 'text':
                $msg['msgtype'] = 'text';
                $msg['text']    = array('content'=> urlencode($data));
                break;
        }
        $url = "https://api.weixin.qq.com/cgi-bin/message/custom/send?access_token=".$this->access_token;
        return $this->http($url, urldecode(json_encode($msg)));
    }
 
    //生成参数二维码
    public function create_qrcode($scene_type, $scene_id)
    {
        switch($scene_type)
        {
            case 'QR_LIMIT_SCENE': //永久
                $data = '{"action_name": "QR_LIMIT_SCENE", "action_info": {"scene": {"scene_id": '.$scene_id.'}}}';
                break;
            case 'QR_SCENE':       //临时
                $data = '{"expire_seconds": 1800, "action_name": "QR_SCENE", "action_info": {"scene": {"scene_id": '.$scene_id.'}}}';
                break;
        }
        $url = "https://api.weixin.qq.com/cgi-bin/qrcode/create?access_token=".$this->access_token;
        $res = $this->http($url, $data);
        $result = json_decode($res, true);
        return "https://mp.weixin.qq.com/cgi-bin/showqrcode?ticket=".urlencode($result["ticket"]);
    }
    
    //创建分组
    public function create_group($name)
    {
        $data = '{"group": {"name": "'.$name.'"}}';
        $url = "https://api.weixin.qq.com/cgi-bin/groups/create?access_token=".$this->access_token;
        $res = $this->http($url, $data);
        return json_decode($res, true);
    }
    
    //移动用户分组
    public function update_group($openid, $to_groupid)
    {
        $data = '{"openid":"'.$openid.'","to_groupid":'.$to_groupid.'}';
        $url = "https://api.weixin.qq.com/cgi-bin/groups/members/update?access_token=".$this->access_token;
        $res = $this->http($url, $data);
        return json_decode($res, true);
    }
    
    //上传多媒体文件
    public function upload_media($type, $file)
    {
        $data = array("media"  => "@".dirname(__FILE__).'\\'.$file);
        $url = "http://file.api.weixin.qq.com/cgi-bin/media/upload?access_token=".$this->access_token."&type=".$type;
        $res = $this->http($url, $data);
        return json_decode($res, true);
    }
    
    private function checkSignature()
    {
        $signature = $_GET["signature"];
        $timestamp = $_GET["timestamp"];
        $nonce = $_GET["nonce"];
        
        $token = 'weixin';
        $tmpArr = array($token, $timestamp, $nonce);
        sort($tmpArr);
        $tmpStr = implode( $tmpArr );
        $tmpStr = sha1( $tmpStr );
        
        if( $tmpStr == $signature )
        {
            return true;
        }
        else
        {
            return false;
        }
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