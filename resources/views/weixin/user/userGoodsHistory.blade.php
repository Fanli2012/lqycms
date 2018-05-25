<!DOCTYPE html><html><head><meta http-equiv="content-type" content="text/html;charset=utf-8"/>
<title>我的足迹</title><meta name="keywords" content="关键词"><meta name="description" content="描述"><meta content="width=device-width,initial-scale=1.0,minimum-scale=1.0,maximum-scale=1.0,user-scalable=0" name="viewport">
<link href="<?php echo env('APP_URL'); ?>/css/weixin/style.css" type="text/css" rel="stylesheet">
<script type="text/javascript" src="<?php echo env('APP_URL'); ?>/js/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo env('APP_URL'); ?>/js/weixin/mobile.js"></script></head><body>
<div class="classreturn loginsignup">
    <div class="ds-in-bl return"><a href="javascript:history.back(-1);"><img src="<?php echo env('APP_URL'); ?>/images/weixin/return.png" alt="返回"></a></div>
    <div class="ds-in-bl tit center"><span>我的足迹</span></div>
    <div class="ds-in-bl nav_menu"><a href="javascript:void(0);" style="color:#999;" id="clear_history"  onclick="delconfirm('<?php echo route('weixin_user_goods_history_clear'); ?>','确定要清空吗？')">清空</a></div>
</div>

<script type="text/javascript" src="<?php echo env('APP_URL'); ?>/js/layer/mobile/layer.js"></script>
<div class="floor">
<?php if($user_goods_history){ ?>
    <ul class="goods_list_s cl">
        <?php foreach($user_goods_history as $k=>$v){ ?>
        <li><a href="<?php echo route('weixin_goods_detail',array('id'=>$v['goods']['id'])); ?>"><span class="goods_thumb"><img alt="<?php echo $v['goods']['title']; ?>" src="<?php echo env('APP_URL'); ?><?php echo $v['goods']['litpic']; ?>"></span></a>
        <div class="goods_info"><p class="goods_tit"><?php echo $v['goods']['title']; ?></p>
        <p class="goods_price">￥<b><?php echo $v['goods']['price']; ?></b></p>
        <p class="goods_des fr"><span class="btn" id="del_history" onclick="delconfirm('<?php echo route('weixin_user_goods_history_delete',array('id'=>$v['id'])); ?>')">删除</span></p>
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