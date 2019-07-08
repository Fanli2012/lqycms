<!DOCTYPE html><html><head><meta http-equiv="content-type" content="text/html;charset=utf-8"/>
<title>微商城</title><meta content="width=device-width,initial-scale=1.0,minimum-scale=1.0,maximum-scale=1.0,user-scalable=0" name="viewport">
<link href="<?php echo env('APP_URL'); ?>/css/weixin/style.css" type="text/css" rel="stylesheet">
<script type="text/javascript" src="<?php echo env('APP_URL'); ?>/js/jquery.min.js"></script>
<meta name="keywords" content="关键词"><meta name="description" content="描述"></head><body>
<!--顶部搜索栏-start-->
<div id="search-placeholder" class="search">
    <div class="search_box">
        <a href="<?php echo route('weixin_search'); ?>">
        <span class="search_btn"><img src="<?php echo env('APP_URL'); ?>/images/weixin/search.png"></span>
        <input type="text" name="keyword" value="" placeholder="搜索您想要的商品"></a>
    </div>
</div>
<!--顶部搜索栏-end-->

<!--顶部滚动广告栏-start-->
<?php if($slide_list){ ?>
<div class="tbanner">
    <!-- Swiper -->
    <div class="swiper-container">
        <div class="swiper-wrapper">
        <?php foreach($slide_list as $k=>$v){ ?>
            <div class="swiper-slide"><a href="<?php echo $v['url']; ?>"><img src="<?php echo $v['pic']; ?>" alt="<?php echo $v['title']; ?>"></a></div>
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
.swiper-slide img{width:100%;height:40vw;}
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

<!--导航左右滑动-start-->
<!--<div class="swiper-nav">
    <div class="swiper-wrapper">
        <div class="swiper-slide">新闻</div>
        <div class="swiper-slide">音乐</div>
        <div class="swiper-slide">Slide 3</div>
        <div class="swiper-slide">Slide 4</div>
        <div class="swiper-slide">Slide 5</div>
    </div>
</div>
<style>.swiper-nav{width: 100%;height: 50px;line-height:50px;border-bottom:1px solid #efefef;background-color:#fff;}</style>
<script>
var swiper = new Swiper('.swiper-nav', {
    slidesPerView: 4 //一行4列显示
});
</script>-->
<!--导航左右滑动-end-->

<!--菜单-start-->
<div class="floor home_menu" style="background-color:#fff;border-bottom:1px solid #f0f0f0;border-top:1px solid #f0f0f0;">
    <nav>
        <a href="<?php echo route('weixin_category_goods_list'); ?>">
                <img src="<?php echo env('APP_URL'); ?>/images/weixin/icon_05.png" alt="全部分类" />
                <span>全部分类</span>
        </a>
        <a href="<?php echo route('weixin_brand_list'); ?>">
                <img src="<?php echo env('APP_URL'); ?>/images/weixin/icon_07.png" alt="品牌街" />
                <span>品牌街</span>
        </a>
        <a href="<?php echo route('weixin_goods_list',array('orderby'=>5)); ?>">
                <img src="<?php echo env('APP_URL'); ?>/images/weixin/icon_15.png" alt="优惠商品" />
                <span>优惠商品</span>
        </a>
        <a href="<?php echo route('weixin_order_list'); ?>">
                <img src="<?php echo env('APP_URL'); ?>/images/weixin/icon_16.png" alt="我的订单" />
                <span>我的订单</span>
        </a>
        <a href="<?php echo route('weixin_cart'); ?>">
                <img src="<?php echo env('APP_URL'); ?>/images/weixin/icon_17.png" alt="购物车" />
                <span>购物车</span>
        </a>
        <a href="<?php echo route('weixin_user'); ?>">
                <img src="<?php echo env('APP_URL'); ?>/images/weixin/icon_19.png" alt="个人中心" />
                <span>个人中心</span>
        </a>
        <a href="javascript:;">
                <img src="<?php echo env('APP_URL'); ?>/images/weixin/icon_03.png" alt="敬请期待" />
                <span>敬请期待</span>
        </a>
    </nav>
</div>
<!--菜单-end-->

<!--资讯头条-start-->
<div class="bggrey">
<div class="home_toutiao" style="border-bottom:1px solid #f0f0f0;">
    <div class="home_toutiao_tit"><img src="<?php echo env('APP_URL'); ?>/images/weixin/ad_tit.png"></div>
    <div class="home_toutiao_box">
        <ul>
          <marquee id="mar1" scrollamount="1" direction="up" height="30" style="height: 30px;">
          <?php if($article_list){foreach($article_list as $k=>$v){ ?><li><a href="<?php echo $v['article_detail_url']; ?>"><?php echo $v['title']; ?></a></li><?php }} ?>
          </marquee>
        </ul>
    </div>
</div>
</div>
<!--资讯头条-end-->

<!--猜您喜欢-start-->
<div class="floor guesslike" style="background-color:#fff;">
    <div class="banner_tit">购·畅销</div>
    <ul class="goods_list_s cl">
    <?php if($goods_sale_list){foreach($goods_sale_list as $k=>$v){ ?>
        <a href="<?php echo $v['goods_detail_url']; ?>"><li><span class="goods_thumb"><img alt="<?php echo $v['title']; ?>" src="<?php echo $v['litpic']; ?>"></span>
        <div class="goods_info"><p class="goods_tit"><?php echo $v['title']; ?></p>
        <p class="goods_price">￥<b><?php echo $v['price']; ?></b></p>
        <p class="goods_des">已售：<?php echo $v['sale']; ?><a href="<?php echo $v['goods_detail_url']; ?>"><span class="buy fr">立即抢购</span></a></p>
        </div>
        </li></a>
    <?php }} ?>
    </ul>
</div>
<!--猜您喜欢-end-->

<!--猜您喜欢-start-->
<div class="floor guesslike">
    <div class="banner_headline"><div class="tit"><h4>购·精选</h4></div></div>
    <div class="likeshop">
        <ul class="goods_list" id="goods_list">
        <?php if($goods_recommend_list){foreach($goods_recommend_list as $k=>$v){ ?>
            <li><a href="<?php echo $v['goods_detail_url']; ?>"><img alt="<?php echo $v['title']; ?>" src="<?php echo $v['litpic']; ?>"><div class="goods_info"><p class="goods_tit"><?php if($v['is_promote_goods']>0){ ?><span class="badge_comm" style="background-color:#f23030;">Hot</span> <?php } ?><?php echo $v['title']; ?></p><div class="goods_price">￥<b><?php echo $v['price']; ?></b><span class="fr"><?php echo $v['sale']; ?>人付款</span></div></div></a></li>
        <?php }} ?>
        </ul>
    </div>
</div>
<!--猜您喜欢-end-->

<!--猜您喜欢-start-->
<div class="floor guesslike">
    <div class="banner_headline" style="margin-top:-4px;"><div class="tit"><h4>购·优惠</h4></div></div>
    <div class="likeshop">
        <ul class="goods_list" id="goods_list">
        <?php if($goods_promote_list){foreach($goods_promote_list as $k=>$v){ ?>
            <li><a href="<?php echo $v['goods_detail_url']; ?>"><img alt="<?php echo $v['title']; ?>" src="<?php echo $v['litpic']; ?>"><div class="goods_info"><p class="goods_tit"><?php if($v['is_promote_goods']>0){ ?><span class="badge_comm" style="background-color:#f23030;">Hot</span> <?php } ?><?php echo $v['title']; ?></p><div class="goods_price">￥<b><?php echo $v['price']; ?></b><span class="fr"><?php echo $v['sale']; ?>人付款</span></div></div></a></li>
        <?php }} ?>
        </ul>
    </div>
</div>
<!--猜您喜欢-end-->

<!--猜您喜欢-start-->
<div class="floor guesslike">
    <div class="banner_headline"><div class="tit"><h4>购·新品</h4></div></div>
    <div class="likeshop">
        <ul class="goods_list" id="goods_list">
        <?php if($goods_list){foreach($goods_list as $k=>$v){ ?>
            <li><a href="<?php echo $v['goods_detail_url']; ?>"><img alt="<?php echo $v['title']; ?>" src="<?php echo $v['litpic']; ?>"><div class="goods_info"><p class="goods_tit"><?php if($v['is_promote_goods']>0){ ?><span class="badge_comm" style="background-color:#f23030;">Hot</span> <?php } ?><?php echo $v['title']; ?></p><div class="goods_price">￥<b><?php echo $v['price']; ?></b><span class="fr"><?php echo $v['sale']; ?>人付款</span></div></div></a></li>
        <?php }} ?>
        </ul>
    </div>
</div>
<!--猜您喜欢-end-->

<style>
.banner_tit{font-size:18px;font-weight:400;background-color:#fff;color:#f23030;height:46px;line-height:46px;padding-left:10px;padding-right:10px;border-bottom:1px solid #eee;text-align:center;}
</style>
@include('weixin.common.footer')
<script>
console.log("Github地址：https://github.com/Fanli2012/lqycms\nEmail:374861669@qq.com");
</script>
</body></html>