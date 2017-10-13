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
<div class="flool tpnavf cl">
    <div class="nav_list">
        <ul>
        <a href="<?php echo route('weixin'); ?>"><li><img src="<?php echo env('APP_URL'); ?>/images/weixin/home_icon.png"><p>首页</p></li></a>
        <a href="/Weixin/index.php?m=Store&amp;a=index"><li><img src="<?php echo env('APP_URL'); ?>/images/weixin/brand_icon.png"><p>分类</p></li></a>	
        <a href="/Weixin/index.php?m=Cart&amp;a=index"><li><img src="<?php echo env('APP_URL'); ?>/images/weixin/car_icon.png"><p>购物车</p></li></a>	
        <a href="/Weixin/index.php?m=User&amp;a=index"><li><img src="<?php echo env('APP_URL'); ?>/images/weixin/center_icon.png"><p>个人中心</p></li></a></ul>
        <div class="cl"></div>
    </div>
</div>

<div class="floor">
<ul class="fui-list mt10">
    <li>
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
        <i id="avatorright" class="fa fa-angle-right" aria-hidden="true"></i>
    </li>
<script type="text/javascript" src="<?php echo env('APP_URL'); ?>/js/layer/mobile/layer.js"></script>
<script type="text/javascript" src="<?php echo env('APP_URL'); ?>/js/jquery-form.js"></script>
<script type="text/javascript">
$(function(){
    $("#avator,#avatorright").click(function(){
        $("#fileupload").trigger("click");
    });
    
    $("#fileupload").change(function(){
		$("#head_img").ajaxSubmit({
			dataType: 'json',
			success: function(res) {
				var img = res.data;
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
    <li>
        <div class="ui-list-info">
            <h4 class="ui-nowrap">用户名</h4>
            <div class="ui-txt-info"><?php echo $user_info['user_name']; ?> &nbsp;</div>
        </div>
        <i class="fa fa-angle-right" aria-hidden="true"></i>
    </li>
    <li>
        <div class="ui-list-info">
            <h4 class="ui-nowrap">昵称</h4>
            <div class="ui-txt-info"><?php echo $user_info['nickname']; ?> &nbsp;</div>
        </div>
        <i class="fa fa-angle-right" aria-hidden="true"></i>
    </li>
    <li>
        <div class="ui-list-info">
            <h4 class="ui-nowrap">性别</h4>
            <div class="ui-txt-info"><?php if($user_info['sex']==0){echo '未知';}elseif($user_info['sex']==1){echo '男';}elseif($user_info['sex']==2){echo '女';} ?> &nbsp;</div>
        </div>
        <i class="fa fa-angle-right" aria-hidden="true"></i>
    </li>
</ul>

<ul class="fui-list mt10">
    <li>
        <div class="ui-list-info">
            <h4 class="ui-nowrap">修改密码</h4>
            <div class="ui-txt-info"> &nbsp;</div>
        </div>
        <i class="fa fa-angle-right" aria-hidden="true"></i>
    </li>
    <li>
        <div class="ui-list-info">
            <h4 class="ui-nowrap">支付密码</h4>
            <div class="ui-txt-info"> &nbsp;</div>
        </div>
        <i class="fa fa-angle-right" aria-hidden="true"></i>
    </li>
</ul>
<div class="setting"><div class="close"><a href="<?php echo route('weixin_user_logout'); ?>" id="logout">安全退出</a></div></div>
</div>

@include('weixin.common.footer')
</body></html>