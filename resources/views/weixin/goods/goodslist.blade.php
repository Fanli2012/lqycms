<!DOCTYPE html><html><head><meta http-equiv="content-type" content="text/html;charset=utf-8"/>
<title>LQYCMS微商城</title><meta content="width=device-width,initial-scale=1.0,minimum-scale=1.0,maximum-scale=1.0,user-scalable=0" name="viewport">
<link href="<?php echo env('APP_URL'); ?>/css/weixin/style.css" type="text/css" rel="stylesheet">
<script type="text/javascript" src="<?php echo env('APP_URL'); ?>/js/jquery.min.js"></script><script type="text/javascript" src="<?php echo env('APP_URL'); ?>/js/weixin/mobile.js"></script>
<meta name="keywords" content="关键词"><meta name="description" content="描述"></head><body>
<div class="classreturn loginsignup">
    <div class="ds-in-bl return"><a href="javascript:history.back(-1);"><img src="<?php echo env('APP_URL'); ?>/images/weixin/return.png" alt="返回"></a></div>
    <div class="ds-in-bl tit center"><span>商品列表</span></div>
</div>

<nav class="storenav">
    <ul class="table-cell">
        <li>
            <span class="lb">综合</span>
        </li>
        <li class="red">
            <a href="/index.php/Mobile/Goods/search/id/0/q/冰箱/sort/sales_sum">
                <span class="dq">销量</span>
            </a>
        </li>
        <li>
            <a href="/index.php/Mobile/Goods/search/id/0/q/冰箱/sort/shop_price/sort_asc/desc">
                <span class="jg">价格 </span>
                <i class="pr bpr1"></i>
            </a>
        </li>
    </ul><div class="cl"></div>
</nav>

<div class="floor">
    <ul class="goods_list" id="goods_list">
    <?php foreach($goods_list as $k=>$v){ ?>
        <li><a href="<?php echo $v['goods_detail_url']; ?>"><img alt="<?php echo $v['title']; ?>" src="<?php echo $v['litpic']; ?>"><div class="goods_info"><p class="goods_tit"><?php echo $v['title']; ?></p><div class="goods_price">￥<b><?php echo $v['price']; ?></b></div></div></a></li>
    <?php } ?>
    </ul>
</div>

@include('weixin.common.footer')
</body></html>