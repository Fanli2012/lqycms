<!DOCTYPE html><html><head><meta http-equiv="content-type" content="text/html;charset=utf-8"/>
<title>我的分销</title><meta name="keywords" content="关键词"><meta name="description" content="描述"><meta content="width=device-width,initial-scale=1.0,minimum-scale=1.0,maximum-scale=1.0,user-scalable=0" name="viewport">
<link href="<?php echo env('APP_URL'); ?>/css/weixin/style.css" type="text/css" rel="stylesheet">
<script type="text/javascript" src="<?php echo env('APP_URL'); ?>/js/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo env('APP_URL'); ?>/js/weixin/mobile.js"></script>
<link href="<?php echo env('APP_URL'); ?>/css/font-awesome.min.css" type="text/css" rel="stylesheet"></head><body>
<div class="classreturn loginsignup">
    <div class="ds-in-bl return"><a href="javascript:history.back(-1);"><img src="<?php echo env('APP_URL'); ?>/images/weixin/return.png" alt="返回"></a></div>
    <div class="ds-in-bl tit center"><span>我的分销</span></div>
</div>

<script type="text/javascript" src="<?php echo env('APP_URL'); ?>/js/layer/mobile/layer.js"></script>
<style>
.account{text-align:center;margin-top:30px;}
.account .icon{color:#FFCC00;font-size:100px;}
.account .money{color:#353535;font-size:36px;}
.account .tit{color:#000;font-size:18px;}
.banner_tit{font-size:18px;font-weight:400;background-color:#fff;color:#f23030;height:46px;line-height:46px;padding-left:10px;padding-right:10px;border-bottom:1px solid #eee;border-top:10px solid #f1f1f1;text-align:center;}
</style>
<div class="floor account">
    <div class="icon"><i class="fa fa-diamond"></i></div>
    <div class="tit">累积佣金</div>
    <div class="money"><small>￥</small><?php echo $user_info['commission']; ?></div>
</div>
<div class="floor">
<div class="banner_tit mt10">我的推荐</div>
<?php if($list){ ?>
    <ul class="goods_list_s cl">
        <?php foreach($list as $k=>$v){ ?>
        <li><span class="goods_thumb" style="width:72px;height:72px;"><img style="width:72px;height:72px;" alt="<?php echo $v['user_name']; ?>" src="<?php echo $v['head_img']; ?>"></span>
        <div class="goods_info"><p class="goods_tit"><?php echo $v['user_name']; ?></p>
        <p style="line-height:24px;">佣金：<?php echo $v['commission']; ?></p>
        <p style="line-height:24px;">注册时间：<?php echo date('Y-m-d',$v['add_time']); ?></p>
        </div></li>
        <?php } ?>
    </ul>
<?php }else{ ?>
    <div style="text-align:center;line-height:40px;color:#999;">暂无记录</div>
<?php } ?>
</div>
<script>
$(function(){
    var ajaxload  = false;
    var maxpage   = false;
    var startpage = 1;
    var totalpage = <?php echo $totalpage; ?>;
    
    var tmp_url   = window.location.href;
    msg = tmp_url.split("#");
    tmp_url = msg[0];
    
    $(window).scroll(function ()
    {
        var listheight = $(".goods_list_s").outerHeight(); 
        
        if ($(document).scrollTop() + $(window).height() >= listheight)
        {
            if(startpage >= totalpage)
            {
                //$("#submit_bt_one").html("已是最后一页，没有更多数据！");
                return false;
            }
            
            if(!ajaxload && !maxpage)
            {
                ajaxload = true;
                //$("#submit_bt_one").html("努力加载中...");
                var url = tmp_url;
                var nextpage = startpage+1;
                
                $.get(url,{page_ajax:1,page:nextpage},function(res)
                {
                    if(res)
                    {
                        $(".goods_list_s").append(res);
                        startpage++;
                        
                        if(startpage >= totalpage)
                        {
                            maxpage = true;
                            //$("#submit_bt_one").html("已是最后一页，没有更多数据！");
                        }
                        else
                        {
                            //$("#submit_bt_one").html("点击加载更多");
                        }
                        
                        ajaxload = false;
                    }
                    else
                    {
                        //$("#submit_bt_one").html("请求失败，请稍候再试！");
                        ajaxload = false;
                    }
                },'json');
            }
        }
    });
});
</script>

@include('weixin.common.footer')
</body></html>