<!DOCTYPE html><html><head><meta http-equiv="content-type" content="text/html;charset=utf-8"/>
<title>商城</title><meta content="width=device-width,initial-scale=1.0,minimum-scale=1.0,maximum-scale=1.0,user-scalable=0" name="viewport">
<link href="<?php echo env('APP_URL'); ?>/css/weixin/style.css" type="text/css" rel="stylesheet">
<script type="text/javascript" src="<?php echo env('APP_URL'); ?>/js/jquery.min.js"></script><script type="text/javascript" src="<?php echo env('APP_URL'); ?>/js/weixin/mobile.js"></script>
<meta name="keywords" content="关键词"><meta name="description" content="描述"></head><body style="background-color:#f1f1f1;">

<div class="classreturn loginsignup">
    <div class="ds-in-bl return"><a href="javascript:history.back(-1);"><img src="<?php echo env('APP_URL'); ?>/images/weixin/return.png" alt="返回"></a></div>
    <div class="ds-in-bl tit center"><span>所有分类</span></div>
    <div class="ds-in-bl nav_menu"><a href="javascript:void(0);"><img src="<?php echo env('APP_URL'); ?>/images/weixin/class1.png" alt="菜单"></a></div>
</div>

@include('weixin.common.headerNav')

<div class="flool classlist" style="margin-top:4px;">
    <div class="fl category1">
        <ul>
        <li<?php if(0==$typeid){echo ' class="on"';} ?>>
            <a href="<?php echo route('weixin_category_goods_list'); ?>" data-id="0">全部</a>
        </li>
        <?php if($goodstype_list){foreach($goodstype_list as $k=>$v){ ?>
            <li<?php if($v['id']==$typeid){echo ' class="on"';} ?>>
               <a href="<?php echo route('weixin_category_goods_list',array('typeid'=>$v['id'])); ?>" data-id="<?php echo $v['id']; ?>"><?php echo $v['name']; ?></a>
            </li>
        <?php }} ?>
        </ul>
    </div>
    <div class="fr category2">
        <?php if($goods_list){ ?>
        <ul class="goods_list_small">
        <?php foreach($goods_list as $k=>$v){ ?>
            <li><a href="<?php echo $v['goods_detail_url']; ?>"><img class="imgzsy" alt="<?php echo $v['title']; ?>" src="<?php echo $v['litpic']; ?>"><div class="goods_info"><p class="goods_tit"><?php echo $v['title']; ?></p><div class="goods_price">￥<b><?php echo $v['price']; ?></b></div></div></a></li>
        <?php } ?>
        </ul>
        <?php }else{ ?>
            <div style="text-align:center;line-height:40px;color:#999;">暂无记录</div>
        <?php } ?>
    </div>
</div>

@include('weixin.common.footer')
</body></html>