<!DOCTYPE html><html><head><meta http-equiv="content-type" content="text/html;charset=utf-8"/>
<title>新增收货地址</title><meta content="width=device-width,initial-scale=1.0,minimum-scale=1.0,maximum-scale=1.0,user-scalable=0" name="viewport">
<link href="<?php echo env('APP_URL'); ?>/css/weixin/style.css" type="text/css" rel="stylesheet">
<script type="text/javascript" src="<?php echo env('APP_URL'); ?>/js/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo env('APP_URL'); ?>/js/weixin/mobile.js"></script>
<meta name="keywords" content="关键词"><meta name="description" content="描述"></head><body style="background-color:#f1f1f1;">
<div class="classreturn loginsignup ">
    <div class="ds-in-bl return"><a href="javascript:history.back(-1);"><img src="<?php echo env('APP_URL'); ?>/images/weixin/return.png" alt="返回"></a></div>
    <div class="ds-in-bl tit center"><span>新增收货地址</span></div>
    <div class="ds-in-bl nav_menu"><a href="javascript:void(0);"><img src="<?php echo env('APP_URL'); ?>/images/weixin/class1.png" alt="菜单"></a></div>
</div>
<div class="flool tpnavf cl">
    <div class="nav_list">
        <ul>
        <a href="index.html"><li><img src="<?php echo env('APP_URL'); ?>/images/weixin/home_icon.png"><p>首页</p></li></a>
        <a href="/Weixin/index.php?m=Store&amp;a=index"><li><img src="<?php echo env('APP_URL'); ?>/images/weixin/brand_icon.png"><p>分类</p></li></a>	
        <a href="/Weixin/index.php?m=Cart&amp;a=index"><li><img src="<?php echo env('APP_URL'); ?>/images/weixin/car_icon.png"><p>购物车</p></li></a>	
        <a href="/Weixin/index.php?m=User&amp;a=index"><li><img src="<?php echo env('APP_URL'); ?>/images/weixin/center_icon.png"><p>个人中心</p></li></a></ul>
        <div class="cl"></div>
    </div>
</div>
<style>
.adr_add{margin:0 10px;}
.adr-form-group{margin-top:10px;}
.adr-form-group input[type=text],.adr-form-group textarea{
    display: block;
    width: 100%;
    font-size:16px;
    padding:10px;
    color: #777;
    vertical-align: middle;
    background-color: #fff;
    background-image: none;
    border: 1px solid #ddd;
    border-radius: 0;box-sizing:border-box;
}
.bottoma{display:block;font-size:18px;padding:10px;color:white;background-color: #f23030;text-align:center;}
</style>

<div class="adr_add">
<div class="adr-form-group">
  <label for="doc-ipt-email-1">收货人</label>
  <input name="name" type="text" class="" id="name" placeholder="输入姓名">
</div>
<div class="adr-form-group">
  <label for="doc-ipt-email-1">手机号码</label>
  <input type="text" name="mobile" class="" id="mobile" placeholder="输入手机号码">
</div>
<div class="adr-form-group">
  <label for="doc-ipt-email-1">地区</label>
  <input type="text" class="" id="doc-ipt-email-1" placeholder="输入电子邮件">
</div>
<div class="adr-form-group">
  <label for="doc-ta-1">详细地址</label>
  <textarea name="address" class="" rows="3" id="address"></textarea>
</div>
<div class="adr-form-group">
  <label>
    <input type="checkbox" name="is_default" id="is_default"> 设为默认
  </label>
</div>
</div>
<a style="margin:10px;" class="bottoma" href="javascript:adr_dosubmit();">提交</a>
<script type="text/javascript" src="<?php echo env('APP_URL'); ?>/js/layer/mobile/layer.js"></script>
<script>
function adr_dosubmit()
{
    var access_token = '<?php echo $_SESSION['weixin_user_info']['access_token']; ?>';
    
	var url = '<?php echo env('APP_API_URL').'/user_address_add'; ?>';
	var name = $("#name").val();
	var mobile = $("#mobile").val();
	var address = $("#address").val();
	
    var province = '福建';
    var city = '厦门';
    var district = '湖里';
    
    var is_default = 0;
    if(document.getElementById("is_default").checked){is_default = 1;}
    
	$.post(url,{access_token:access_token,name:name,mobile:mobile,address:address,province:province,city:city,district:district,is_default:is_default},function(res)
	{
		if(res.code==0)
		{
            //提示
            layer.open({
                content: res.msg
                ,skin: 'msg'
                ,time: 2 //2秒后自动关闭
            });
            
            window.history.back();
		}
		else
		{
            //提示
            layer.open({
                content: res.msg
                ,skin: 'msg'
                ,time: 2 //2秒后自动关闭
            });
            
			var url = "http://www.baidu.com";
			location.href = url;
		}
	},'json');
}
</script>
</body></html>