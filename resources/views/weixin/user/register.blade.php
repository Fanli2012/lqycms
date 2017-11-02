<!DOCTYPE html><html><head><meta http-equiv="content-type" content="text/html;charset=utf-8"/>
<title>注册</title><meta name="keywords" content="关键词"><meta name="description" content="描述"><meta content="width=device-width,initial-scale=1.0,minimum-scale=1.0,maximum-scale=1.0,user-scalable=0" name="viewport">
<link href="<?php echo env('APP_URL'); ?>/css/weixin/style.css" type="text/css" rel="stylesheet">
<script type="text/javascript" src="<?php echo env('APP_URL'); ?>/js/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo env('APP_URL'); ?>/js/weixin/mobile.js"></script>
<link href="<?php echo env('APP_URL'); ?>/css/font-awesome.min.css" type="text/css" rel="stylesheet"></head><body>
<div class="classreturn loginsignup">
    <div class="ds-in-bl return"><a href="javascript:history.back(-1);"><img src="<?php echo env('APP_URL'); ?>/images/weixin/return.png" alt="返回"></a></div>
    <div class="ds-in-bl tit center"><span>注册</span></div>
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
.account{text-align:center;margin-top:50px;}
.account .icon{color:#FFCC00;font-size:100px;}
.bottoma{display:block;font-size:18px;padding:10px;border-radius:2px;}

.adr_add{margin:0 10px;}
.adr-form-group{margin-top:10px;}
.adr-form-group input[type=text],.adr-form-group input[type=password]{display:block;width:100%;font-size:16px;padding:12px;color:#777;vertical-align:middle;background-color:#fff;background-image:none;border:1px solid #ddd;border-radius:0;box-sizing:border-box;}

.reg a{color:#2393df;}
</style>
<div class="floor account">
    <div class="icon"><i class="fa fa-user-circle" aria-hidden="true"></i></div>
    <br>
    <form id="login" action="" method="post">
    <div class="adr_add">
        <div class="adr-form-group">
            <input type="text" name="user_name" class="" id="user_name" placeholder="请输入用户名">
        </div>
        <div class="adr-form-group">
            <input type="text" name="mobile" class="" id="mobile" placeholder="请输入手机号码">
        </div>
        <div class="adr-form-group">
            <input type="password" name="password" class="" id="password" placeholder="请设置6-20位登录密码">
        </div>
        <div class="adr-form-group">
            <input type="password" name="re_password" class="" id="re_password" placeholder="确认密码">
        </div>
        <div class="adr-form-group">
            <input type="text" name="parent_mobile" class="" id="parent_mobile" placeholder="请输入推荐人手机号，选填">
        </div>
    </div>
    </form>
    <a style="margin:10px;background-color:#1aad19;text-align:center;color:white;border:1px solid #179e16;" class="bottoma" href="javascript:submit();">提交</a>
</div>
<div class="box reg">
<a style="float:left;" href="<?php echo route('weixin_login'); ?>">已有账号</a> <span style="float:right;"><a href="<?php echo route('weixin_login'); ?>">注册协议</a></span>
</div><br><br>

<script type="text/javascript" src="<?php echo env('APP_URL'); ?>/js/md5.min.js"></script>
<script type="text/javascript" src="<?php echo env('APP_URL'); ?>/js/layer/mobile/layer.js"></script>
<script>
function submit()
{
    var user_name = $("#user_name").val();
    var mobile = $("#mobile").val();
    var password = $("#password").val();
    var re_password = $("#re_password").val();
    var parent_mobile = $("#parent_mobile").val();
    
    if(user_name == '')
    {
        layer.open({
            content: '用户名不能为空'
            ,skin: 'msg'
            ,time: 2 //2秒后自动关闭
        });
        
        return false;
    }
    
    if(mobile == '')
    {
        layer.open({
            content: '手机号不能为空'
            ,skin: 'msg'
            ,time: 2 //2秒后自动关闭
        });
        
        return false;
    }
    
    if(!validatemobile(mobile))
    {
        layer.open({
            content: '手机号格式不正确'
            ,skin: 'msg'
            ,time: 2 //2秒后自动关闭
        });
        
        return false;
    }
    
    if(password == '')
    {
        layer.open({
            content: '密码不能为空'
            ,skin: 'msg'
            ,time: 2 //2秒后自动关闭
        });
        
        return false;
    }
    
    if(password != re_password)
    {
        layer.open({
            content: '两次密码不一致'
            ,skin: 'msg'
            ,time: 2 //2秒后自动关闭
        });
        
        return false;
    }
    
    //$("#login").submit();
    $.post('<?php echo env('APP_API_URL').'/wx_register'; ?>',{user_name:user_name,mobile:mobile,parent_mobile:parent_mobile,password:md5(password)},function(res)
	{
		if(res.code==0)
		{
            //提示
            layer.open({
                content: '注册成功'
                ,skin: 'msg'
                ,time: 2 //2秒后自动关闭
            });
            
            setInterval(function(){location.href = '<?php echo route('weixin_login'); ?>';},5000);
		}
		else
		{
            layer.open({
                content: res.msg
                ,skin: 'msg'
                ,time: 2 //2秒后自动关闭
            });
		}
	},'json');
}
</script>
@include('weixin.common.footer')
</body></html>