<!DOCTYPE html><html><head><meta http-equiv="content-type" content="text/html;charset=utf-8"/>
<title>确认订单</title><meta content="width=device-width,initial-scale=1.0,minimum-scale=1.0,maximum-scale=1.0,user-scalable=0" name="viewport">
<link href="<?php echo env('APP_URL'); ?>/css/weixin/style.css" type="text/css" rel="stylesheet">
<script type="text/javascript" src="<?php echo env('APP_URL'); ?>/js/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo env('APP_URL'); ?>/js/weixin/mobile.js"></script>
<link href="<?php echo env('APP_URL'); ?>/css/font-awesome.min.css" type="text/css" rel="stylesheet">
<meta name="keywords" content="关键词"><meta name="description" content="描述"></head><body style="background-color:#f1f1f1;">
<div class="classreturn loginsignup">
    <div class="ds-in-bl return"><a href="javascript:history.back(-1);"><img src="<?php echo env('APP_URL'); ?>/images/weixin/return.png" alt="返回"></a></div>
    <div class="ds-in-bl tit center"><span>确认订单</span></div>
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

<a href="/v2/index.php?m=default&amp;c=flow&amp;a=consignee_list&amp;u=53657">
<div class="checkout-addr">
  <p class="title">范例 <span>15280767654</span></p>
  <p class="des">福建厦门湖里区 软件园二期100号</p>
  <i></i>
</div>
</a>
<style>
.checkout-addr{position: relative;/* border-top: 1px solid #e3e3e3;border-bottom: 1px solid #e3e3e3; */background: #fff;margin-top:10px;padding:10px;}
.checkout-addr p{margin-right:20px;}.checkout-addr .title{font-size:18px;margin-bottom:5px;}.checkout-addr .des{color:#666;}
.checkout-addr i{position: absolute;top: 50%;right:12px;margin-top:-6px;color:#bbb;display:inline-block;border-right:2px solid;border-bottom:2px solid;width:12px;height:12px;transform:rotate(-45deg);}
</style>
<ul class="goodslist">
<?php if($list){foreach($list as $k=>$v){ ?>
<li>
	<img src="<?php echo $v['litpic']; ?>">
	<p><b><?php echo $v['title']; ?></b><span>￥<?php echo $v['final_price']; ?><i>x<?php echo $v['goods_number']; ?></i></span></p>
</li>
<?php }} ?>
</ul>
<style>
.goodslist{background-color:#fff;margin-top:10px;}
.goodslist li{display:-webkit-box;margin:0 10px;padding:10px;border-bottom: 1px solid #f1f1f1;}
.goodslist li img{margin-right:10px;display:block;width:78px;height:78px;border: 1px solid #e1e1e1;}
.goodslist li p {display: block;-webkit-box-flex: 1;width: 100%;}
.goodslist li p b {display:block;font-size:16px;font-weight:400;line-height: 28px;color:#333;}
.goodslist li p span {color:#f23030;font-size:18px;display: block;padding-top:8px;}
.goodslist li p i{color:#666;float:right;font-size:14px;}
</style>

<div class="floor">
<ul class="fui-list mt10">
    <a href="javascript:update_username();"><li>
        <div class="ui-list-info">
            <h4 class="ui-nowrap">支付方式</h4>
            <div class="ui-txt-info">支付宝 &nbsp;</div>
        </div>
        <i class="fa fa-angle-right" aria-hidden="true"></i>
    </li></a>
    <a href="javascript:update_username();"><li>
        <div class="ui-list-info">
            <h4 class="ui-nowrap">优惠券</h4>
            <div class="ui-txt-info">请选择优惠券 &nbsp;</div>
        </div>
        <i class="fa fa-angle-right" aria-hidden="true"></i>
    </li></a>
</ul></div>

<div class="floor" style="background-color:#fff;margin-top:10px;padding:10px;">
<div class="buy_note">
    <div class="buy_note_tit"><span>备注</span></div>
    <textarea name="message"></textarea>
</div>
<div class="order_check_info">
    <p>共1件商品</p>
    <p>运费：¥0</p>
    <p>满¥15.00减¥1.00</p>
    <p>商品总价：¥99</span></p>
    <p>应付款金额：<span class="red">¥<i id="totalamount">99</i></span></p>
</div>
</div>
<style>
.buy_note{margin:5px 0 15px 0;}
.buy_note_tit{font-size:16px;margin-bottom:15px;}
.buy_note textarea{display:block;font-size: 14px;min-height:100px;border:1px solid #e1e1e1;width: 100%;padding:10px;box-sizing: border-box;}
.order_check_info p{text-align:right;line-height:22px;color: #666;font-size:14px;}
.order_check_info p .red{color:#ff5500;font-size:18px;}
</style>

<div class="setting"><div class="close"><a href="<?php echo route('weixin_user_logout'); ?>" id="logout">提交</a></div></div>

<script type="text/javascript" src="<?php echo env('APP_URL'); ?>/js/layer/mobile/layer.js"></script>
<script>
function cart_submit()
{
    var cart_goods_ids = '';
    $('[name="checkItem"][checked]').each(function(){
        var goods_id = $(this).attr('data-cart-id');
        if(cart_goods_ids){cart_goods_ids = cart_goods_ids+'_'+goods_id;}else{cart_goods_ids = cart_goods_ids+goods_id;}
    });
    
    if(cart_goods_ids == '')
    {
        layer.open({
            content: '请选择商品'
            ,skin: 'msg'
            ,time: 2 //2秒后自动关闭
        });
        
        return false;
    }
    
    location.href = '<?php echo substr(route('weixin_cart_checkout',array('ids'=>1)), 0, -1); ?>' + cart_goods_ids;
}

function change_goods_number(type, id)
{
    var goods_number = document.getElementById('goods_number'+id).value;
    if(type != 2)
    {
        var goods_number = document.getElementById('goods_number'+id).value;
        document.getElementById('goods_number'+id).value = goods_number;
    }
    if(type == 1){goods_number--;}
    if(type == 3){goods_number++;}
    if(goods_number <= 0){goods_number=1;}
    if(!/^[0-9]*$/.test(goods_number)){goods_number = document.getElementById('goods_number'+id).value;}
    document.getElementById('goods_number'+id).value = goods_number;
    
    var access_token = '<?php echo $_SESSION['weixin_user_info']['access_token']; ?>';
	var url = '<?php echo env('APP_API_URL').'/cart_add'; ?>';
    
    $.post(url,{access_token:access_token,goods_id:id,goods_number:goods_number},function(res)
	{
        if (res.code == 0)
        {
            changeCartTotalPrice();
        }
        else if (res.msg != '')
        {
            //提示
            layer.open({
                content: '姓名不能为空'
                ,skin: 'msg'
                ,time: 2 //2秒后自动关闭
            });
            
            var goods_number = document.getElementById('goods_number'+id).value;
            document.getElementById('goods_number'+id).value = goods_number;
        }
    }, 'json');
}

//删除购物车商品
$(function () {
    //删除购物车商品事件
    $(document).on("click", '.deleteGoods', function (e) {
        var access_token = '<?php echo $_SESSION['weixin_user_info']['access_token']; ?>';
        var cart_ids = new Array();
        cart_ids.push($(this).attr('data-cart-id'));
        layer.open({
            content: '确定要删除此商品吗'
            ,btn: ['确定', '取消']
            ,yes: function(index){
                layer.close(index);
                $.ajax({
                    type : "POST",
                    url:"<?php echo env('APP_API_URL').'/cart_delete'; ?>",
                    dataType:'json',
                    data: {access_token:access_token,id:cart_ids},
                    success: function(res){
                        layer.open({
                            content: res.msg
                            ,skin: 'msg'
                            ,time: 2 //2秒后自动关闭
                        });
                        
                        window.location.reload();
                    }
                });
            }
        });
    })
});

//勾选商品
function checkGoods(obj)
{
    if($(obj).hasClass('check_t'))
    {
        //改变颜色
        $(obj).removeClass('check_t');
        //取消选中
        $(obj).find('input').attr('checked',false);
    }
    else
    {
        //改变颜色
        $(obj).addClass('check_t');
        //勾选选中
        $(obj).find('input').attr('checked',true);
    }

    //选中全选多选框
    if($(obj).hasClass('checkFull'))
    {
        if($(obj).hasClass('check_t'))
        {
            $(".che").each(function(i,o){
                $(this).addClass('check_t');
                $(this).find('input').attr('checked',true);
            });
        }
        else
        {
            $(".che").each(function(i,o){
                $(this).removeClass('check_t');
                $(this).find('input').attr('checked',false);
            });
        }
    }
    
    changeCartTotalPrice();
}

//修改选中商品总价
function changeCartTotalPrice()
{
    var total_price = 0;
    
    $('[name="checkItem"][checked]').each(function(){
        var goods_id = $(this).attr('data-goods-id');
        
        total_price = total_price + $('#goods_number'+goods_id).val() * $('#goods_price'+goods_id).text();
    });
    
    $('#total_fee').text(total_price);
}
</script>
</body></html>