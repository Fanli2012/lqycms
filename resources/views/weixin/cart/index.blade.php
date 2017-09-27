<!DOCTYPE html><html><head><meta http-equiv="content-type" content="text/html;charset=utf-8"/>
<title>购物车 - 商城</title><meta content="width=device-width,initial-scale=1.0,minimum-scale=1.0,maximum-scale=1.0,user-scalable=0" name="viewport">
<link href="<?php echo env('APP_URL'); ?>/css/weixin/style.css" type="text/css" rel="stylesheet">
<script type="text/javascript" src="<?php echo env('APP_URL'); ?>/js/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo env('APP_URL'); ?>/js/weixin/mobile.js"></script>
<meta name="keywords" content="关键词"><meta name="description" content="描述"></head><body>
<div class="classreturn loginsignup">
    <div class="ds-in-bl return"><a href="javascript:history.back(-1);"><img src="<?php echo env('APP_URL'); ?>/images/weixin/return.png" alt="返回"></a></div>
    <div class="ds-in-bl tit center"><span>购物车</span></div>
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

<div class="cart_list">
    <!--商品列表-s-->
    <div class="sc_list" id="cart_list_13">
        <div class="radio-img">
            <div class="radio fl ">
                <!--商品勾选按钮-->
                <span onclick="checkGoods(this)" class="che">
                 <i>
                     <input name="checkItem" type="checkbox" style="display:none;" value="13">
                 </i>
                 </span>
            </div>
            <div class="shopimg fl">
                <a href="/index.php/Mobile/Goods/goodsInfo/id/135.html">
                    <!--商品图片-->
                    <img src="<?php echo env('APP_URL'); ?>/images/weixin/goods_thumb_135_200_200.jpeg">
                </a>
            </div>
        </div>
        <div class="deleshow">
            <div class="deletes">
                <!--商品名-->
                <p class="tit">重庆电信手机卡电话卡语音卡选靓号3G4G卡内部5折卡低资费（飞）</p>
                <!--删除按钮-->
                <a href="javascript:void(0);" class="delescj deleteGoods" data-cart-id="13"><img src="<?php echo env('APP_URL'); ?>/images/weixin/dele.png"></a>
            </div>
            <!--商品属性，规格-->
            <p class="weight">合约套餐:乐享4G套餐59元</p>
            <div class="prices">
                <p class="sc_pri fl">
                    <!--商品单价-->
                    <span>￥</span><span>54.28</span>
                </p>
                <!--加减数量-->
                <div class="plus fr get_mp">
                    <span class="mp_minous disable">-</span>
                    <span class="mp_mp">
                        <input name="changeQuantity_13" type="text" id="changeQuantity_13" value="1" onkeyup="this.value=this.value.replace(/[^\d]/g,'')" class="input-num">
                    </span>
                    <span class="mp_plus">+</span>
                </div>
            </div>
        </div>
    </div>
    <!--商品列表-e-->
    <!--商品列表-s-->
    <div class="sc_list" id="cart_list_13">
        <div class="radio-img">
            <div class="radio fl ">
                <!--商品勾选按钮-->
                <span onclick="checkGoods(this)" class="che">
                 <i>
                     <input name="checkItem" type="checkbox" style="display:none;" value="13">
                 </i>
                 </span>
            </div>
            <div class="shopimg fl">
                <a href="/index.php/Mobile/Goods/goodsInfo/id/135.html">
                    <!--商品图片-->
                    <img src="<?php echo env('APP_URL'); ?>/images/weixin/goods_thumb_135_200_200.jpeg">
                </a>
            </div>
        </div>
        <div class="deleshow">
            <div class="deletes">
                <!--商品名-->
                <p class="tit">重庆电信手机卡电话卡语音卡选靓号3G4G卡内部5折卡低资费（飞）</p>
                <!--删除按钮-->
                <a href="javascript:void(0);" class="delescj deleteGoods" data-cart-id="13"><img src="<?php echo env('APP_URL'); ?>/images/weixin/dele.png"></a>
            </div>
            <!--商品属性，规格-->
            <p class="weight">合约套餐:乐享4G套餐59元</p>
            <div class="prices">
                <p class="sc_pri fl">
                    <!--商品单价-->
                    <span>￥</span><span>54.28</span>
                </p>
                <!--加减数量-->
                <div class="plus fr get_mp">
                    <span class="mp_minous disable">-</span>
                    <span class="mp_mp">
                        <input name="changeQuantity_13" type="text" id="changeQuantity_13" value="1" onkeyup="this.value=this.value.replace(/[^\d]/g,'')" class="input-num">
                    </span>
                    <span class="mp_plus">+</span>
                </div>
            </div>
        </div>
    </div>
    <!--商品列表-e-->
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
                <p><span class="pmo">总计：</span><span>￥</span><span id="total_fee">919.08</span></p>
            </div>
        </div>
    </div>
    <!--提交栏-e-->
    <script type="text/javascript">
        $(document).ready(function(){
            initDecrement();
            initCheckBox();
        });
    </script>
</div>

<!--购物车没有商品-start-->
<div class="cart_list">
    <div class="nonenothing">
        <img src="<?php echo env('APP_URL'); ?>/images/weixin/nothing.png">
        <p>购物车暂无商品</p>
        <a href="/index.php/Mobile/Index/index.html">去逛逛</a>
    </div>
</div>
<br><br>
<!--猜你喜欢-start-->
<div class="floor">
<div class="banner_headline">
    <div class="tit">
        <h4>猜你喜欢</h4>
    </div>
</div>
<div class="likeshop">
    <ul class="goods_list">
        <li><a href="detail.html"><img alt="1" src="images/weixin/goods_thumb_400_400.jpeg"><div class="goods_info"><p class="goods_tit">美女真空凸点诱惑</p><div class="goods_price">￥<b>100.00</b></div></div></a></li>
        <li><a href="detail.html"><img alt="2" src="images/weixin/goods_thumb_400_400.jpeg"><div class="goods_info"><p class="goods_tit">性感小骚货在床上</p><div class="goods_price">￥<b>100.00</b></div></div></a></li>
        <li><a href="detail.html"><img alt="3" src="images/weixin/goods_thumb_400_400.jpeg"><div class="goods_info"><p class="goods_tit">小野猫嫩模大尺度写真</p><div class="goods_price">￥<b>100.00</b></div></div></a></li>
        <li><a href="detail.html"><img alt="4" src="images/weixin/goods_thumb_400_400.jpeg"><div class="goods_info"><p class="goods_tit">韩国嫩模的逆天身材</p><div class="goods_price">￥<b>100.00</b></div></div></a></li>
        <li><a href="detail.html"><img alt="5" src="images/weixin/goods_thumb_400_400.jpeg"><div class="goods_info"><p class="goods_tit">推女郎林夕图片</p><div class="goods_price">￥<b>100.00</b></div></div></a></li>
        <li><a href="detail.html"><img alt="6" src="images/weixin/goods_thumb_400_400.jpeg"><div class="goods_info"><p class="goods_tit">性感闺蜜艺术照</p><div class="goods_price">￥<b>100.00</b></div></div></a></li>
    </ul>
</div>
</div>
<!--购物车没有商品-end-->

</body></html>