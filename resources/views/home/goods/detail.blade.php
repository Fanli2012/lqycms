<!DOCTYPE html><html><head><meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
<title><?php echo $post->title; ?>_<?php echo sysconfig('CMS_WEBNAME'); ?></title><meta name="keywords" content="{dede:field.keywords/}" /><meta name="description" content="{dede:field.description function='html2text(@me)'/}" /><link rel="stylesheet" href="<?php echo sysconfig('CMS_BASEHOST'); ?>/css/style.css"><script type="text/javascript" src="<?php echo sysconfig('CMS_BASEHOST'); ?>/js/ad.js"></script></head><body>
@include('home.common.header')
<script type="text/javascript" src="<?php echo env('APP_URL'); ?>/js/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo env('APP_URL'); ?>/js/layer/layer.js"></script>
<style>
.detail-main {margin-top:15px;padding: 10px;position: relative;color: #626262;background: #fff;}
.detail-main .header {height: 28px;line-height: 28px;padding-bottom:8px;border-bottom: 1px dashed #ececec;font-size: 16px;}
.detail-main .header .crumbs {float: left;vertical-align: middle;margin-right: 15px;_display: inline;}
.detail-main .header .crumbs a {color: #686868;}
.detail-main .header .crumbs li {display: inline;}
.detail-main .header .crumbs .arrow {width: 0;height: 0;display: inline-block;zoom: 1;border-style: solid;border-width: 4px;border-color: transparent transparent transparent #686868;position: relative;top: -1px;margin: 0 4px 0 8px;}
.detail-main .header .crumbs .arrow small {position: absolute;top: -4px;left: -5px;width: 0;height: 0;display: inline-block;zoom: 1;border-style: solid;border-width: 4px;border-color: transparent transparent transparent #fff;}
.detail-main .header .bookMark {float: right;margin-right: 10px;_display: inline;font-size: 14px;color: #626262;}
.detail-main .header .bookMark span {font-family: ju-font;font-size: 18px;margin-left:5px;}
.detail-main .header .bookMark span{display: inline-block;border-top:6px solid transparent;border-left:8px solid #666;border-bottom:6px solid transparent;width: 0;height: 0;}
.detail-main .main-pic {margin-top: 10px;float: left;width: 360px;_overflow: hidden;}
.normal-pic-wrapper .normal-pic {position: relative;display: table-cell;text-align: center;width: 360px;}
.normal-pic .item-pic-wrap {position: relative;}
.normal-pic-wrapper .item-pic-wrap .pic {background-size: cover;background-position: center center;background-repeat: no-repeat;height: 360px;width: 360px;}
.detail-main .main-box {float: right;width: 560px;_width: 545px;margin-right: 5px;_display: inline;}
.detail-main .main-box .title {margin:8px 0;color:#333;font-size:24px;line-height:34px;font-weight: normal;text-align: justify;}
.detail-main .main-box .description {color:#999;font-size: 14px;line-height: 20px;word-break: break-all;}
.detail-main .price {margin: 20px 0;font-size: 14px;}
.detail-main .price .rmb {font-size: 30px;margin-right: 3px;color: #d33a31;}
.detail-main .price em {margin-right: 4px;font-size: 30px;color: #d33a31;}
.detail-main .price .dis {margin-left: 16px;font-size: 16px;color: #999;text-decoration: line-through;}
.detail-main .price sub {position: relative;top: -5px;font-size: 14px;color: #cb3b3b;}
</style>
<div style="background-color:#f3f3f3;padding-bottom:10px;">
<div class="box">
<div class="detail-main  clearfix">
<div class="header clearfix">
    <ul class="crumbs">
        <li><a href="<?php echo route('home'); ?>">首页</a></li>
        <span class="arrow"><small></small></span>
        <li><a href="<?php echo route('home_goodslist'); ?>">所有商品</a></li>
        <span class="arrow"><small></small></span>
        <li><a href="<?php echo route('home_goodslist',array('typeid'=>$post->typeid)); ?>"><?php echo $post->type_name; ?></a></li>
    </ul>
    <a class="bookMark" href="<?php echo route('home_goodslist',array('id'=>$post->id)); ?>">查看更多同类商品<span></span></a>
</div>
    
<div class="clearfix">
<div class="main-pic">
    <div class="normal-pic-wrapper clearfix" data-spm="ne">
        <div class="normal-pic ">
    <!-- Swiper -->
    <div class="swiper-container">
        <div class="swiper-wrapper">
            <?php if($post->goods_img_list){foreach($post->goods_img_list as $k=>$v){ ?><div class="swiper-slide"><img src="<?php echo $v->url; ?>" alt="<?php echo $v->des; ?>"></div><?php }} ?>
        </div>
        <!-- Add Pagination -->
        <div class="swiper-pagination swiper-pagination-white"></div>
    </div>
<link rel="stylesheet" href="<?php echo env('APP_URL'); ?>/css/swiper.min.css">
<style>
.swiper-container{width:360px;height:360px;}
.swiper-slide{text-align:center;font-size:18px;background:#fff;}
.swiper-slide img{width:360px;height:360px;}
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
        </div>
    </div>
</div>

<div class="main-box J_mainBox avil">
<h2 class="title"><?php echo $post->title; ?></h2>
<?php if($post->description){ ?><div class="description"><?php echo $post->description; ?></div><?php } ?>
<p class="price "><span class="rmb">¥</span><em class="j-flag"><?php echo $post->price; ?></em><sub class="dis">¥<span class="j-flag j-original"><?php echo $post->market_price; ?></span></sub></p>
<p class="buyorjoin j-flag f-cb"><a style="box-sizing: border-box;line-height: 47px;width: 170px;height: 50px;margin-top:10px;font-size: 18px;border: 2px solid #d33a31;color: #d33a31;background-color: white;display: inline-block;text-align: center;margin-right: 10px;" href="javascript:submit();">立即购买</a><a style="width: 188px;height: 50px;line-height: 50px;margin-top:10px;font-size: 18px;background-color: #d33a31;display: inline-block;text-align: center;color: #fff;" href="javascript:submit();">加入购物车</a></p>
</div>
<div class="cl"></div></div>
</div>
</div>
</div>
<script>
function submit()
{
    //自定页
    layer.open({
        type: 1,
        title: '请用【微信扫一扫】下单',
        closeBtn: 0, //不显示关闭按钮
        anim: 2,
        shadeClose: true, //开启遮罩关闭
        content: '<img src="<?php echo get_erweima(route('weixin_goods_detail',array('id'=>$post->id)),360); ?>">'
    });
}
</script>
<style>
.widget-box {border: 1px solid #d9d9d9;background: #fff;position: relative;margin-bottom: 10px;}
.widget-box .tit.none {border: none;}
.widget-box .tit {padding: 0 15px;height: 50px;line-height: 50px;border-bottom: 1px solid #d9d9d9;font-size: 14px;color: #000;background: #f9f9f9;overflow: hidden;}
.widget-box .con {padding: 6px 10px;}
.detail-detail{border: 1px solid #d9d9d9;background: #fff;}
.detail-detail .detail-con{padding:10px 5px;overflow: hidden;}
.detail-detail .dd-header{height: 50px;line-height: 50px;border-bottom: 1px solid #d7d7d7;}
.detail-detail .dd-header span{margin-right: -1px;background: #51b2d6;color: #fff;font-weight: 700;float: left;height: 50px;font-size: 14px;padding: 0 30px;text-align: center;}

.recom-list .tab-pannel {width: 210px;height: 220px;}
.recom-list .tab-pannel a {position: relative;border: 1px solid #d7d7d7;margin-bottom: 10px;display: block;width: 208px;height: 208px;color: #454545;}
.recom-list .tab-pannel img {width: 208px;height: 208px;}
.recom-list .tab-pannel .look-price {height: 32px;text-align: center;font-size: 12px;position: absolute;bottom: 0;left: 0;width: 100%;padding: 2px 0;line-height: 16px;color: #fff;background-color: rgba(0,0,0,.65);filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#a6000000', endColorstr='#a6000000', GradientType=0);}
.recom-list .tab-pannel .look-price p {margin: 0 10px;height: 16px;overflow: hidden;}
</style>

<div style="background-color:#f3f3f3;">
<div class="box">
<div class="fl_210">
<div class="widget-box">
    <div class="tit">客服中心</div>
    <div class="con">
        <b>工作时间</b><br>&nbsp;&nbsp;周一至周五：9:00-21:00<br>&nbsp;&nbsp;周六至周日：0:00-24:00
    </div>
</div>

<div class="widget-box">
    <div class="tit none">
        你可能还喜欢
    </div>
</div>

<div class="recom-list"><ul><?php if($tj_list){foreach($tj_list as $k=>$v){ ?>
<li class="tab-pannel" style="float: none; overflow: hidden; height: 222px; display: block;"><a href="<?php echo route('home_goods',array('id'=>$v->id)); ?>"><img src="<?php echo $v->litpic; ?>" alt="<?php echo $v->title; ?>"><div class="look-price"><div>¥<?php echo $v->price; ?></div><p><?php echo $v->title; ?></p></div></a></li>
<?php }} ?></ul></div>
</div>

<div class="fr_740">
<div class="detail-detail">
<div class="dd-header">
<span>宝贝详情</span>
</div>
<div class="detail-con">
<?php echo $post->body; ?>
</div>
</div></div>
<div class="cl"></div>
</div></div>

@include('home.common.footer')</body></html>