<?php
require_once(resource_path('org/wxJsSdk/jssdk.php'));
$jssdk = new \JSSDK(sysconfig('CMS_WX_APPID'), sysconfig('CMS_WX_APPSECRET'));
$signPackage = $jssdk->GetSignPackage();
?>
<script src="http://res.wx.qq.com/open/js/jweixin-1.2.0.js"></script>
<script type="text/javascript">
/*
 * 注意：
 * 1. 所有的JS接口只能在公众号绑定的域名下调用，公众号开发者需要先登录微信公众平台进入“公众号设置”的“功能设置”里填写“JS接口安全域名”。
 * 2. 如果发现在 Android 不能分享自定义内容，请到官网下载最新的包覆盖安装，Android 自定义分享接口需升级至 6.0.2.58 版本及以上。
 * 3. 常见问题及完整 JS-SDK 文档地址：http://mp.weixin.qq.com/wiki/7/aaa137b55fb2e0456bf8dd9148dd613f.html
 *
 * 开发中遇到问题详见文档“附录5-常见错误及解决办法”解决，如仍未能解决可通过以下渠道反馈：
 * 邮箱地址：weixin-open@qq.com
 * 邮件主题：【微信JS-SDK反馈】具体问题
 * 邮件内容说明：用简明的语言描述问题所在，并交代清楚遇到该问题的场景，可附上截屏图片，微信团队会尽快处理你的反馈。
 */
wx.config({
    debug: false, // 开启调试模式,调用的所有api的返回值会在客户端alert出来，若要查看传入的参数，可以在pc端打开，参数信息会通过log打出，仅在pc端时才会打印。
    appId: '<?php echo $signPackage["appId"];?>', // 必填，公众号的唯一标识
    timestamp: '<?php echo $signPackage["timestamp"];?>', // 必填，生成签名的时间戳
    nonceStr: '<?php echo $signPackage["nonceStr"];?>', // 必填，生成签名的随机串
    signature: '<?php echo $signPackage["signature"];?>', // 必填，签名
    jsApiList: [
      // 所有要调用的 API 都要加到这个列表中
      'onMenuShareTimeline','onMenuShareAppMessage'
    ]
});

//获取网页描述
var meta = document.getElementsByTagName('meta');
var share_desc = '';
for(i in meta)
{
    if(typeof meta[i].name!="undefined"&&meta[i].name.toLowerCase()=="description")
    {
        share_desc = meta[i].content;
    }
}

wx.ready(function () {
    // config信息验证后会执行ready方法，所有接口调用都必须在config接口获得结果之后，config是一个客户端的异步操作，所以如果需要在页面加载时就调用相关接口，则须把相关接口放在ready函数中调用来确保正确执行。对于用户触发时才调用的接口，则可以直接调用，不需要放在ready函数中。
    // 在这里调用 API
    var title=document.title;
    var desc='<?php echo sysconfig('CMS_WXSHAER_DESC'); ?>'; //分享描述
    var url='<?php echo sysconfig('CMS_WXSHAER_LINK'); ?>'; //分享链接
    var img='<?php echo sysconfig('CMS_WXSHAER_IMGURL'); ?>'; //分享图标
    
    // 分享给朋友
    wx.onMenuShareAppMessage({
        title: title, // 分享标题
        desc: desc, // 分享描述
        link: url, // 分享链接
        imgUrl: img, // 分享图标
        type: '', // 分享类型,music、video或link，不填默认为link
        dataUrl: '', // 如果type是music或video，则要提供数据链接，默认为空
        success: function () { 
            // 用户确认分享后执行的回调函数
            _share_success();
        },
        cancel: function () { 
            // 用户取消分享后执行的回调函数
            _share_error();
        }
    });
    
    // 分享到朋友圈
    wx.onMenuShareTimeline({
        title: title, // 分享标题
        link: url, // 分享链接
        imgUrl: img, // 分享图标
        
        success: function () { 
            // 用户确认分享后执行的回调函数
            _share_success();
        },
        cancel: function () { 
            // 用户取消分享后执行的回调函数
            _share_error();
        }
    });
    
    wx.error(function(res){
        console.log(res);
    });
    
    //分享成功
    function _share_success()
    {
        alert('分享成功');
    }
    
    //分享失败
    function _share_error()
    {
        alert('分享失败');
    }
});
</script>