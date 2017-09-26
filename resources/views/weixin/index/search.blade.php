<!DOCTYPE html><html><head><meta http-equiv="content-type" content="text/html;charset=utf-8"/>
<title>商城</title><meta content="width=device-width,initial-scale=1.0,minimum-scale=1.0,maximum-scale=1.0,user-scalable=0" name="viewport">
<link href="<?php echo env('APP_URL'); ?>/css/weixin/style.css" type="text/css" rel="stylesheet">
<script type="text/javascript" src="<?php echo env('APP_URL'); ?>/js/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo env('APP_URL'); ?>/js/weixin/mobile.js"></script><script type="text/javascript" src="<?php echo env('APP_URL'); ?>/js/layer-mobile.js"></script>
<meta name="keywords" content="关键词"><meta name="description" content="描述"></head><body>
<div class="classreturn loginsignup">
    <div class="ds-in-bl return"><a href="javascript:history.back(-1);"><img src="<?php echo env('APP_URL'); ?>/images/weixin/return.png" alt="返回"></a></div>
    <div class="ds-in-bl tit center"><span>搜索</span></div>
    <div class="ds-in-bl nav_menu"><a href="javascript:void(0);"><img src="<?php echo env('APP_URL'); ?>/images/weixin/class1.png" alt="菜单"></a></div>
</div>
<div class="flool tpnavf cl">
    <div class="nav_list">
        <ul>
        <a href="index.html"><li><img src="images/weixin/home_icon.png"><p>首页</p></li></a>
        <a href="/Weixin/index.php?m=Store&amp;a=index"><li><img src="images/weixin/brand_icon.png"><p>分类</p></li></a>	
        <a href="/Weixin/index.php?m=Cart&amp;a=index"><li><img src="images/weixin/car_icon.png"><p>购物车</p></li></a>	
        <a href="/Weixin/index.php?m=User&amp;a=index"><li><img src="images/weixin/center_icon.png"><p>个人中心</p></li></a></ul>
        <div class="cl"></div>
    </div>
</div>

<div class="cl search_pl">
    <form method="get" action="<?php echo route('weixin_goods_list'); ?>" id="sourch_form">
        <input type="text" name="keyword" id="keyword" value="" placeholder="搜索商品">
        <a href="javascript:;" onclick="ajaxsecrch()"><img src="<?php echo env('APP_URL'); ?>/images/weixin/sea.png"></a>
    </form>
    <div class="cl"></div>
</div>
<script>
    function ajaxsecrch(){
        if($.trim($('#keyword').val()) != ''){
            $("#sourch_form").submit();
        }else{
            layer.open({content:'请输入搜索关键字',time:2});
        }
    }
</script>

<div class="hot_keyword_box">
    <div class="tit_18 mt10 mb10">
        <span>热门搜索</span>
    </div>
    <div class="hot_keyword">
        <a href="/index.php/mobile/Goods/search/q/%E6%89%8B%E6%9C%BA.html" class="ht">手机</a>
        <a href="/index.php/mobile/Goods/search/q/%E5%B0%8F%E7%B1%B3.html">小米</a>
        <a href="/index.php/mobile/Goods/search/q/iphone.html">iphone</a>
        <a href="/index.php/mobile/Goods/search/q/%E4%B8%89%E6%98%9F.html">三星</a>
        <a href="/index.php/mobile/Goods/search/q/%E5%8D%8E%E4%B8%BA.html">华为</a>
        <a href="/index.php/mobile/Goods/search/q/%E5%86%B0%E7%AE%B1.html">冰箱</a>
    </div>
</div>

@include('weixin.common.footer')
</body></html>