<!DOCTYPE html><html><head><meta http-equiv="content-type" content="text/html;charset=utf-8"/>
<title>登录</title><meta name="keywords" content="关键词"><meta name="description" content="描述"><meta content="width=device-width,initial-scale=1.0,minimum-scale=1.0,maximum-scale=1.0,user-scalable=0" name="viewport">
<link href="<?php echo env('APP_URL'); ?>/css/weixin/style.css" type="text/css" rel="stylesheet">
<script type="text/javascript" src="<?php echo env('APP_URL'); ?>/js/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo env('APP_URL'); ?>/js/weixin/mobile.js"></script>
<link href="<?php echo env('APP_URL'); ?>/css/font-awesome.min.css" type="text/css" rel="stylesheet"></head><body>
<div class="classreturn loginsignup">
    <div class="ds-in-bl return"><a href="javascript:history.back(-1);"><img src="<?php echo env('APP_URL'); ?>/images/weixin/return.png" alt="返回"></a></div>
    <div class="ds-in-bl tit center"><span>登录</span></div>
    <div class="ds-in-bl nav_menu"><a href="javascript:void(0);"><img src="<?php echo env('APP_URL'); ?>/images/weixin/class1.png" alt="菜单"></a></div>
</div>

@include('weixin.common.headerNav')

<style>
.account{text-align:center;margin-top:30px;}
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
            <input type="text" name="user_name" class="" id="user_name" placeholder="请输入账号">
        </div>
        <div class="adr-form-group">
            <input type="password" name="password" class="" id="password" placeholder="请输入密码">
        </div>
    </div>
    </form>
    <a style="margin:10px;background-color:#1aad19;text-align:center;color:white;border:1px solid #179e16;" class="bottoma" href="javascript:submit();">登录</a>
</div>
<div class="box reg">
<?php if($isWechatBrowser){ ?><a style="float:left;" href="<?php echo route('weixin_wxoauth'); ?>">微信登录</a> <?php } ?><span style="float:right;"><a href="<?php echo route('weixin_register'); ?>">快速注册</a> | <a href="">忘记密码？</a></span>
</div><br><br>
<script type="text/javascript" src="<?php echo env('APP_URL'); ?>/js/md5.min.js"></script>
<script type="text/javascript" src="<?php echo env('APP_URL'); ?>/js/layer/mobile/layer.js"></script>
<script>
function submit()
{
    var user_name = $("#user_name").val();
    var password = $("#password").val();
    
    if(user_name == '')
    {
        //提示
        layer.open({
            content: '账号不能为空'
            ,skin: 'msg'
            ,time: 2 //2秒后自动关闭
        });
        
        return false;
    }
    
    if(password == '')
    {
        //提示
        layer.open({
            content: '密码不能为空'
            ,skin: 'msg'
            ,time: 2 //2秒后自动关闭
        });
        
        return false;
    }
    
    $("#login").submit();
    /* $.post('<?php echo env('APP_API_URL').'/wx_login'; ?>',{user_name:user_name,password:md5(password)},function(res)
	{
		if(res.code==0)
		{
            //提示
            layer.open({
                content: '登录成功'
                ,skin: 'msg'
                ,time: 2 //2秒后自动关闭
            });
            
            location.href = '<?php if(isset($_SERVER["HTTP_REFERER"])){echo $_SERVER["HTTP_REFERER"];}else{echo route('weixin_user');} ?>';
		}
		else
		{
            
		}
	},'json'); */
}
</script>
@include('weixin.common.footer')
</body></html>