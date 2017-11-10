<?php
namespace App\Common;

/**
 * 微信自定义菜单-响应菜单点击事件
 */
class WechatCallbackApi
{
    public function valid()
    {
        $echoStr = $_GET["echostr"];
        if($this->checkSignature())
        {
            echo $echoStr;
            exit;
        }
    }
    
    private function checkSignature() 
    {
        $signature = $_GET["signature"];
        $timestamp = $_GET["timestamp"];
        $nonce = $_GET["nonce"];
        
        $token = TOKEN;
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
    
    public function responseMsg()
    {
        $postStr = $GLOBALS["HTTP_RAW_POST_DATA"];
        if (!empty($postStr))
        {
            $postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
            $RX_TYPE = trim($postObj->MsgType);
            
            switch ($RX_TYPE)
            {
                case "text":
                $resultStr = $this->receiveText($postObj);
                break;
                case "event":
                $resultStr = $this->receiveEvent($postObj);
                break;
                default:
                $resultStr = "";
                break;
            }
            
            echo $resultStr;
        }
        else
        {
            echo "";
            exit;
        }
    }
    
    private function receiveText($object)
    {
        $funcFlag = 0;
        $contentStr = "你发送的内容为：".$object->Content;
        $resultStr = $this->transmitText($object, $contentStr, $funcFlag);
        return $resultStr;
    }
    
    private function receiveEvent($object)
    {
        $contentStr = "";
        switch ($object->Event)
        {
            case "subscribe":
            $contentStr = "欢迎洋洋博客";
            case "unsubscribe":
            break;
            case "CLICK":
            switch ($object->EventKey)
            {
                case "company":
                $contentStr[] = array("Title" =>"公司简介",
                "Description" =>"洋洋的博客",
                "PicUrl" =>"http://discuz.comli.com/weixin/weather/icon/cartoon.jpg",
                "Url" =>"weixin://addfriend/pondbaystudio");
                break;
                default:
                $contentStr[] = array("Title" =>"默认菜单回复",
                "Description" =>"您正在使用的是<span style="font-family: Arial, Helvetica, sans-serif;">洋洋的博客</span><span style="font-family: Arial, Helvetica, sans-serif;">", </span>
                "PicUrl" =>"http://discuz.comli.com/weixin/weather/icon/cartoon.jpg",
                "Url" =>"weixin://addfriend/pondbaystudio");
                break;
            }
            break;
            default:
            break;
        }
        
        if (is_array($contentStr))
        {
            $resultStr = $this->transmitNews($object, $contentStr);
        }
        else
        {
            $resultStr = $this->transmitText($object, $contentStr);
        }
        
        return $resultStr;
    }
    
    private function transmitText($object, $content, $funcFlag = 0)
    {
        $textTpl = "<xml>
            <ToUserName><![CDATA[%s]]></ToUserName>
            <FromUserName><![CDATA[%s]]></FromUserName>
            <CreateTime>%s</CreateTime>
            <MsgType><![CDATA[text]]></MsgType>
            <Content><![CDATA[%s]]></Content>
            <FuncFlag>%d</FuncFlag>
            </xml>";
        
        $resultStr = sprintf($textTpl, $object->FromUserName, $object->ToUserName, time(), $content, $funcFlag);
        
        return $resultStr;
    }
    
    private function transmitNews($object, $arr_item, $funcFlag = 0)
    {
        //首条标题28字，其他标题39字
        if(!is_array($arr_item))
        return;
    
        $itemTpl = "<item>
            <Title><![CDATA[%s]]></Title>
            <Description><![CDATA[%s]]></Description>
            <PicUrl><![CDATA[%s]]></PicUrl>
            <Url><![CDATA[%s]]></Url>
            </item>
            ";
        $item_str = ""; 
        foreach ($arr_item as $item)
        $item_str .= sprintf($itemTpl, $item['Title'], $item['Description'], $item['PicUrl'], $item['Url']);
        
        $newsTpl = "<xml> 
            <ToUserName><![CDATA[%s]]></ToUserName> 
            <FromUserName><![CDATA[%s]]></FromUserName> 
            <CreateTime>%s</CreateTime> 
            <MsgType><![CDATA[news]]></MsgType> 
            <Content><![CDATA[]]></Content> 
            <ArticleCount>%s</ArticleCount> 
            <Articles> 
            $item_str</Articles> 
            <FuncFlag>%s</FuncFlag> 
            </xml>"; 

        $resultStr = sprintf($newsTpl, $object->FromUserName, $object->ToUserName, time(), count($arr_item), $funcFlag); 
        return $resultStr; 
    } 
}