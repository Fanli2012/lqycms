<!DOCTYPE html><html><head><meta http-equiv="content-type" content="text/html;charset=utf-8"/>
<title>编辑资料</title><meta name="keywords" content="关键词"><meta name="description" content="描述"><meta content="width=device-width,initial-scale=1.0,minimum-scale=1.0,maximum-scale=1.0,user-scalable=0" name="viewport">
<link href="<?php echo env('APP_URL'); ?>/css/weixin/style.css" type="text/css" rel="stylesheet">
<script type="text/javascript" src="<?php echo env('APP_URL'); ?>/js/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo env('APP_URL'); ?>/js/weixin/mobile.js"></script>
<link href="<?php echo env('APP_URL'); ?>/css/font-awesome.min.css" type="text/css" rel="stylesheet"></head><body style="background-color:#f1f1f1;">
<div class="classreturn loginsignup">
    <div class="ds-in-bl return"><a href="javascript:history.back(-1);"><img src="<?php echo env('APP_URL'); ?>/images/weixin/return.png" alt="返回"></a></div>
    <div class="ds-in-bl tit center"><span>编辑资料</span></div>
    <div class="ds-in-bl nav_menu"><a href="javascript:void(0);"><img src="<?php echo env('APP_URL'); ?>/images/weixin/class1.png" alt="菜单"></a></div>
</div>

@include('weixin.common.headerNav')

<div class="floor">
<ul class="fui-list mt10">
    <a href="javascript:update_avator();"><li>
        <div class="ui-list-thumb">
            <!-- <span style="background-image:url(<?php echo env('APP_URL'); ?>/images/weixin/no_user.jpg)"></span> -->
            <form id="head_img" action="<?php echo env('APP_API_URL').'/image_upload'; ?>" method="post" enctype="multipart/form-data">
                <img id="avator" src="<?php if($user_info['head_img']!=''){echo $user_info['head_img'];}else{echo env('APP_URL').'/images/weixin/no_user.jpg';} ?>">
                <input id="fileupload" type="file" name="file" style="display:none;">
                <input type="hidden" name="access_token" value="<?php echo $_SESSION['weixin_user_info']['access_token']; ?>">
            </form>
        </div>
        <div class="ui-list-info">
            <h4 class="ui-nowrap">头像</h4>
            <div class="ui-reddot ui-reddot-static"></div>
        </div>
        <i class="fa fa-angle-right" aria-hidden="true"></i>
    </li></a>
<script type="text/javascript" src="<?php echo env('APP_URL'); ?>/js/md5.min.js"></script>
<script type="text/javascript" src="<?php echo env('APP_URL'); ?>/js/layer/mobile/layer.js"></script>
<script type="text/javascript" src="<?php echo env('APP_URL'); ?>/js/jquery-form.js"></script>
<script type="text/javascript">
function update_avator()
{
    $("#fileupload").trigger("click");
}

$(function(){
    $("#fileupload").change(function(){
		$("#head_img").ajaxSubmit({
			dataType: 'json',
			success: function(res) {
				var img = res.data[0];
				if(res.code==0)
                {
					$("#avator").attr("src",img);
                    
                    $.post('<?php echo env('APP_API_URL').'/user_info_update'; ?>',{access_token:'<?php echo $_SESSION['weixin_user_info']['access_token']; ?>',head_img:img},function(res2)
                    {
                        if(res2.code==0)
                        {
                            //提示
                            layer.open({
                                content: '头像修改成功'
                                ,skin: 'msg'
                                ,time: 2 //2秒后自动关闭
                            });
                        }
                    },'json');
				}
			},
			error:function(res){
				//files.html(res.responseText);
			}
		});
	});
});
</script>
    <a href="javascript:update_username();"><li>
        <div class="ui-list-info">
            <h4 class="ui-nowrap">用户名</h4>
            <div class="ui-txt-info"><?php echo $user_info['user_name']; ?> &nbsp;</div>
        </div>
        <i class="fa fa-angle-right" aria-hidden="true"></i>
    </li></a>
<style>
.adr_add{margin:0 10px;}
.adr-form-group input[type=text],.adr-form-group input[type=password]{display:block;width:100%;font-size:16px;padding:12px;color:#777;vertical-align:middle;background-color:#fff;background-image:none;border:1px solid #ddd;border-radius:0;box-sizing:border-box;}
.bottoma{display:block;font-size:18px;padding:10px;border-radius:2px;}
</style>
<script>
function update_username()
{
    //询问框
    layer.open({
        title: [
          '用户名修改',
          'background-color: #FF4351; color:#fff;'
        ]
        ,content: '<div class="adr-form-group"><input type="text" name="user_name" class="" id="user_name" placeholder="请输入用户名"></div>'
        ,btn: ['确定', '取消']
        ,yes: function(index){
            var user_name = $("#user_name").val();
            
            if(user_name == '')
            {
                layer.open({
                    content: '修改失败'
                    ,skin: 'msg'
                    ,time: 2 //2秒后自动关闭
                });
            }
            else
            {
                $.post('<?php echo env('APP_API_URL').'/user_info_update'; ?>',{user_name:user_name,access_token:'<?php echo $_SESSION['weixin_user_info']['access_token']; ?>'},function(res)
                {
                    if(res.code==0)
                    {
                        //提示
                        layer.open({
                            content: '修改成功'
                            ,skin: 'msg'
                            ,time: 2 //2秒后自动关闭
                        });
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
                
                window.location.reload();
            }
            
            layer.close(index);
        }
    });
}
</script>
    <a href="javascript:update_nickname();"><li>
        <div class="ui-list-info">
            <h4 class="ui-nowrap">昵称</h4>
            <div class="ui-txt-info"><?php echo $user_info['nickname']; ?> &nbsp;</div>
        </div>
        <i class="fa fa-angle-right" aria-hidden="true"></i>
    </li></a>
<script>
function update_nickname()
{
    //询问框
    layer.open({
        title: [
          '昵称修改',
          'background-color: #FF4351; color:#fff;'
        ]
        ,content: '<div class="adr-form-group"><input type="text" name="nickname" class="" id="nickname" placeholder="请输入昵称"></div>'
        ,btn: ['确定', '取消']
        ,yes: function(index){
            var nickname = $("#nickname").val();
            
            if(nickname == '')
            {
                layer.open({
                    content: '修改失败'
                    ,skin: 'msg'
                    ,time: 2 //2秒后自动关闭
                });
            }
            else
            {
                $.post('<?php echo env('APP_API_URL').'/user_info_update'; ?>',{nickname:nickname,access_token:'<?php echo $_SESSION['weixin_user_info']['access_token']; ?>'},function(res)
                {
                    if(res.code==0)
                    {
                        //提示
                        layer.open({
                            content: '修改成功'
                            ,skin: 'msg'
                            ,time: 2 //2秒后自动关闭
                        });
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
                
                window.location.reload();
            }
            
            layer.close(index);
        }
    });
}
</script>
    <a href="javascript:update_sex_layer();"><li>
        <div class="ui-list-info">
            <h4 class="ui-nowrap">性别</h4>
            <div class="ui-txt-info"><?php if($user_info['sex']==0){echo '未知';}elseif($user_info['sex']==1){echo '男';}elseif($user_info['sex']==2){echo '女';} ?> &nbsp;</div>
        </div>
        <i class="fa fa-angle-right" aria-hidden="true"></i>
    </li></a>
<script>
function update_sex_layer()
{
    //询问框
    layer.open({
        content: '<div style="padding:15px;"><a style="margin-bottom:10px;background-color:#1aad19;text-align:center;color:white;border:1px solid #179e16;" class="bottoma" onclick="layer.closeAll();" href="javascript:update_sex(1);">男</a><a style="margin-bottom:10px;background-color:#ea5a3d;text-align:center;color:white;border:1px solid #dd2727;" class="bottoma" onclick="layer.closeAll();" href="javascript:update_sex(2);">女</a></div>'
    });
}

function update_sex(sex)
{
    $.post('<?php echo env('APP_API_URL').'/user_info_update'; ?>',{sex:sex,access_token:'<?php echo $_SESSION['weixin_user_info']['access_token']; ?>'},function(res)
    {
        if(res.code==0)
        {
            //提示
            layer.open({
                content: '修改成功'
                ,skin: 'msg'
                ,time: 2 //2秒后自动关闭
            });
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
    
    window.location.reload();
}
</script>
    <a href="javascript:qrcode_layer();"><li>
        <div class="ui-list-info">
            <h4 class="ui-nowrap">二维码名片</h4>
            <div class="ui-txt-info"> &nbsp;</div>
        </div>
        <i class="fa fa-qrcode" aria-hidden="true" style="font-size:24px;"></i>
    </li></a>
<script>
function qrcode_layer()
{
    //询问框
    layer.open({
        content: '<div><div><img style="width:100%;" class="imgzsy" src="<?php echo get_erweima(route('weixin',array('invite_code'=>$_SESSION['weixin_user_info']['id'])),240); ?>"></div><p style="color:#999;">扫一扫，你懂得</p></div>'
    });
}
</script>
    <a href="javascript:update_refund_account();"><li>
        <div class="ui-list-info">
            <h4 class="ui-nowrap">退款账户</h4>
            <div class="ui-txt-info"> &nbsp;</div>
        </div>
        <i class="fa fa-angle-right" aria-hidden="true"></i>
    </li></a>
<script>
function update_refund_account()
{
    //询问框
    layer.open({
        title: [
          '退款账户管理',
          'background-color: #FF4351; color:#fff;'
        ]
        ,content: '<div class="adr-form-group"><input style="margin-bottom:5px;" type="text" name="refund_account" class="" id="refund_account" placeholder="支付宝账号" value="<?php if($user_info['refund_account']){echo $user_info['refund_account'];} ?>"><input type="text" name="refund_name" class="" id="refund_name" placeholder="姓名" value="<?php if($user_info['refund_name']){echo $user_info['refund_name'];} ?>"></div>'
        ,btn: ['确定', '取消']
        ,yes: function(index){
            var refund_account = $("#refund_account").val();
            var refund_name = $("#refund_name").val();
            
            if(refund_account == '' || refund_name == '')
            {
                /* layer.open({
                    content: '账户/姓名不能为空'
                    ,skin: 'msg'
                    ,time: 2 //2秒后自动关闭
                }); */
                
                alert('账户/姓名不能为空');
                
                return false;
            }
            else
            {
                $.post('<?php echo env('APP_API_URL').'/user_info_update'; ?>',{refund_account:refund_account,refund_name:refund_name,access_token:'<?php echo $_SESSION['weixin_user_info']['access_token']; ?>'},function(res)
                {
                    if(res.code==0)
                    {
                        //提示
                        layer.open({
                            content: '操作成功'
                            ,skin: 'msg'
                            ,time: 2 //2秒后自动关闭
                        });
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
                
                window.location.reload();
            }
            
            layer.close(index);
        }
    });
}
</script>
</ul>

<ul class="fui-list mt10">
    <a href="javascript:update_password();"><li>
        <div class="ui-list-info">
            <h4 class="ui-nowrap">修改密码</h4>
            <div class="ui-txt-info"> &nbsp;</div>
        </div>
        <i class="fa fa-angle-right" aria-hidden="true"></i>
    </li></a>
<script>
function update_password()
{
    //询问框
    layer.open({
        title: [
          '修改密码',
          'background-color: #FF4351; color:#fff;'
        ]
        ,content: '<div class="adr-form-group"><input style="margin-bottom:10px;" type="password" name="old_password" class="" id="old_password" placeholder="请输入旧密码"><input type="password" name="password" class="" id="password" placeholder="请输入新密码"></div>'
        ,btn: ['确定', '取消']
        ,yes: function(index){
            var old_password = $("#old_password").val();
            var password = $("#password").val();
            
            if(password == '' || old_password=='')
            {
                layer.open({
                    content: '修改失败'
                    ,skin: 'msg'
                    ,time: 2 //2秒后自动关闭
                });
            }
            else
            {
                if(password == old_password)
                {
                    layer.open({
                        content: '新旧密码一样'
                        ,skin: 'msg'
                        ,time: 2 //2秒后自动关闭
                    });
                    
                    return false;
                }
                
                $.post('<?php echo env('APP_API_URL').'/user_password_update'; ?>',{password:md5(password),old_password:md5(old_password),access_token:'<?php echo $_SESSION['weixin_user_info']['access_token']; ?>'},function(res)
                {
                    if(res.code==0)
                    {
                        //提示
                        layer.open({
                            content: '修改成功'
                            ,skin: 'msg'
                            ,time: 2 //2秒后自动关闭
                        });
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
                
                window.location.reload();
            }
            
            layer.close(index);
        }
    });
}
</script>
    <a href="javascript:<?php if($user_info['pay_password']){echo 'update_pay_password()';}else{echo 'set_pay_password()';} ?>;"><li>
        <div class="ui-list-info">
            <h4 class="ui-nowrap">支付密码</h4>
            <div class="ui-txt-info"> &nbsp;</div>
        </div>
        <i class="fa fa-angle-right" aria-hidden="true"></i>
    </li></a>
<script>
//设置支付密码
function set_pay_password()
{
    //询问框
    layer.open({
        title: [
          '设置支付密码',
          'background-color: #FF4351; color:#fff;'
        ]
        ,content: '<div class="adr-form-group"><input type="password" name="pay_password" class="" id="pay_password" placeholder="请输入新支付密码"></div>'
        ,btn: ['确定', '取消']
        ,yes: function(index){
            var pay_password = $("#pay_password").val();
            
            if(pay_password == '')
            {
                layer.open({
                    content: '设置失败'
                    ,skin: 'msg'
                    ,time: 2 //2秒后自动关闭
                });
            }
            else
            {
                $.post('<?php echo env('APP_API_URL').'/user_password_update'; ?>',{pay_password:md5(pay_password),old_pay_password:'',access_token:'<?php echo $_SESSION['weixin_user_info']['access_token']; ?>'},function(res)
                {
                    if(res.code==0)
                    {
                        //提示
                        layer.open({
                            content: '设置成功'
                            ,skin: 'msg'
                            ,time: 2 //2秒后自动关闭
                        });
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
                
                window.location.reload();
            }
            
            layer.close(index);
        }
    });
}
//修改支付密码
function update_pay_password()
{
    //询问框
    layer.open({
        title: [
          '修改支付密码',
          'background-color: #FF4351; color:#fff;'
        ]
        ,content: '<div class="adr-form-group"><input style="margin-bottom:10px;" type="password" name="old_pay_password" class="" id="old_pay_password" placeholder="请输入旧支付密码"><input type="password" name="pay_password" class="" id="pay_password" placeholder="请输入新支付密码"></div>'
        ,btn: ['确定', '取消']
        ,yes: function(index){
            var old_pay_password = $("#old_pay_password").val();
            var pay_password = $("#pay_password").val();
            
            if(pay_password == '' || old_pay_password == '')
            {
                layer.open({
                    content: '修改失败'
                    ,skin: 'msg'
                    ,time: 2 //2秒后自动关闭
                });
            }
            else
            {
                if(pay_password == old_pay_password)
                {
                    layer.open({
                        content: '新旧密码一样'
                        ,skin: 'msg'
                        ,time: 2 //2秒后自动关闭
                    });
                    
                    return false;
                }
                
                $.post('<?php echo env('APP_API_URL').'/user_password_update'; ?>',{pay_password:md5(pay_password),old_pay_password:md5(old_pay_password),access_token:'<?php echo $_SESSION['weixin_user_info']['access_token']; ?>'},function(res)
                {
                    if(res.code==0)
                    {
                        //提示
                        layer.open({
                            content: '修改成功'
                            ,skin: 'msg'
                            ,time: 2 //2秒后自动关闭
                        });
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
                
                window.location.reload();
            }
            
            layer.close(index);
        }
    });
}
</script>
</ul>
<div class="setting"><div class="close"><a href="<?php echo route('weixin_user_logout'); ?>" id="logout">安全退出</a></div></div>
</div>

@include('weixin.common.footer')
</body></html>