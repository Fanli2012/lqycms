<!DOCTYPE html><html><head><meta http-equiv="content-type" content="text/html;charset=utf-8"/>
<title><?php echo $post['name']; ?> - 微商城</title><meta content="width=device-width,initial-scale=1.0,minimum-scale=1.0,maximum-scale=1.0,user-scalable=0" name="viewport">
<link href="<?php echo env('APP_URL'); ?>/css/weixin/style.css" type="text/css" rel="stylesheet">
<script type="text/javascript" src="<?php echo env('APP_URL'); ?>/js/jquery.min.js"></script><script type="text/javascript" src="<?php echo env('APP_URL'); ?>/js/weixin/mobile.js"></script>
<meta name="keywords" content="<?php echo $post['keywords']; ?>"><meta name="description" content="<?php echo $post['description']; ?>"></head><body>
<div class="classreturn loginsignup">
    <div class="ds-in-bl return"><a href="javascript:history.back(-1);"><img src="<?php echo env('APP_URL'); ?>/images/weixin/return.png" alt="返回"></a></div>
    <div class="ds-in-bl tit center"><span><?php echo $post['name']; ?></span></div>
    <div class="ds-in-bl nav_menu"><a href="javascript:void(0);"><img src="<?php echo env('APP_URL'); ?>/images/weixin/class1.png" alt="菜单"></a></div>
</div>
<div class="flool tpnavf cl">
    <div class="nav_list">
        <ul>
        <a href="<?php echo route('weixin'); ?>"><li><img src="<?php echo env('APP_URL'); ?>/images/weixin/home_icon.png"><p>首页</p></li></a>
        <a href="/Weixin/index.php?m=Store&amp;a=index"><li><img src="<?php echo env('APP_URL'); ?>/images/weixin/brand_icon.png"><p>分类</p></li></a>	
        <a href="/Weixin/index.php?m=Cart&amp;a=index"><li><img src="<?php echo env('APP_URL'); ?>/images/weixin/car_icon.png"><p>购物车</p></li></a>	
        <a href="/Weixin/index.php?m=User&amp;a=index"><li><img src="<?php echo env('APP_URL'); ?>/images/weixin/center_icon.png"><p>个人中心</p></li></a></ul>
        <div class="cl"></div>
    </div>
</div>

<div class="arc_list">
<ul class="arclist cl">
<?php if($article_list){foreach($article_list as $k=>$v){ ?>
<li><a href="<?php echo $v['article_detail_url']; ?>"><?php echo $v['title']; ?></a><p><?php echo $v['pubdate']; ?></p></li>
<?php }} ?>
</ul>
</div>

@include('weixin.common.footer')
</body></html>