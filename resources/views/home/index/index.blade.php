<!DOCTYPE html><html><head><meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
<title><?php echo sysconfig('CMS_SEOTITLE'); ?></title><meta name="keywords" content="<?php echo sysconfig('CMS_KEYWORDS'); ?>" /><meta name="description" content="<?php echo sysconfig('CMS_DESCRIPTION'); ?>" /><link rel="stylesheet" href="<?php echo sysconfig('CMS_BASEHOST'); ?>/css/style.css"></head><body>
@include('home.common.header')
<style>
.main-theme .item{width: 33.3%;width: 33.3% !important;height:120px;float: left;overflow: hidden;-webkit-transition: width .3s ease;-moz-transition: width .3s ease;-o-transition: width .3s ease;transition: width .3s ease;}
.main-theme .item img{width:100%;height:100%;}
</style>

<!--顶部滚动广告栏-start-->
<?php if ($slide_list) { ?>
<div class="box" style="margin-top:10px;margin-bottom:10px;">
    <!-- Swiper -->
    <div class="swiper-container">
        <div class="swiper-wrapper">
        <?php foreach ($slide_list as $k=>$v) { ?>
            <div class="swiper-slide"><a href="<?php if($v['url']){echo $v['url'];}else{echo 'javascript:;';} ?>"><img src="<?php echo $v['pic']; ?>" alt="<?php echo $v['title']; ?>"></a></div>
        <?php } ?>
        </div>
        <!-- Add Pagination -->
        <div class="swiper-pagination swiper-pagination-white"></div>
    </div>
</div>
<?php } ?>
<link rel="stylesheet" href="<?php echo env('APP_URL'); ?>/css/swiper.min.css">
<script type="text/javascript" src="<?php echo env('APP_URL'); ?>/js/swiper.min.js"></script>
<style>
.swiper-container{width:100%;height:auto;}
.swiper-slide{text-align:center;font-size:18px;background:#fff;}
.swiper-slide img{width:100%;height:320px;}
</style>
<script>
//Swiper轮播
var swiper = new Swiper('.swiper-container', {
    pagination: '.swiper-pagination',
    paginationClickable: true,
    autoHeight: true, //enable auto height
    slidesPerView: 1,
    paginationClickable: true,
    spaceBetween: 30,
    loop: true,
    centeredSlides: true,
    autoplay: 3000,
    autoplayDisableOnInteraction: false
});
</script>
<!--顶部滚动广告栏-end-->

<!--导航栏-start-->
<style>
.cat-menu-h {padding:8px 0;margin-bottom:10px;background-color: #fff;border-bottom: 1px dotted #ccc;border-top: 1px dotted #ccc;}
.cat-menu-h ul {font-size: 14px;}
.cat-menu-h ul li {float: left;}
.cat-menu-h ul a {display: block;padding: 2px 10px;text-align: center;color: #666;white-space: nowrap;}
.cat-menu-h ul a:hover {background-color: #e61414;color: #fff;}
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
<!--导航栏-end-->

<style>
.brandul{margin-right:-10px;}
.brandul li{margin: 0 10px 10px 0;-webkit-box-shadow: 0 1px 0 rgba(0,0,0,.1);-moz-box-shadow: 0 1px 0 rgba(0,0,0,.1);box-shadow: 0 1px 0 rgba(0,0,0,.1);float: left;}
.brandul li a{display: block;overflow: hidden;width: 100%;height: 100%;text-decoration: none;}
.brandul li .brand-pic{width: 475px;height: 186px;}
.brandul .brand-des{vertical-align: top;line-height: 26px;height: 26px;padding-left: 10px;border-left: 1px solid #F3F3F3;border-right: 1px solid #F3F3F3;color: #000;}
.brandul .brand-des em{color:#e61414;}
.brandul .brand-des .fl{margin-left:10px;}
.brandul .brand-des .fr{margin-right:20px;}
</style>
<div class="box" style="margin-bottom:5px;"><ul class="brandul">
<li>
<a href="" target="_blank">
<img class="brand-pic" src="/images/3.jpg">
<div class="brand-des"><span class="fl"></span>
<span class="fr"><em>234100</em>件已付款 &nbsp; <em>仅剩1天</em></span></div></a>
</li>
<li>
<a href="" target="_blank">
<img class="brand-pic" src="/images/3.jpg">
<div class="brand-des"><span class="fl"></span>
<span class="fr"><em>234100</em>件已付款 &nbsp; <em>仅剩1天</em></span></div></a>
</li>
</ul></div>

<style>
.index-tit span a{font-size:14px;color:#666;font-weight:400;}
.index-tit .spilt{margin:0 12px;font-size:14px;font-weight:400;}
</style>
<div class="box">
<p class="index-tit" style="font-weight:bold;font-size:28px;color:#333;margin-top:30px;margin-bottom:20px;">编辑推荐<small style="margin-left:20px;font-size:14px;color:#666;font-weight:400;">工厂直达消费者，剔除品牌溢价</small><span style="float:right;"><a href="">夏凉</a><b class="spilt">/</b><a href="">夏凉</a><b class="spilt">/</b><a href="">夏凉</a><b class="spilt">/</b><a href="">夏凉</a><b class="spilt">/</b><a href="">夏凉</a><b class="spilt">/</b><a href="">夏凉</a><a style="margin-left:20px;" href="">查看更多 ></a></span></p>
<ul class="pul">
<?php if($tjlist){foreach($tjlist as $k=>$v){ ?>
<li><a href="<?php echo route('home_goods',array('id'=>$v['id'])); ?>" target="_blank"><img src="<?php echo $v['litpic']; ?>" alt="<?php echo $v['title']; ?>">
<p class="title"><?php echo $v['title']; ?></p>
<p class="desc"><span class="price-point"><i></i>库存(<?php echo $v['goods_number']; ?>)</span> <?php echo $v['description']; ?></p>
<div class="item-prices red"><div class="item-link">立即<br>抢购</div><div class="item-info"><div class="price"><i>¥</i><em class="J_actPrice"><span class="yen"><?php echo ceil($v['price']); ?></span></em></div>
<div class="dock"><div class="dock-price"><del class="orig-price">¥<?php echo $v['market_price']; ?></del> <span class="benefit">包邮</span></div><div class="prompt"><div class="sold-num"><em><?php echo $v['sale']; ?></em> 件已付款</div></div></div>
</div></div>
</a></li>
<?php }} ?>
</ul></div>

<div class="box">
<p style="font-weight:bold;font-size:28px;color:#333;margin-top:30px;margin-bottom:20px;">热门商品</p>
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

<div class="box nomore" style="text-align:center;line-height:46px;font-size:18px;color:#999;margin-bottom:10px;display:none;">没有更多数据了</div>

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

<script>
console.log("Github地址：https://github.com/Fanli2012/lqycms\nEmail:374861669@qq.com");
</script>
@include('home.common.footer')
</body></html>