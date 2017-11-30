<!--底部导航-start-->
<div class="foohi">
<div class="footer">
	<ul>
    <?php $current_url = url()->current(); ?>
	<a href="<?php echo route('weixin'); ?>"><li<?php if(route('weixin') == $current_url){echo ' class="on"';} ?>><img src="<?php echo env('APP_URL'); ?>/images/weixin/home_icon<?php if(route('weixin') == $current_url){echo '2';} ?>.png"><p>首页</p></li></a>
    <a href="<?php echo route('weixin_category_goods_list'); ?>"><li<?php if(route('weixin_category_goods_list') == $current_url){echo ' class="on"';} ?>><img src="<?php echo env('APP_URL'); ?>/images/weixin/brand_icon<?php if(route('weixin_category_goods_list') == $current_url){echo '2';} ?>.png"><p>分类</p></li></a>	
    <a href="<?php echo route('weixin_cart'); ?>"><li<?php if(route('weixin_cart') == $current_url){echo ' class="on"';} ?>><img src="<?php echo env('APP_URL'); ?>/images/weixin/car_icon<?php if(route('weixin_cart') == $current_url){echo '2';} ?>.png"><p>购物车</p></li></a>	
    <a href="<?php echo route('weixin_user'); ?>"><li<?php if(route('weixin_user') == $current_url){echo ' class="on"';} ?>><img src="<?php echo env('APP_URL'); ?>/images/weixin/center_icon<?php if(route('weixin_user') == $current_url){echo '2';} ?>.png"><p>个人中心</p></li></a></ul>
</div>
</div>
<!--底部导航-end-->

<?php if($isWechatBrowser){ ?>@include('weixin.common.wxshare')<?php } ?>