<!DOCTYPE html><html><head><meta http-equiv="content-type" content="text/html;charset=utf-8"/>
<title>我的订单</title><meta content="width=device-width,initial-scale=1.0,minimum-scale=1.0,maximum-scale=1.0,user-scalable=0" name="viewport">
<link href="<?php echo env('APP_URL'); ?>/css/weixin/style.css" type="text/css" rel="stylesheet">
<script type="text/javascript" src="<?php echo env('APP_URL'); ?>/js/jquery.min.js"></script><script type="text/javascript" src="<?php echo env('APP_URL'); ?>/js/weixin/mobile.js"></script>
<meta name="keywords" content="关键词"><meta name="description" content="描述"></head><body style="background-color:#f1f1f1;">
<div class="classreturn loginsignup">
    <div class="ds-in-bl return"><a href="javascript:history.back(-1);"><img src="<?php echo env('APP_URL'); ?>/images/weixin/return.png" alt="返回"></a></div>
    <div class="ds-in-bl tit center"><span>我的订单</span></div>
    <div class="ds-in-bl nav_menu"><a href="javascript:void(0);"><img src="<?php echo env('APP_URL'); ?>/images/weixin/class1.png" alt="菜单"></a></div>
</div>

@include('weixin.common.headerNav')

<!--导航左右滑动-start-->
<script type="text/javascript" src="<?php echo env('APP_URL'); ?>/js/swiper.min.js"></script>
<link rel="stylesheet" href="<?php echo env('APP_URL'); ?>/css/swiper.min.css">
<div class="swiper-nav">
    <div class="swiper-wrapper">
        <div class="swiper-slide<?php $order_status=0;if(isset($_REQUEST['status']) && !empty($_REQUEST['status'])){$order_status=$_REQUEST['status'];}if($order_status==0){echo ' swiper-slide-activate';} ?>"><a href="<?php echo route('weixin_order_list'); ?>">全部</a></div>
        <div class="swiper-slide<?php if($order_status==1){echo ' swiper-slide-activate';} ?>"><a href="<?php echo route('weixin_order_list',array('status'=>1)); ?>">待付款</a></div>
        <div class="swiper-slide<?php if($order_status==2){echo ' swiper-slide-activate';} ?>"><a href="<?php echo route('weixin_order_list',array('status'=>2)); ?>">待发货</a></div>
        <div class="swiper-slide<?php if($order_status==3){echo ' swiper-slide-activate';} ?>"><a href="<?php echo route('weixin_order_list',array('status'=>3)); ?>">待收货</a></div>
        <div class="swiper-slide<?php if($order_status==4){echo ' swiper-slide-activate';} ?>"><a href="<?php echo route('weixin_order_list',array('status'=>4)); ?>">待评价</a></div>
        <!--<div class="swiper-slide<?php if($order_status==5){echo ' swiper-slide-activate';} ?>"><a href="<?php echo route('weixin_order_list',array('status'=>5)); ?>">退款/售后</a></div>-->
    </div>
</div>
<style>
.swiper-nav{width:100%;height:46px;line-height:46px;border-bottom:1px solid #efefef;background:#fff;}
.swiper-slide{text-align:center;font-size:18px;background:#fff;}.swiper-slide a{color:#666;}
.swiper-slide-activate{color:#f23030;border-bottom:1px solid #f23030;}.swiper-slide-activate a{color:#f23030;}
</style>
<script>
var swiper = new Swiper('.swiper-nav', {
    slidesPerView: 4 //一行4列显示
});
</script>
<!--导航左右滑动-end-->

<?php if($list){foreach($list as $key=>$value){ ?>
<div class="floor mt10">
<a href="<?php echo route('weixin_order_detail',array('id'=>$value['id'])); ?>">
<div class="tit_h">单号:<?php echo $value['id']; ?><span class="fr"><?php echo $value['order_status_text']; ?></span></div>
<ul class="goodslist">
<?php if($value['goods_list']){foreach($value['goods_list'] as $k=>$v){ ?>
<li>
	<img src="<?php echo $v['goods_img']; ?>">
	<p><b><?php echo $v['goods_name']; ?></b><span>￥<?php echo $v['goods_price']; ?><i>x<?php echo $v['goods_number']; ?></i></span></p>
</li>
<?php }} ?>
</ul>
</a>

<p class="des">合计: ￥<?php echo $value['order_amount']; ?> <small>(含运费:￥<?php echo $value['shipping_fee']; ?>)</small></p>
<div class="tag"><!--<?php if($value['order_status_num']==4 && $value['refund_status']==0){ ?><a href="javascript:refund_order(<?php echo $value['id']; ?>);">申请退款</a><?php } ?><?php if($value['order_status_num']==4 || $value['order_status_num']==6 || $value['order_status_num']==7){ ?><a href="javascript:del_order(<?php echo $value['id']; ?>);">删除</a><?php } ?>--><?php if($value['order_status_num']==1){ ?><a href="javascript:cancel_order(<?php echo $value['id']; ?>);">取消订单</a><?php } ?><?php if($value['order_status_num']==1){ ?><a href="<?php echo route('weixin_order_pay',array('id'=>$value['id'])); ?>">付款</a><?php } ?><?php if($value['order_status_num']==3){ ?><a href="http://m.kuaidi100.com/index_all.html?type=<?php echo $value['shipping_name']; ?>&postid=<?php echo $value['shipping_sn']; ?>#result">查看物流</a><?php } ?><?php if($value['order_status_num']==2 || $value['order_status_num']==3){ ?><a href="javascript:done_order(<?php echo $value['id']; ?>);">确认收货</a><?php } ?><?php if($value['order_status_num']==4 && $value['is_comment']==0){ ?><a class="activate" href="<?php echo route('weixin_order_comment',array('id'=>$value['id'])); ?>">评价</a><?php } ?></div>
</div>
<?php }}else{ ?>
    <div style="text-align:center;line-height:40px;color:#999;">暂无记录</div>
<?php } ?>
<style>
.goodslist{background-color:#fbfbfb;}
.goodslist li{display:-webkit-box;margin:0 10px;padding:10px 0;border-bottom:1px solid #f1f1f1;}.goodslist li:last-child{border-bottom:none;}
.goodslist li img{margin-right:10px;display:block;width:60px;height:60px;border:1px solid #e1e1e1;}
.goodslist li p{display: block;-webkit-box-flex:1;width:100%;}
.goodslist li p b{display:block;font-size:16px;font-weight:400;line-height:28px;color:#333;}
.goodslist li p span{color:#f23030;font-size:16px;display:block;padding-top:5px;}
.goodslist li p i{color:#666;float:right;font-size:14px;}
.bottoma{display:block;font-size:18px;padding:10px;color:white;background-color:#f23030;text-align:center;}
.tit_h{font-size:16px;font-weight:400;background-color:#fff;color:#383838;height:42px;line-height:41px;padding-left:10px;padding-right:10px;border-bottom:1px solid #eee;}
.tit_h span{color:#e94e45;}
.des{text-align:right;background-color:#fff;font-size:14px;padding:6px 10px;}
.tag{background-color:#fff;padding-bottom:10px;text-align:right;}
.tag a{color:#666;background-color:#fff;border:1px solid #ddd;border-radius:5px;font-size:14px;padding:2px 6px;display:inline-block;margin-right:10px;}
.tag a.activate{color:#ea6f5a;border:1px solid #ea6f5a;}
</style>

<script type="text/javascript" src="<?php echo env('APP_URL'); ?>/js/layer/mobile/layer.js"></script>
<script>
var access_token = '<?php echo $_SESSION['weixin_user_info']['access_token']; ?>';

//取消订单
function cancel_order(order_id)
{
    //询问框
    layer.open({
        content: '确定要取消该订单吗？'
        ,btn: ['确定', '取消']
        ,yes: function(){
            var url = '<?php echo env('APP_API_URL')."/order_user_cancel"; ?>';
            $.post(url,{access_token:access_token,id:order_id},function(res)
            {
                //提示
                layer.open({
                    content: res.msg
                    ,skin: 'msg'
                    ,time: 2 //2秒后自动关闭
                });
                
                if(res.code==0)
                {
                    location.reload();
                }
                else
                {
                    
                }
            },'json');
        }
    });
}

//确认收货
function done_order(order_id)
{
    //询问框
    layer.open({
        content: '确定要这样操作吗？'
        ,btn: ['确定', '取消']
        ,yes: function(){
            var url = '<?php echo env('APP_API_URL')."/order_user_receipt_confirm"; ?>';
            $.post(url,{access_token:access_token,id:order_id},function(res)
            {
                //提示
                layer.open({
                    content: res.msg
                    ,skin: 'msg'
                    ,time: 2 //2秒后自动关闭
                });
                
                if(res.code==0)
                {
                    location.reload();
                }
                else
                {
                    
                }
            },'json');
        }
    });
}

//删除订单
function del_order(order_id)
{
    //询问框
    layer.open({
        content: '确定要删除该订单吗？'
        ,btn: ['确定', '取消']
        ,yes: function(){
            var url = '<?php echo env('APP_API_URL')."/order_user_delete"; ?>';
            $.post(url,{access_token:access_token,id:order_id},function(res)
            {
                //提示
                layer.open({
                    content: res.msg
                    ,skin: 'msg'
                    ,time: 2 //2秒后自动关闭
                });
                
                if(res.code==0)
                {
                    location.reload();
                }
                else
                {
                    
                }
            },'json');
        }
    });
}

//申请退款
function refund_order(order_id)
{
    //询问框
    layer.open({
        content: '确定要申请退款吗？'
        ,btn: ['确定', '取消']
        ,yes: function(){
            var url = '<?php echo env('APP_API_URL')."/order_user_refund"; ?>';
            $.post(url,{access_token:access_token,id:order_id},function(res)
            {
                //提示
                layer.open({
                    content: res.msg
                    ,skin: 'msg'
                    ,time: 2 //2秒后自动关闭
                });
                
                if(res.code==0)
                {
                    location.reload();
                }
                else
                {
                    
                }
            },'json');
        }
    });
}
</script>
</body></html>