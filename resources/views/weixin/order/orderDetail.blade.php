<!DOCTYPE html><html><head><meta http-equiv="content-type" content="text/html;charset=utf-8"/>
<title>订单详情</title><meta content="width=device-width,initial-scale=1.0,minimum-scale=1.0,maximum-scale=1.0,user-scalable=0" name="viewport">
<link href="<?php echo env('APP_URL'); ?>/css/weixin/style.css" type="text/css" rel="stylesheet">
<script type="text/javascript" src="<?php echo env('APP_URL'); ?>/js/jquery.min.js"></script><script type="text/javascript" src="<?php echo env('APP_URL'); ?>/js/weixin/mobile.js"></script>
<meta name="keywords" content="关键词"><meta name="description" content="描述">
<link href="<?php echo env('APP_URL'); ?>/css/font-awesome.min.css" type="text/css" rel="stylesheet"></head><body style="background-color:#f1f1f1;">
<div class="classreturn loginsignup">
    <div class="ds-in-bl return"><a href="javascript:history.back(-1);"><img src="<?php echo env('APP_URL'); ?>/images/weixin/return.png" alt="返回"></a></div>
    <div class="ds-in-bl tit center"><span>订单详情</span></div>
    <div class="ds-in-bl nav_menu"><a href="javascript:void(0);"><img src="<?php echo env('APP_URL'); ?>/images/weixin/class1.png" alt="菜单"></a></div>
</div>

@include('weixin.common.headerNav')

<div class="orderdetail-des">
    <p>订单状态：<?php echo $post['order_status_text']; ?></p>
</div>
<style>
.orderdetail-des{background:#ea5a3d;padding:20px 10px;color:#fff;font-size:18px;}
</style>

<!-- 选择收货地址-start -->
<div class="checkout-addr">
    <p class="title"><span class="name" id="default_consignee"><?php echo $post['name']; ?></span> <span class="tel" id="default_phone"><?php echo $post['mobile']; ?></span></p>
    <p class="des" id="default_address"><?php echo $post['province_name'].$post['city_name'].$post['district_name']; ?> <?php echo $post['address']; ?></p>
    <i class="fa fa-street-view"></i>
</div>
<style>
.checkout-addr{position: relative;background:#fff;margin-top:10px;padding:10px;}
.checkout-addr p{margin-right:20px;}.checkout-addr .title{font-size:18px;color:#353535;}.checkout-addr .des{color:#9b9b9b;}
.checkout-addr i{position:absolute;top:50%;right:12px;margin-top:-6px;color:#bbb;display:inline-block;}
</style>
<!-- 选择收货地址-end -->
<!-- 订单商品-start -->
<div class="floor mt10">
<div class="tit_h">订单商品</div>
<ul class="goodslist">
<?php foreach($post['goods_list'] as $key=>$value){ ?>
<li>
	<img src="<?php echo $value['goods_img']; ?>">
	<p><b><?php echo $value['goods_name']; ?></b><span>￥<?php echo $value['goods_price']; ?><i>x<?php echo $value['goods_number']; ?></i></span></p>
</li>
<?php } ?>
</ul>

<p class="des">合计: ￥<?php echo $post['order_amount']; ?> <small>(含运费:￥<?php echo $post['shipping_fee']; ?>)</small></p>
<div class="tag"><?php if($post['order_status_num']==4 || $post['order_status_num']==6 || $post['order_status_num']==7){ ?><a href="javascript:del_order(<?php echo $post['id']; ?>);">删除</a><?php } ?><?php if($post['order_status_num']==1){ ?><a href="javascript:cancel_order(<?php echo $post['id']; ?>);">取消订单</a><?php } ?><?php if($post['order_status_num']==1){ ?><a href="<?php echo route('weixin_order_pay',array('id'=>$post['id'])); ?>">付款</a><?php } ?><?php if($post['order_status_num']==3){ ?><a href="http://m.kuaidi100.com/index_all.html?type=<?php echo $post['shipping_name']; ?>&postid=<?php echo $post['shipping_sn']; ?>#result">查看物流</a><?php } ?><?php if($post['order_status_num']==3){ ?><a href="javascript:done_order(<?php echo $post['id']; ?>);">确认收货</a><?php } ?><?php if($post['order_status_num']==4){ ?><a class="activate" href="<?php echo route('weixin_order_comment',array('id'=>$post['id'])); ?>">评价</a><?php } ?></div>
</div>
<style>
.goodslist{background-color:#fbfbfb;}
.goodslist li{display:-webkit-box;margin:0 10px;padding:10px 0;border-bottom:1px solid #f1f1f1;}.goodslist li:last-child{border-bottom:none;}
.goodslist li img{margin-right:10px;display:block;width:60px;height:60px;border:1px solid #e1e1e1;}
.goodslist li p {display: block;-webkit-box-flex:1;width:100%;}
.goodslist li p b {display:block;font-size:16px;font-weight:400;line-height:28px;color:#333;}
.goodslist li p span {color:#f23030;font-size:18px;display: block;padding-top:5px;}
.goodslist li p i{color:#666;float:right;font-size:14px;}
.tit_h{font-size:16px;font-weight:400;background-color:#fff;color:#383838;height:42px;line-height:41px;padding-left:10px;padding-right:10px;border-bottom:1px solid #eee;}
.tit_h span{color:#e94e45;}
.floor .des{text-align:right;background-color:#fff;font-size:14px;padding:6px 10px;}
.tag{background-color:#fff;padding-bottom:10px;text-align:right;}
.tag a{color:#666;background-color:#fff;border:1px solid #ddd;border-radius:5px;font-size:14px;padding:2px 6px;display:inline-block;margin-right:10px;}
.tag a.activate{color:#ea6f5a;border:1px solid #ea6f5a;}
</style>
<!-- 订单商品-end -->

<div class="order_expand mt10">
    <p>创建时间：<?php echo date('Y-m-d H:i:s',$post['add_time']); ?></p>
    <p>订单编号：<?php echo $post['order_sn']; ?></p>
</div>
<style>
.order_expand{background-color:#fff;padding:10px;font-size:14px;color:#666;}
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
</script>
@include('weixin.common.footer')
</body></html>