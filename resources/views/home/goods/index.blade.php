<!DOCTYPE html><html><head><meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
<title><?php echo sysconfig('CMS_WEBNAME'); ?></title><meta name="keywords" content="{dede:field.keywords/}" /><meta name="description" content="{dede:field.description function='html2text(@me)'/}" /><link rel="stylesheet" href="<?php echo sysconfig('CMS_BASEHOST'); ?>/css/style.css"></head><body>
@include('home.common.header')

<style>
.cat-menu-h {padding:8px 0;background-color: #fff;}
.cat-menu-h ul {font-size: 14px;}
.cat-menu-h ul li {float: left;}
.cat-menu-h ul a {display: block;padding: 2px 10px;text-align: center;color: #666;white-space: nowrap;}
.cat-menu-h ul a:hover,.cat-menu-h ul .hover{background-color: #e61414;color: #fff;}
.cat-menu-h ul a.forecast:hover {background-color: #26a96d;color: #fff;}
.cat-menu-h ul a.forecast {color: #26a96d;}
</style>
<div class="box">
<div class="cat-menu-h">
<ul class="clearfix">
<li><a<?php if(route('home_goodslist') == url()->full()){echo ' class="hover"';} ?> href="<?php echo route('home_goodslist'); ?>">全部</a></li>
<?php if($goodstype_list){foreach($goodstype_list as $k=>$v){ ?>
<li><a<?php if(route('home_goodslist',array('typeid'=>$v['id'])) == url()->full()){echo ' class="hover"';} ?> href="<?php echo route('home_goodslist',array('typeid'=>$v['id'])); ?>"><?php echo $v['name']; ?></a></li><?php }} ?>
<li><a class="forecast" href="<?php echo route('home_goodslist',array('tuijian'=>1)); ?>"> [推荐] </a></li>
</ul>

<form method="get" class="m-sch fr" name="formsearch" action="<?php echo route('home_goodslist'); ?>"><input class="sch-txt" name="keyword" type="text" value="搜索 按Enter键" onfocus="if(value=='搜索 按Enter键') {value=''}" onblur="if(value=='') {value='搜索 按Enter键'}"></form>
<div class="cl"></div></div>
</div>

<div style="background-color:#F3F3F3;padding:15px 0;">
<div class="box">
<ul class="pul" id="goods_list">
<?php if($list){foreach($list as $k=>$v){ ?>
<li><a href="<?php echo route('home_goods',array('id'=>$v['id'])); ?>" target="_blank"><img src="<?php echo $v['litpic']; ?>" alt="<?php echo $v['title']; ?>">
<p class="title"><?php echo $v['title']; ?></p>
<p class="desc"><span class="price-point"><i></i>库存(<?php echo $v['goods_number']; ?>)</span> <?php echo $v['description']; ?></p>
<div class="item-prices red"><div class="item-link">立即<br>抢购</div><div class="item-info"><div class="price"><i>¥</i><em class="J_actPrice"><span class="yen"><?php echo ceil($v['price']); ?></span></em></div>
<div class="dock"><div class="dock-price"><del class="orig-price">¥<?php echo $v['market_price']; ?></del> <span class="benefit">包邮</span></div><div class="prompt"><div class="sold-num"><em><?php echo $v['sale']; ?></em> 件已付款</div></div></div>
</div></div>
</a></li>
<?php }} ?>
</ul></div>

<div class="box nomore" style="text-align:center;line-height:46px;font-size:18px;color:#999;display:none;">没有更多数据了</div>

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
                $(".nomore").show();
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
                            $(".nomore").show();
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
</div><!-- box end -->

@include('home.common.footer')
</body></html>