<!DOCTYPE html><html><head><meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
<title><?php echo $post["title"]; ?>_<?php echo sysconfig('CMS_WEBNAME'); ?></title><meta name="keywords" content="{dede:field.keywords/}" /><meta name="description" content="{dede:field.description function='html2text(@me)'/}" /><link rel="stylesheet" href="<?php echo sysconfig('CMS_BASEHOST'); ?>/css/style.css"><script type="text/javascript" src="<?php echo sysconfig('CMS_BASEHOST'); ?>/js/ad.js"></script></head><body>
@include('home.common.header')

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
.detail-main .main-box .title {margin:8px 0;color: #3C3C3C;font-size: 18px;line-height: 28px;overflow: hidden;text-align: justify;}
.detail-main .main-box .description {color: #aaa;font-size: 14px;line-height: 20px;word-break: break-all;margin-bottom:10px;}
.price_bg {color: #6c6c6c;padding:15px;background-color:#FFF2E8;}
.details_join a {text-align: center;padding:10px 40px;font-size: 16px;color: #fff;border-radius: 2px;background: #e61414;float:left;}
</style>
<div style="background-color:#f3f3f3;padding-bottom:10px;">
<div class="box">
<div class="detail-main  clearfix">
<div class="header clearfix">
    <ul class="crumbs">
        <li><a href="https://ju.taobao.com/tg/today_items.htm">今日团购</a></li>
        <span class="arrow"><small></small></span>
        <li><a href="https://ju.taobao.com/tg/today_items.htm?stype=default&amp;page=1&amp;type=0">商品团</a></li>
        <span class="arrow"><small></small></span>
        <li><a href="<?php echo route('home_goodslist',array('id'=>$post['id'])); ?>"><?php echo $post['type_name']; ?></a></li>
    </ul>
    <a class="bookMark" href="">查看更多同类商品<span></span></a>
</div>
    
<div class="clearfix">
<div class="main-pic">
    <div class="normal-pic-wrapper clearfix" data-spm="ne">
        <div class="normal-pic ">
            <a href="https://detail.tmall.com/item.htm?id=523987525652&amp;tracelog=jubuybigpic" target="_blank" class="piclink">
                <div class="item-pic-wrap">
                <div class="J_zoom pic " style="background-image: url(<?php echo $post['litpic']; ?>);"></div>
                </div>
            </a>
        </div>
    </div>
</div>

<div class="main-box J_mainBox avil">
<h2 class="title"><?php echo $post['title']; ?></h2>
<div class="description"><?php echo $post['description']; ?></div>
<div class="price_bg">
价格: <b class="price" style="margin-left:10px;margin-right:10px;font-size:28px;font-style:normal;color:#f40;"><?php echo $post["price"]; ?></b> 邮费：0.00
</div>
<div class="stock_bg" style="margin-top:10px;margin-bottom:30px;">
&nbsp;&nbsp;库存: <?php echo $post['goods_number']; ?>
</div>
<div class="details_join"><a href="javascript:asas();">立即抢购</a></div>
</div>
<div class="cl"></div></div>
</div>
</div>
</div>
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
<li class="tab-pannel" style="float: none; overflow: hidden; height: 222px; display: block;"><a target="_blank" href="<?php echo route('home_goods',array('id'=>$v['id'])); ?>"><img src="<?php echo $v['litpic']; ?>" alt="<?php echo $v["title"]; ?>"><div class="look-price"><div>¥<?php echo $v["price"]; ?></div><p><?php echo $v["title"]; ?></p></div></a></li>
<?php }} ?></ul></div>
</div>

<div class="fr_740">
<div class="detail-detail">
<div class="dd-header">
<span>宝贝详情</span>
</div>
<div class="detail-con">
<?php echo $post['body']; ?>
</div>
</div></div>
<div class="cl"></div>
</div></div>

@include('home.common.footer')</body></html>