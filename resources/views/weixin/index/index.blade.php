<!DOCTYPE html><html><head><meta http-equiv="content-type" content="text/html;charset=utf-8"/>
<title>商城</title><meta content="width=device-width,initial-scale=1.0,minimum-scale=1.0,maximum-scale=1.0,user-scalable=0" name="viewport">
<link href="<?php echo env('APP_URL'); ?>/css/weixin/style.css" type="text/css" rel="stylesheet">
<script type="text/javascript" src="<?php echo env('APP_WEIXIN'); ?>/js/jquery.min.js"></script>
<meta name="keywords" content="关键词"><meta name="description" content="描述"></head><body>
<!--顶部搜索栏-start-->
<div id="search-placeholder" class="search">
    <div class="search_box">
        <a href="ajaxSearch.html">
        <span class="search_btn"><img src="<?php echo env('APP_URL'); ?>/images/weixin/search.png"></span>
        <input type="text" name="keyword" value="" placeholder="搜索您想要的商品"></a>
    </div>
</div>
<!--顶部搜索栏-end-->

<!--顶部滚动广告栏-start-->
<div class="tbanner">
    <!-- Swiper -->
    <div class="swiper-container">
        <div class="swiper-wrapper">
        <?php foreach($slide_list as $k=>$v){ ?>
            <div class="swiper-slide"><img src="<?php echo $v['pic']; ?>" alt="<?php echo $v['title']; ?>"></div>
        <?php } ?>
        </div>
        <!-- Add Pagination -->
        <div class="swiper-pagination swiper-pagination-white"></div>
    </div>
</div>
<link rel="stylesheet" href="<?php echo env('APP_URL'); ?>/css/swiper.min.css">
<style>
.swiper-container{width:100%;height:auto;}
.swiper-slide{text-align:center;font-size:18px;background:#fff;}
.swiper-slide img{width:100%;height:40vw;}
</style>
<script type="text/javascript" src="<?php echo env('APP_URL'); ?>/js/swiper.min.js"></script>
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

<!--导航左右滑动-start-->
<div class="swiper-nav">
    <div class="swiper-wrapper">
        <div class="swiper-slide">新闻</div>
        <div class="swiper-slide">音乐</div>
        <div class="swiper-slide">Slide 3</div>
        <div class="swiper-slide">Slide 4</div>
        <div class="swiper-slide">Slide 5</div>
        <div class="swiper-slide">Slide 6</div>
        <div class="swiper-slide">Slide 7</div>
        <div class="swiper-slide">Slide 8</div>
        <div class="swiper-slide">Slide 9</div>
        <div class="swiper-slide">Slide 10</div>
        <div class="swiper-slide">Slide 3</div>
        <div class="swiper-slide">Slide 4</div>
        <div class="swiper-slide">Slide 5</div>
        <div class="swiper-slide">Slide 6</div>
        <div class="swiper-slide">Slide 7</div>
        <div class="swiper-slide">Slide 8</div>
        <div class="swiper-slide">Slide 9</div>
        <div class="swiper-slide">Slide 10</div>
    </div>
</div>
<style>.swiper-nav {width: 100%;height: 50px;line-height:50px;border-bottom:1px solid #efefef;}</style>
<script>
var swiper = new Swiper('.swiper-nav', {
    slidesPerView: 4 //一行4列显示
});
</script>
<!--导航左右滑动-end-->

<!--菜单-start-->
<div class="floor home_menu">
    <nav>
        <a href="/index.php/mobile/Goods/categoryList.html">
                <img src="images/weixin/icon_03.png" alt="全部分类" />
                <span>全部分类</span>
        </a>
        <a href="http://www.shop.com/index.php/mobile/Goods/integralMall.html">
                <img src="images/weixin/icon_05.png" alt="积分商城" />
                <span>积分商城</span>
        </a>
        <a href="http://www.shop.com/index.php/mobile/Goods/brandstreet.html">
                <img src="images/weixin/icon_07.png" alt="品牌街" />
                <span>品牌街</span>
        </a>
        <a href="http://www.shop.com/index.php/mobile/Activity/promote_goods.html">
                <img src="images/weixin/icon_09.png" alt="优惠活动" />
                <span>优惠活动</span>
        </a>
        <a href="http://www.shop.com/index.php/mobile/Activity/group_list.html">
                <img src="images/weixin/icon_15.png" alt="团购" />
                <span>团购</span>
        </a>
        <a href="http://www.shop.com/index.php/mobile/User/order_list.html">
                <img src="images/weixin/icon_16.png" alt="我的订单" />
                <span>我的订单</span>
        </a>
        <a href="http://www.shop.com/index.php/mobile/Cart/index.html">
                <img src="images/weixin/icon_17.png" alt="购物车" />
                <span>购物车</span>
        </a>
        <a href="http://www.shop.com/index.php/mobile/User/index.html">
                <img src="images/weixin/icon_19.png" alt="个人中心" />
                <span>个人中心</span>
        </a>
    </nav>
</div>
<!--菜单-end-->

<!--资讯头条-start-->
<div class="bggrey">
<div class="home_toutiao">
    <div class="home_toutiao_tit"><img src="images/weixin/ad_tit.png"></div>
    <div class="home_toutiao_box">
        <ul>
          <marquee id="mar1" scrollamount="1" direction="up" height="30" style="height: 30px;">
          <?php foreach($article_list as $k=>$v){ ?><li><a href="/Weixin/index.php?m=Article&amp;a=arclist&amp;id=38"><?php echo $v['title']; ?></a></li><?php } ?>
          </marquee>
        </ul>
    </div>
</div>
</div>
<!--资讯头条-end-->

<!--猜您喜欢-start-->
<div class="floor guesslike">
    <div class="banner_tit"><img src="images/weixin/ind_52.jpg" alt="猜您喜欢"/></div>
    <div class="likeshop">
        <ul class="goods_list" id="goods_list">
            <li><a href="detail.html"><img alt="1" src="images/weixin/goods_thumb_400_400.jpeg"><div class="goods_info"><p class="goods_tit">美女真空凸点诱惑</p><div class="goods_price">￥<b>100.00</b></div></div></a></li>
            <li><a href="detail.html"><img alt="2" src="images/weixin/goods_thumb_400_400.jpeg"><div class="goods_info"><p class="goods_tit">性感小骚货在床上</p><div class="goods_price">￥<b>100.00</b></div></div></a></li>
            <li><a href="detail.html"><img alt="3" src="images/weixin/goods_thumb_400_400.jpeg"><div class="goods_info"><p class="goods_tit">小野猫嫩模大尺度写真</p><div class="goods_price">￥<b>100.00</b></div></div></a></li>
            <li><a href="detail.html"><img alt="4" src="images/weixin/goods_thumb_400_400.jpeg"><div class="goods_info"><p class="goods_tit">韩国嫩模的逆天身材</p><div class="goods_price">￥<b>100.00</b></div></div></a></li>
            <li><a href="detail.html"><img alt="5" src="images/weixin/goods_thumb_400_400.jpeg"><div class="goods_info"><p class="goods_tit">推女郎林夕图片</p><div class="goods_price">￥<b>100.00</b></div></div></a></li>
            <li><a href="detail.html"><img alt="6" src="images/weixin/goods_thumb_400_400.jpeg"><div class="goods_info"><p class="goods_tit">性感闺蜜艺术照</p><div class="goods_price">￥<b>100.00</b></div></div></a></li>
        </ul>
    </div>
</div>
<script>
$(function(){
    var ajaxload=false;
    var maxpage=false;
    var startpage=1;
    var totalpage="{$totalpage}";
    var tmp_url = window.location.href;
    msg = tmp_url.split("#");
    tmp_url = msg[0];
    $(window).scroll(function ()
	{
        var listheight = $("#goods_list").outerHeight(); 
        
        if ($(document).scrollTop() + $(window).height() >= listheight) {
            if(startpage>=totalpage){
                //$("#submit_bt_one").html("已是最后一页，没有更多数据！");
                return false;
            }
            if(!ajaxload&&!maxpage){
                ajaxload=true;
                //$("#submit_bt_one").html("努力加载中...");
                var url = tmp_url;
                var nextpage = startpage+1;
				var role_id = "{$role_id}";
                $.post(url,{page_ajax:1,page:nextpage,role_id:role_id},function(data){
				//alert(data.html);
                    if(data.html){
                        $("#goods_list").append(data.html);
                        startpage++;
                        if(startpage>=totalpage){
                            maxpage=true;
                            //$("#submit_bt_one").html("已是最后一页，没有更多数据！");
                        }else{
                            //$("#submit_bt_one").html("点击加载更多");
                        }
                        ajaxload=false;
                    }else{
                        //$("#submit_bt_one").html("请求失败，请稍候再试！");
                        ajaxload=false;
                    }
                },'json');
            }
        }
    });
});

function messageNotice(message)
{
	$("#message").html(message);
	$(".messageShow").show();
	setInterval(function(){$(".messageShow").hide();},3000);
}
</script>
<!--猜您喜欢-end-->

@include('weixin.common.footer')
</body></html>