<!DOCTYPE html><html><head><meta http-equiv="content-type" content="text/html;charset=utf-8"/>
<title>确认订单</title><meta content="width=device-width,initial-scale=1.0,minimum-scale=1.0,maximum-scale=1.0,user-scalable=0" name="viewport">
<link href="<?php echo env('APP_URL'); ?>/css/weixin/style.css" type="text/css" rel="stylesheet">
<script type="text/javascript" src="<?php echo env('APP_URL'); ?>/js/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo env('APP_URL'); ?>/js/weixin/mobile.js"></script>
<link href="<?php echo env('APP_URL'); ?>/css/font-awesome.min.css" type="text/css" rel="stylesheet">
<meta name="keywords" content="关键词"><meta name="description" content="描述"></head><body style="background-color:#f1f1f1;">
<!-- 订单确认信息-start -->
<div id="checkout_info">
<div class="classreturn loginsignup">
    <div class="ds-in-bl return"><a href="javascript:history.back(-1);"><img src="<?php echo env('APP_URL'); ?>/images/weixin/return.png" alt="返回"></a></div>
    <div class="ds-in-bl tit center"><span>确认订单</span></div>
    <div class="ds-in-bl nav_menu"><a href="javascript:void(0);"><img src="<?php echo env('APP_URL'); ?>/images/weixin/class1.png" alt="菜单"></a></div>
</div>

@include('weixin.common.headerNav')

<form action="<?php echo route('weixin_cart_done'); ?>" method="post" id="myform">
<input type="hidden" name="cartids" id="cartids" value="<?php echo $cartids; ?>">
<!-- 选择收货地址-start -->
<a href="javascript:;" onclick="selectaddress();">
<div class="checkout-addr">
    <input name="default_address_id" type="hidden" id="default_address_id" value="<?php if($user_default_address){echo $user_default_address['id'];} ?>">
    <p class="title"><span class="name" id="default_consignee"><?php if($user_default_address){echo $user_default_address['name'];} ?></span> <span class="tel" id="default_phone"><?php if($user_default_address){echo $user_default_address['mobile'];} ?></span></p>
    <p class="des" id="default_address"><?php if($user_default_address){ ?><?php echo $user_default_address['province_name']; ?><?php echo $user_default_address['city_name']; ?><?php echo $user_default_address['district_name']; ?> <?php echo $user_default_address['address']; ?><?php }else{ ?>请添加收货地址<?php } ?></p>
    <i></i>
</div>
</a>
<style>
.checkout-addr{position: relative;/* border-top: 1px solid #e3e3e3;border-bottom: 1px solid #e3e3e3; */background: #fff;margin-top:10px;padding:10px;}
.checkout-addr p{margin-right:20px;}.checkout-addr .title{font-size:18px;color:#353535;}.checkout-addr .des{color:#9b9b9b;}
.checkout-addr i{position: absolute;top: 50%;right:12px;margin-top:-6px;color:#bbb;display:inline-block;border-right:2px solid;border-bottom:2px solid;width:12px;height:12px;transform:rotate(-45deg);}
</style>
<script>
function selectaddress()
{
    $('#addressList').show();
    $('#checkout_info').hide();
}
</script>
<!-- 选择收货地址-end -->
<!-- 订单商品列表-start -->
<ul class="goodslist">
<?php if($checkout_goods['list']){foreach($checkout_goods['list'] as $k=>$v){ ?>
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
<!-- 订单商品列表-end -->
<div class="floor">
<ul class="fui-list mt10">
    <!-- <a href="javascript:update_pay_mode_layer();"><li>
        <div class="ui-list-info">
            <h4 class="ui-nowrap">支付方式</h4>
            <div class="ui-txt-info"><span id="paytext">微信支付</span> &nbsp;</div>
            <input type="hidden" name="payid" id="payid" value="2">
        </div>
        <i class="fa fa-angle-right" aria-hidden="true"></i>
    </li></a>
    <script>
    function update_pay_mode_layer()
    {
        //询问框
        layer.open({
            content: '<div style="padding:15px;"><?php if($is_balance_enough){ ?><a style="margin-bottom:10px;background-color:#1aad19;border:1px solid #179e16;color:white;border-radius:2px;text-align:center;" class="bottoma" onclick="layer.closeAll();" href="javascript:update_pay_mode(1,\'余额支付\');">账户余额 <?php echo $user_info['money']; ?>元</a><?php }else{ ?><a style="margin-bottom:10px;background-color:#999;border:1px solid #999;color:white;border-radius:2px;text-align:center;" class="bottoma" href="javascript:;">余额不足 <?php echo $user_info['money']; ?>元</a><?php } ?><a style="background-color:#ea5a3d;border:1px solid #dd2727;color:white;border-radius:2px;text-align:center;" class="bottoma" onclick="layer.closeAll();" href="javascript:update_pay_mode(2,\'微信支付\');">微信支付</a></div>'
        });
    }
    
    function update_pay_mode(id,name)
    {
        $("#paytext").html(name);
        $("#payid").val(id);
    }
    </script> -->
    <a href="javascript:select_bonus_layer();"><li>
        <div class="ui-list-info">
            <h4 class="ui-nowrap">优惠券</h4>
            <div class="ui-txt-info"><span id="bonustext">请选择优惠券</span> &nbsp;</div>
            <input type="hidden" name="user_bonus_id" id="user_bonus_id" value="0">
        </div>
        <i class="fa fa-angle-right" aria-hidden="true"></i>
    </li></a>
    <script>
    function select_bonus_layer()
    {
        //询问框
        layer.open({
            title: [
              '请选择优惠券',
              'background-color: #FF4351; color:#fff;'
            ]
            ,content: '<div><?php if($bonus_list){foreach($bonus_list as $k=>$v){ ?><a style="margin-bottom:10px;background-color:#1aad19;border:1px solid #179e16;color:white;border-radius:2px;text-align:center;" class="bottoma" onclick="layer.closeAll();" href="javascript:select_bonus(<?php echo $v['user_bonus_id']; ?>,\'省<?php echo $v['money']; ?>元\',<?php echo $v['money']; ?>);">省<?php echo $v['money']; ?>元</a><?php }} ?><a style="background-color:#ea5a3d;border:1px solid #dd2727;color:white;border-radius:2px;text-align:center;" class="bottoma" onclick="layer.closeAll();" href="javascript:select_bonus(0,\'不使用优惠\',0);">不使用优惠</a></div>'
        });
    }
    
    function select_bonus(id,name,money)
    {
        $("#bonustext").html(name);
        $("#user_bonus_id").val(id);
        //更改总计价格
        change_totalamount(money);
    }
    
    function change_totalamount(discount)
    {
        totalamount = $("#product_total_price").val(); //商品总价
        shipping_costs = $("#shipping_costs").val(); //运费
        totalamount = parseFloat(totalamount) + parseFloat(shipping_costs) - parseFloat(discount);
        $("#totalamount").html(totalamount.toFixed(2));
    }
    
    function submit_form()
    {
        //payid = $("#payid").val();
        //if(payid==''){alert("请选择支付方式");}
        
        default_address_id = $("#default_address_id").val();
        if(default_address_id==''){alert("请选择收货地址");}
        
        var re = /^[0-9]+.?[0-9]*$/; //判断字符串是否为数字
        /* if (!re.test(payid))
        {
            alert("支付方式格式不正确");
            return false;
        } */
        
        if (!re.test(default_address_id))
        {
            alert("收货地址格式不正确");
            return false;
        }
        
        //询问框
        layer.open({
            content: '您确定要提交吗？'
            ,btn: ['确定', '取消']
            ,yes: function(index){
                document.getElementById("myform").submit();
            }
        });
    }
    </script>
</ul></div>

<div class="floor" style="background-color:#fff;margin-top:10px;padding:10px;">
<div class="buy_note">
    <div class="buy_note_tit"><span>备注</span></div>
    <textarea name="message" rows="3" placeholder="给卖家留言"></textarea>
</div>
<div class="order_check_info">
    <p>共<?php echo $checkout_goods['total_goods']; ?>件商品</p>
    <!-- <p>运费：¥0</p> -->
    <input type="hidden" name="shipping_costs" id="shipping_costs" value="0">
    <input type="hidden" name="product_total_price" id="product_total_price" value="<?php echo $checkout_goods['total_price']; ?>">
    <p>应付款金额：<span class="red">¥<i id="totalamount"><?php echo $checkout_goods['total_price']; ?></i></span></p>
</div>
</div>
<style>
.buy_note{margin:5px 0 15px 0;}
.buy_note_tit{font-size:16px;margin-bottom:15px;}
.buy_note textarea{display:block;font-size: 14px;border:1px solid #e1e1e1;width: 100%;padding:10px;box-sizing: border-box;}
.order_check_info p{text-align:right;line-height:22px;color: #666;font-size:14px;}
.order_check_info p .red{color:#ff5500;font-size:18px;}
</style>

<div class="setting"><div class="close"><a href="javascript:submit_form();" id="logout">提交</a></div></div>
</form>
</div>
<!-- 订单确认信息-end -->

<!-- 收货地址选择-start -->
<div id="addressList" style="display:none;">
    <div class="classreturn loginsignup">
        <div class="ds-in-bl return"><a href="javascript:addressback();"><img src="<?php echo env('APP_URL'); ?>/images/weixin/return.png" alt="返回"></a></div>
        <div class="ds-in-bl tit center"><span>选择收货地址</span></div>
    </div>
    <script>
    function addressback()
    {
        $('#checkout_info').show();
        $('#addressList').hide();
    }
    
    function defaultback(id)
    {
        setdefault(id);
        addressback();
        //var url = "";
        //location.href = url;
    }
    
    function setdefault(id)
    {
        var access_token = '<?php echo $_SESSION['weixin_user_info']['access_token']; ?>';
        var url = '<?php echo env('APP_API_URL').'/user_address_setdefault'; ?>';
        
        $.post(url,{access_token:access_token,id:id},function(res)
        {
            if (res.code == 0)
            {
                //订单确认页面
                $("#default_address_id").val(id);
                $("#default_consignee").html($("#consignee"+id).html());
                $("#default_phone").html($("#con_phone"+id).html());
                $("#default_address").html($("#con_address"+id).html());
            }
            else
            {
                //提示
                layer.open({
                    content: res.msg
                    ,skin: 'msg'
                    ,time: 2 //2秒后自动关闭
                });
            }
        }, 'json');
    }
    </script>
    <!-- 收货地址列表-start -->
    <div class="address_list mt10">
    <style>
    .address_list .flow-have-adr{padding:15px;margin-bottom:10px;background-color:#fff;}
    .address_list .ect-colory{color:#e23435;}
    .address_list .f-h-adr-title label{font-size:18px;color:#000;margin-right:5px;}
    .address_list .f-h-adr-con{color:#777;margin-top:5px;margin-bottom:5px;}
    </style>
    <?php if($address_list){foreach($address_list as $k=>$v){ ?>
    <div class="flow-have-adr" onclick="defaultback('<?php echo $v['id']; ?>')">
        <p class="f-h-adr-title"><label id="consignee<?php echo $v['id']; ?>"><?php echo $v['name']; ?></label><span class="ect-colory fr" id="con_phone<?php echo $v['id']; ?>"><?php echo $v['mobile']; ?></span></p>
        <p class="f-h-adr-con"><span class="ect-colory"><?php if($v['is_default']==1){ ?>[默认地址]<?php } ?></span><span id="con_address<?php echo $v['id']; ?>"><?php echo $v['province_name'].$v['city_name'].$v['district_name'].' '.$v['address']; ?></span></p>
    </div>
    <?php }}else{ ?>
        <div style="text-align:center;line-height:40px;color:#999;">暂无记录</div>
    <?php } ?>
    </div>
    <!-- 收货地址列表-end -->
    <!-- 添加收货地址-start -->
    <style>
    .adr_add{padding:0 10px;background-color:#fff;}
    .adr-form-group{margin-top:10px;}
    .adr-form-group input[type=text],.adr-form-group textarea{display: block;width: 100%;font-size:16px;padding:10px;color: #777;vertical-align: middle;background-color: #fff;background-image: none;border: 1px solid #ddd;border-radius: 0;box-sizing:border-box;}
    .adr-form-group select{padding:5px;margin-right:10px;}
    .bottoma{display:block;font-size:18px;padding:10px;color:white;background-color:#f23030;text-align:center;}
    </style>
    <div class="adr_add">
    <div style="font-size:18px;padding-top:10px;text-align:center;">添加新的收货地址</div>
    <div class="adr-form-group">
      <label for="doc-ipt-email-1">收货人</label>
      <input name="name" type="text" class="" id="name" placeholder="输入姓名">
    </div>
    <div class="adr-form-group">
      <label for="doc-ipt-email-1">手机号码</label>
      <input type="text" name="mobile" class="" id="mobile" placeholder="输入手机号码">
    </div>
    <div class="adr-form-group">
    地区： <select id='sheng'></select><select id='shi'></select><select id='qu'></select>
    <script>
    // JavaScript Document
    $(document).ready(function(e) {
        //加载省的数据
        LoadSheng();
        //加载市的数据
        LoadShi();
        //加载区的数据
        LoadQu();

        //给省的下拉加点击事件
        $("#sheng").change(function(){
            //重新加载市
            LoadShi();
            //重新加载区
            LoadQu();
        });

        //给市的下拉加点击事件
        $("#shi").change(function(){
            //重新加载区
            LoadQu();
        });
    });

    //加载省份的方法
    function LoadSheng(parent_id,select_id)
    {
        //省的父级代号
        parent_id = parent_id || '86';
        select_id = select_id || 0;
        
        $.ajax({
            async:false,
            url:'<?php echo env('APP_API_URL')."/region_list"; ?>',
            data:{id:parent_id},
            type:"GET",
            dataType:"json",
            success: function(res){
                var hang = res.data;
                var str = "";
                for(var i=0;i<hang.length;i++)
                {
                    if(select_id != 0 && select_id == hang[i].id)
                    {
                        str = str+"<option selected='selected' value='"+hang[i].id+"'>"+hang[i].name+"</option>";
                    }
                    else
                    {
                        str = str+"<option value='"+hang[i].id+"'>"+hang[i].name+"</option>";
                    }
                }
                
                $("#sheng").html(str);
            }
        });
    }

    //加载市的方法
    function LoadShi(parent_id,select_id)
    {
        //找市的父级代号
        parent_id = parent_id || $("#sheng").val();
        select_id = select_id || 0;
        
        $.ajax({
            async:false,
            url:'<?php echo env('APP_API_URL')."/region_list"; ?>',
            data:{id:parent_id},
            type:"GET",
            dataType:"json",
            success: function(res){
                var hang = res.data;
                var str = "";
                for(var i=0;i<hang.length;i++)
                {
                    if(select_id != 0 && select_id == hang[i].id)
                    {
                        str = str+"<option selected='selected' value='"+hang[i].id+"'>"+hang[i].name+"</option>";
                    }
                    else
                    {
                        str = str+"<option value='"+hang[i].id+"'>"+hang[i].name+"</option>";
                    }
                }
                
                $("#shi").html(str);
            }
        });
    }

    //加载区的方法
    function LoadQu(parent_id,select_id)
    {
        //找区的父级代号
        parent_id = parent_id || $("#shi").val();
        select_id = select_id || 0;
        
        $.ajax({
            url:'<?php echo env('APP_API_URL')."/region_list"; ?>',
            data:{id:parent_id},
            type:"GET",
            dataType:"json",
            success: function(res){
                var hang = res.data;
                var str = "";
                for(var i=0;i<hang.length;i++)
                {
                    if(select_id != 0 && select_id == hang[i].id)
                    {
                        str = str+"<option selected='selected' value='"+hang[i].id+"'>"+hang[i].name+"</option>";
                    }
                    else
                    {
                        str = str+"<option value='"+hang[i].id+"'>"+hang[i].name+"</option>";
                    }
                }
                
                $("#qu").html(str);
            }
        });
    }
    </script>
    </div>
    <div class="adr-form-group">
      <label for="doc-ta-1">详细地址</label>
      <textarea name="address" class="" rows="3" id="address"></textarea>
    </div>
    <a style="margin:10px;" class="bottoma" href="javascript:adr_dosubmit();">提交</a>
    <br><br>
    </div>
    
    <!-- 添加收货地址-start -->
    <script type="text/javascript" src="<?php echo env('APP_URL'); ?>/js/layer/mobile/layer.js"></script>
    <script>
    function adr_dosubmit()
    {
        var access_token = '<?php echo $_SESSION['weixin_user_info']['access_token']; ?>';
        
        var url = '<?php echo env('APP_API_URL').'/user_address_add'; ?>';
        var name = $("#name").val();
        var mobile = $("#mobile").val();
        var address = $("#address").val();
        
        var province = $("#sheng").val();
        var city = $("#shi").val();
        var district = $("#qu").val();
        
        var is_default = 0;
        //if(document.getElementById("is_default").checked){is_default = 1;}
        
        if(name == '')
        {
            //提示
            layer.open({
                content: '姓名不能为空'
                ,skin: 'msg'
                ,time: 2 //2秒后自动关闭
            });
            
            return false;
        }
        
        if(mobile == '')
        {
            //提示
            layer.open({
                content: '手机号不能为空'
                ,skin: 'msg'
                ,time: 2 //2秒后自动关闭
            });
            
            return false;
        }
        
        if(validatemobile(mobile) == false)
        {
            //提示
            layer.open({
                content: '手机号格式不正确'
                ,skin: 'msg'
                ,time: 2 //2秒后自动关闭
            });
            
            return false;
        }
        
        if(address == '')
        {
            //提示
            layer.open({
                content: '地址不能为空'
                ,skin: 'msg'
                ,time: 2 //2秒后自动关闭
            });
            
            return false;
        }
        
        $.post(url,{access_token:access_token,name:name,mobile:mobile,address:address,province:province,city:city,district:district,is_default:is_default},function(res)
        {
            if(res.code==0)
            {
                setdefault(res.data.id);
                window.location.reload();
            }
            else
            {
                //提示
                layer.open({
                    content: res.msg
                    ,skin: 'msg'
                    ,time: 2 //2秒后自动关闭
                });
            }
        },'json');
    }
    </script>
</div>
<!-- 收货地址选择-end -->

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

<script>
function unshow(id)
{
	$(id).hide();
}

function showmask(id)
{
	$(id).show();
}
</script>
</body></html>