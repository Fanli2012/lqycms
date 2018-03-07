<!DOCTYPE html><html><head><meta http-equiv="content-type" content="text/html;charset=utf-8"/>
<title>品牌大全</title><meta content="width=device-width,initial-scale=1.0,minimum-scale=1.0,maximum-scale=1.0,user-scalable=0" name="viewport">
<link href="<?php echo env('APP_URL'); ?>/css/weixin/style.css" type="text/css" rel="stylesheet">
<script type="text/javascript" src="<?php echo env('APP_URL'); ?>/js/jquery.min.js"></script><script type="text/javascript" src="<?php echo env('APP_URL'); ?>/js/weixin/mobile.js"></script>
<meta name="keywords" content="关键词"><meta name="description" content="描述"></head><body style="background-color:#f1f1f1;">
<div class="classreturn loginsignup">
    <div class="ds-in-bl return"><a href="javascript:history.back(-1);"><img src="<?php echo env('APP_URL'); ?>/images/weixin/return.png" alt="返回"></a></div>
    <div class="ds-in-bl tit center"><span>品牌列表</span></div>
</div>

<div class="floor">
    <div class="brand-list">
<?php if($list){ ?>
        <ul><?php foreach($list as $k=>$v){ ?>
        <li><a href="<?php echo route('weixin_goods_list',['brand_id'=>$v['id']]); ?>"><img src="<?php echo $v['litpic']; ?>" alt="<?php echo $v['title']; ?>"></a></li>
        <?php } ?>
        <div class="cl"></div></ul><?php }else{ ?>
    <div style="text-align:center;line-height:40px;color:#999;">暂无记录</div><?php } ?>
    </div>
</div>

<style>
.brand-list{box-sizing:border-box;overflow:hidden;}
.brand-list ul li{float:left;width: 25%;background-color: #FFF;}
.brand-list ul a{display:block;border-right: 1px solid #f6f6f9;border-bottom: 1px solid #f6f6f9;}
.brand-list ul li img{display: block;width: 100%;transition: all 0.5s;}
</style>
@include('weixin.common.footer')
</body></html>