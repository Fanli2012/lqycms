<!DOCTYPE html><html><head><meta http-equiv="content-type" content="text/html;charset=utf-8"/>
<title>我的足迹</title><meta name="keywords" content="关键词"><meta name="description" content="描述"><meta content="width=device-width,initial-scale=1.0,minimum-scale=1.0,maximum-scale=1.0,user-scalable=0" name="viewport">
<link href="<?php echo env('APP_URL'); ?>/css/weixin/style.css" type="text/css" rel="stylesheet">
<script type="text/javascript" src="<?php echo env('APP_URL'); ?>/js/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo env('APP_URL'); ?>/js/weixin/mobile.js"></script></head><body>
<div class="classreturn loginsignup">
    <div class="ds-in-bl return"><a href="javascript:history.back(-1);"><img src="<?php echo env('APP_URL'); ?>/images/weixin/return.png" alt="返回"></a></div>
    <div class="ds-in-bl tit center"><span>我的足迹</span></div>
    <div class="ds-in-bl nav_menu"><a href="javascript:void(0);" style="color:#999;" id="clear_history"  onclick="delconfirm('<?php echo route('weixin_user_goods_history_clear'); ?>','确定要清空吗？')">清空</a></div>
</div>

<script type="text/javascript" src="<?php echo env('APP_URL'); ?>/js/layer/mobile/layer.js"></script>
<div class="floor">
    <ul class="goods_list_s cl">
        <?php if($user_goods_history){foreach($user_goods_history as $k=>$v){ ?>
        <li><a href="<?php echo $v['goods']['goods_detail_url']; ?>"><span class="goods_thumb"><img alt="<?php echo $v['goods']['title']; ?>" src="<?php echo env('APP_URL'); ?><?php echo $v['goods']['litpic']; ?>"></span></a>
        <div class="goods_info"><p class="goods_tit"><?php echo $v['goods']['title']; ?></p>
        <p class="goods_price">￥<b><?php echo $v['goods']['price']; ?></b></p>
        <p class="goods_des fr"><span id="del_history" onclick="delconfirm('<?php echo route('weixin_user_goods_history_delete',array('id'=>$v['id'])); ?>')">删除</span></p>
        </div></li>
        <?php }} ?>
    </ul>
</div>

@include('weixin.common.footer')
</body></html>