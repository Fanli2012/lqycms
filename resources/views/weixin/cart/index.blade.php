<!DOCTYPE html><html><head><meta http-equiv="content-type" content="text/html;charset=utf-8"/>
<title>购物车</title><meta content="width=device-width,initial-scale=1.0,minimum-scale=1.0,maximum-scale=1.0,user-scalable=0" name="viewport">
<link href="<?php echo env('APP_URL'); ?>/css/weixin/style.css" type="text/css" rel="stylesheet">
<script type="text/javascript" src="<?php echo env('APP_URL'); ?>/js/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo env('APP_URL'); ?>/js/weixin/mobile.js"></script>
<meta name="keywords" content="关键词"><meta name="description" content="描述"></head><body>
<div class="classreturn loginsignup">
    <div class="ds-in-bl return"><a href="javascript:history.back(-1);"><img src="<?php echo env('APP_URL'); ?>/images/weixin/return.png" alt="返回"></a></div>
    <div class="ds-in-bl tit center"><span>购物车</span></div>
    <div class="ds-in-bl nav_menu"><a href="javascript:void(0);"><img src="<?php echo env('APP_URL'); ?>/images/weixin/class1.png" alt="菜单"></a></div>
</div>

@include('weixin.common.headerNav')

<?php if($list){ ?>
<div class="cart_list">
    <!--商品列表-s-->
    <?php foreach($list as $k=>$v){ ?>
    <div class="sc_list" id="cart_list_<?php echo $v['id']; ?>">
        <div class="radio-img">
            <div class="radio fl ">
                <!--商品勾选按钮-->
                <span onclick="checkGoods(this)" class="che">
                 <i>
                     <input name="checkItem" type="checkbox" style="display:none;" data-goods-id="<?php echo $v['goods_id']; ?>" data-cart-id="<?php echo $v['id']; ?>">
                 </i>
                 </span>
            </div>
            <div class="shopimg fl">
                <a href="<?php echo $v['goods_detail_url']; ?>">
                    <img src="<?php echo $v['litpic']; ?>">
                </a>
            </div>
        </div>
        <div class="deleshow">
            <div class="deletes">
                <!--商品名-->
                <p class="tit"><?php echo $v['title']; ?></p>
                <!--删除按钮-->
                <a href="javascript:void(0);" class="delescj deleteGoods" data-cart-id="<?php echo $v['id']; ?>"><img src="<?php echo env('APP_URL'); ?>/images/weixin/dele.png"></a>
            </div>
            <!--商品属性，规格-->
            <p class="weight"></p>
            <div class="prices">
                <p class="sc_pri fl">
                    <!--商品单价-->
                    <span>￥</span><span id="goods_price<?php echo $v['goods_id']; ?>"><?php echo $v['final_price']; ?></span>
                </p>
                <!--加减数量-->
                <div class="plus fr get_mp">
                    <span class="mp_minous" onClick="change_goods_number(1,<?php echo $v['goods_id']; ?>)">-</span>
                    <span class="mp_mp"><input name="goods_number<?php echo $v['goods_id']; ?>" type="text" id="goods_number<?php echo $v['goods_id']; ?>" value="<?php echo $v['goods_number']; ?>" onkeyup="this.value=this.value.replace(/[^\d]/g,'')" autocomplete="off" value="1" onblur="change_goods_number(2,<?php echo $v['goods_id']; ?>)" class="input-num"></span>
                    <span class="mp_plus" onClick="change_goods_number(3,<?php echo $v['goods_id']; ?>)">+</span>
                </div>
            </div>
        </div>
    </div>
    <!--商品列表-e-->
    <?php } ?>
    <!--提交栏-s-->
    <div class="foohi foohiext">
        <div class="payit ma-to-20 payallb">
            <div class="radio fl">
                <span class="che alltoggle checkFull" onclick="checkGoods(this)">
                    <i></i>
                </span>
                <span class="all">全选</span>
            </div>
            <div class="fr">
                <a href="javascript:void(0);" onclick="cart_submit();">去结算</a>
            </div>
            <div class="youbia">
                <p><span class="pmo">总计：</span><span>￥</span><span id="total_fee">0</span></p>
            </div>
        </div>
    </div>
    <!--提交栏-e-->
</div>
<?php }else{ ?>
<!--购物车没有商品-start-->
<div class="cart_list">
    <div class="nonenothing">
        <img src="<?php echo env('APP_URL'); ?>/images/weixin/nothing.png">
        <p>购物车暂无商品</p>
        <a href="<?php echo route('weixin'); ?>">去逛逛</a>
    </div><br><br>
</div>

<!--猜你喜欢-start-->
<div class="floor">
<div class="banner_headline">
    <div class="tit">
        <h4>猜你喜欢</h4>
    </div>
</div>
<div class="likeshop">
    <ul class="goods_list">
    <?php if($like_goods_list){foreach($like_goods_list as $k=>$v){ ?>
        <li><a href="<?php echo $v['goods_detail_url']; ?>"><img alt="<?php echo $v['title']; ?>" src="<?php echo $v['litpic']; ?>"><div class="goods_info"><p class="goods_tit"><?php echo $v['title']; ?></p><div class="goods_price">￥<b><?php echo $v['price']; ?></b></div></div></a></li>
    <?php }} ?>
    </ul>
</div>
</div>
<!--购物车没有商品-end-->
@include('weixin.common.footer')
<?php } ?>

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
                content: res.msg
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
    
    $('#total_fee').text(total_price.toFixed(2));
}
</script>
</body></html>