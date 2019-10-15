<!DOCTYPE html><html><head><meta http-equiv="content-type" content="text/html;charset=utf-8"/>
<title>商品列表</title><meta content="width=device-width,initial-scale=1.0,minimum-scale=1.0,maximum-scale=1.0,user-scalable=0" name="viewport">
<link href="<?php echo env('APP_URL'); ?>/css/weixin/style.css" type="text/css" rel="stylesheet">
<script type="text/javascript" src="<?php echo env('APP_URL'); ?>/js/jquery.min.js"></script><script type="text/javascript" src="<?php echo env('APP_URL'); ?>/js/weixin/mobile.js"></script>
<meta name="keywords" content="关键词"><meta name="description" content="描述"></head><body style="background-color:#f1f1f1;">
<div class="classreturn loginsignup">
    <div class="ds-in-bl return"><a href="javascript:history.back(-1);"><img src="<?php echo env('APP_URL'); ?>/images/weixin/return.png" alt="返回"></a></div>
    <div class="ds-in-bl tit center"><span>商品列表</span></div>
</div>

<nav class="storenav">
    <ul class="table-cell">
        <li<?php if(!isset($_REQUEST['orderby'])){echo ' class="red"';} ?>>
            <a href="<?php $complexorder = $request_param;if(isset($complexorder['orderby'])){unset($complexorder['orderby']);}echo route('weixin_goods_list',$complexorder); ?>">
                <span class="lb">综合</span>
            </a>
        </li>
        <li<?php if(isset($_REQUEST['orderby']) && $_REQUEST['orderby']==1){echo ' class="red"';} ?>>
            <a href="<?php $saleorder = $request_param;$saleorder['orderby']=1;echo route('weixin_goods_list',$saleorder); ?>">
                <span class="dq">销量</span>
            </a>
        </li>
        <li<?php if((isset($_REQUEST['orderby']) && ($_REQUEST['orderby']==3 || $_REQUEST['orderby']==4))){echo ' class="red"';} ?>>
            <a href="<?php $priceorder = $request_param;if(isset($_REQUEST['orderby']) && $_REQUEST['orderby']==3){$priceorder['orderby']=4;}else{$priceorder['orderby']=3;}echo route('weixin_goods_list',$priceorder); ?>">
                <span class="jg">价格 </span>
                <i class="pr<?php if(isset($_REQUEST['orderby']) && $_REQUEST['orderby']==3){echo ' bpr1';}elseif(isset($_REQUEST['orderby']) && $_REQUEST['orderby']==4){echo ' bpr2';} ?>"></i>
            </a>
        </li>
    </ul><div class="cl"></div>
</nav>

<div class="floor">
    <?php if($goods_list){ ?>
    <ul class="goods_list" id="goods_list">
    <?php foreach($goods_list as $k=>$v){ ?>
        <li><a href="<?php echo $v['goods_detail_url']; ?>"><img alt="<?php echo $v['title']; ?>" src="<?php echo $v['litpic']; ?>"><div class="goods_info"><p class="goods_tit"><?php if($v['is_promote_goods']>0){ ?><span class="badge_comm" style="background-color:#f23030;">Hot</span> <?php } ?><?php echo $v['title']; ?></p><div class="goods_price">￥<b><?php echo $v['price']; ?></b><span class="fr"><?php echo $v['sale']; ?>人付款</span></div></div></a></li>
    <?php } ?>
    </ul><?php }else{ ?>
    <div style="text-align:center;line-height:40px;color:#999;">暂无记录</div><?php } ?>
</div>

@include('weixin.common.footer')
</body></html>