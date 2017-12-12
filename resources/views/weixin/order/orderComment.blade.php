<!DOCTYPE html><html><head><meta http-equiv="content-type" content="text/html;charset=utf-8"/>
<title>发表评价</title><meta content="width=device-width,initial-scale=1.0,minimum-scale=1.0,maximum-scale=1.0,user-scalable=0" name="viewport">
<link href="<?php echo env('APP_URL'); ?>/css/weixin/style.css" type="text/css" rel="stylesheet">
<script type="text/javascript" src="<?php echo env('APP_URL'); ?>/js/jquery.min.js"></script><script type="text/javascript" src="<?php echo env('APP_URL'); ?>/js/weixin/mobile.js"></script>
<meta name="keywords" content="关键词"><meta name="description" content="描述"></head><body style="background-color:#f1f1f1;">
<div class="classreturn loginsignup">
    <div class="ds-in-bl return"><a href="javascript:history.back(-1);"><img src="<?php echo env('APP_URL'); ?>/images/weixin/return.png" alt="返回"></a></div>
    <div class="ds-in-bl tit center"><span>发表评价</span></div>
    <div class="ds-in-bl nav_menu"><a href="javascript:submit();" style="color:#e94e45;">发布</a></div>
</div>

<form action="<?php echo route('weixin_order_comment'); ?>" method="post" id="myform">
<?php if($post){ ?>
<input name="order_id" type="hidden" value="<?php echo $post['id']; ?>">
<div class="floor">
<?php if($post['goods_list']){foreach($post['goods_list'] as $k=>$v){ ?>
<div class="tit_h mt10"><img src="<?php echo $v['goods_img']; ?>"> <span class="fr"></span></div>

<div style="padding:10px 10px 8px 10px;background-color:#fff;"><textarea rows="4" name="comment[<?php echo $k; ?>][content]" onfocus="if(value=='宝贝满足你的期待吗？说说你的使用心得，分享给想买的TA们吧'){value=''}" onblur="if(value==''){value='宝贝满足你的期待吗？说说你的使用心得，分享给想买的TA们吧'}">宝贝满足你的期待吗？说说你的使用心得，分享给想买的TA们吧</textarea></div>
<div class="tit_h" style="border-top:1px solid #eee;"><input type="checkbox" name="comment[<?php echo $k; ?>][is_anonymous]" value="1" checked> 匿名 <span class="fr">你写的评价会以匿名的形式展现</span></div>
<input name="comment[<?php echo $k; ?>][id_value]" type="hidden" value="<?php echo $v['goods_id']; ?>">
<?php }} ?>
</div>
<?php }else{ ?>
    <div style="text-align:center;line-height:40px;color:#999;">暂无记录</div>
<?php } ?>
</form>
<style>
.tit_h{font-size:16px;font-weight:400;background-color:#fff;color:#383838;height:42px;line-height:41px;padding-left:10px;padding-right:10px;border-bottom:1px solid #eee;}
.tit_h span{color:#999;font-size:14px;}
.tit_h img{width:28px;height:28px;}
textarea{width:100%;border:none;color:#999;}
</style>

<script type="text/javascript" src="<?php echo env('APP_URL'); ?>/js/layer/mobile/layer.js"></script>
<script>
function submit()
{
    $("#myform").submit();
}
</script>
</body></html>