<!DOCTYPE html><html><head><meta http-equiv="content-type" content="text/html;charset=utf-8"/>
<title><?php echo $post['title']; ?> - 微商城</title><meta content="width=device-width,initial-scale=1.0,minimum-scale=1.0,maximum-scale=1.0,user-scalable=0" name="viewport">
<link href="<?php echo env('APP_URL'); ?>/css/weixin/style.css" type="text/css" rel="stylesheet">
<script type="text/javascript" src="<?php echo env('APP_URL'); ?>/js/jquery.min.js"></script><script type="text/javascript" src="<?php echo env('APP_URL'); ?>/js/weixin/mobile.js"></script>
<meta name="keywords" content="<?php echo $post['keywords']; ?>"><meta name="description" content="<?php echo $post['description']; ?>"></head><body>
<div class="classreturn loginsignup">
    <div class="ds-in-bl return"><a href="javascript:history.back(-1);"><img src="<?php echo env('APP_URL'); ?>/images/weixin/return.png" alt="返回"></a></div>
    <div class="ds-in-bl tit center"><span>文章详情</span></div>
    <div class="ds-in-bl nav_menu"><a href="javascript:void(0);"><img src="<?php echo env('APP_URL'); ?>/images/weixin/class1.png" alt="菜单"></a></div>
</div>

@include('weixin.common.headerNav')

<h1 class="arc_tit"><?php echo $post['title']; ?></h1>

<div class="arc_content box">
<div class="ainfo"><?php echo $post['pubdate']; ?></div>
<div>
	查询新股配号主要有以下三点：</div>
<div>
	&nbsp;</div>
<div>
	1.到证券营业部进行查询。</div>
<div>
	&nbsp;</div>
<div>
	2.在申购日后的第三天投资者可通过网上进行新股配号的查询。</div>
<div>
	&nbsp;</div>
<div>
	3.客户还可以通过交易所的咨询电话进行查询：0755-2288800（深市），021-16893006（沪市）投资者所查到的配号是投资者在一个帐户上申购新股所得配号的起始号，其余配号依次顺延.</div>
<!-- <div class="arcnext cl">下: <a class="red" href="" rel="prev"></a></div> --></div>

@include('weixin.common.footer')
</body></html>