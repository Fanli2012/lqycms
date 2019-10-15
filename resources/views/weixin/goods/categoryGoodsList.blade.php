<!DOCTYPE html><html><head><meta http-equiv="content-type" content="text/html;charset=utf-8"/>
<title>商品分类</title><meta content="width=device-width,initial-scale=1.0,minimum-scale=1.0,maximum-scale=1.0,user-scalable=0" name="viewport">
<link href="<?php echo env('APP_URL'); ?>/css/weixin/style.css" type="text/css" rel="stylesheet">
<script type="text/javascript" src="<?php echo env('APP_URL'); ?>/js/jquery.min.js"></script><script type="text/javascript" src="<?php echo env('APP_URL'); ?>/js/weixin/mobile.js"></script>
<meta name="keywords" content="关键词"><meta name="description" content="描述"></head><body style="background-color:#f1f1f1;">

<div class="classreturn loginsignup">
    <div class="ds-in-bl return"><a href="javascript:history.back(-1);"><img src="<?php echo env('APP_URL'); ?>/images/weixin/return.png" alt="返回"></a></div>
    <div class="ds-in-bl tit center"><span>所有分类</span></div>
    <div class="ds-in-bl nav_menu"><a href="javascript:void(0);"><img src="<?php echo env('APP_URL'); ?>/images/weixin/class1.png" alt="菜单"></a></div>
</div>

@include('weixin.common.headerNav')

<!--导航左右滑动-start-->
<!--<link rel="stylesheet" href="<?php echo env('APP_URL'); ?>/css/swiper.min.css">
<script type="text/javascript" src="<?php echo env('APP_URL'); ?>/js/swiper.min.js"></script>
<div class="swiper-nav">
    <div class="swiper-wrapper">
        <div class="swiper-slide"><a<?php if(0==$typeid){echo ' style="color:#ee5b03;border-bottom:1px solid #ee5b03;"';} ?> href="<?php echo route('weixin_category_goods_list'); ?>" data-id="0">全部</a></div>
        <?php if($goodstype_list){foreach($goodstype_list as $k=>$v){ ?>
        <div class="swiper-slide"><a style="<?php if($v['id']==$typeid){echo 'color:#ee5b03;border-bottom:1px solid #ee5b03;';} ?>" href="<?php echo route('weixin_category_goods_list',array('typeid'=>$v['id'])); ?>" data-id="<?php echo $v['id']; ?>"><?php echo $v['name']; ?></a></div>
        <?php }} ?>
    </div>
</div>-->
<style>
.swiper-nav{width:100%;height:50px;line-height:50px;border-bottom:1px solid #f0f0f0;background-color:#fff;}
.swiper-slide{text-align:center;font-size:18px;background:#fff;}
.swiper-slide a{display:block;}
</style>
<script>
var swiper = new Swiper('.swiper-nav', {
    slidesPerView: 4 //一行4列显示
});
</script>
<!--导航左右滑动-end-->

<!-- <div class="floor guesslike">
    <?php if($list){ ?>
    <ul class="goodslist_limg mt10" id="goods_list">
    <?php foreach($list as $k=>$v){ ?>
        <li><a href="<?php echo $v['goods_detail_url']; ?>"><img alt="<?php echo $v['title']; ?>" src="<?php echo $v['litpic']; ?>"><div class="goods_info"><p class="goods_tit"><?php if($v['is_promote_goods']>0){ ?><span class="badge_comm" style="background-color:#f23030;">Hot</span> <?php } ?><?php echo $v['title']; ?></p><div class="goods_price">￥<b><?php echo $v['price']; ?></b><span class="fr"><?php echo $v['sale']; ?>人付款</span></div></div></a></li>
    <?php } ?>
    </ul><?php }else{ ?><div style="text-align:center;line-height:40px;color:#999;">暂无记录</div><?php } ?>
</div> -->
<div class="flool classlist" style="margin-top:4px;">
    <div class="fl category1">
        <ul>
        <li<?php if(0==$typeid){echo ' class="on"';} ?>>
            <a href="<?php echo route('weixin_category_goods_list'); ?>" data-id="0">全部</a>
        </li>
        <?php if($goodstype_list){foreach($goodstype_list as $k=>$v){ ?>
            <li<?php if($v['id']==$typeid){echo ' class="on"';} ?>>
               <a href="<?php echo route('weixin_category_goods_list',array('typeid'=>$v['id'])); ?>" data-id="<?php echo $v['id']; ?>"><?php echo $v['name']; ?></a>
            </li>
        <?php }} ?>
        </ul>
    </div>
    <div class="fr category2">
        <?php if($list){ ?>
        <ul class="goods_list_small" id="goods_list">
        <?php foreach($list as $k=>$v){ ?>
            <li><a href="<?php echo $v['goods_detail_url']; ?>"><img class="imgzsy" alt="<?php echo $v['title']; ?>" src="<?php echo $v['litpic']; ?>"><div class="goods_info"><p class="goods_tit"><?php if($v['is_promote_goods']>0){ ?><span class="badge_comm" style="background-color:#f23030;">Hot</span> <?php } ?><?php echo $v['title']; ?></p><div class="goods_price">￥<b><?php echo $v['price']; ?></b></div></div></a></li>
        <?php } ?>
        </ul>
        <?php }else{ ?>
            <div style="text-align:center;line-height:40px;color:#999;">暂无记录</div>
        <?php } ?>
    </div>
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
        var listheight = $("#goods_list").outerHeight(); 
        
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
                        $("#goods_list").append(res);
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