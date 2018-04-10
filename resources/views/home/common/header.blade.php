<div id="site-nav" class="site-nav">
    <div class="box">
      	<p class="menu-left">
            <span class="mobile">
                <a class="mobileLink" href="<?php echo route('home'); ?>">
                  <?php echo sysconfig('CMS_WEBNAME'); ?>
                </a>
            </span>
            <span class="login-info"><a class="user-nick" href="//i.taobao.com/my_taobao.htm">缘中仙2008</a>  <a href="//login.taobao.com/member/logout.jhtml?f=top&amp;out=true&amp;redirectURL=https%3A%2F%2Fdetail.ju.taobao.com%2Fhome.htm%3Fspm%3D608.2291429.102212b.2.18df210XU8Vrg%26id%3D10000064961473%26item_id%3D523987525652" id="J_Logout">退出</a></span>
        </p>
        <ul class="quick-menu">
            <li>
                <a href="//trade.ju.taobao.com/trade/my_ju.htm" target="_blank">我的聚划算</a>
            </li>
            <li class="cart">
                <a href="//cart.taobao.com/my_cart.htm" target="_blank">购物车</a>
            </li>
            <li>
                <a href="//freeway.ju.taobao.com/front/sellerHome.htm" target="_blank">商户中心</a>
            </li>
            <li>
                <a href="//o.ju.taobao.com/tg/hpcenter/index.htm?reqType=index" target="_blank">帮助</a>
            </li>
        </ul>
    </div>
</div>
<div class="ju-naver">
    <div class="box">
        <h1 class="logo mouseleave"><a class="ju-logo ju-logo-show" href="<?php echo route('home'); ?>" title="logo"><img src="<?php echo env('APP_URL'); ?>/images/logo.png"></a></h1>             
        <ul id="J_NavMenu" class="nav-menu">  
            <li class="menu-home<?php if(route('home') == url()->full()){echo ' current';} ?>"><a class="menu-link" href="<?php echo route('home'); ?>">首页</a></li>
            <li class="menu-brands<?php if(route('home_brandlist') == url()->full()){echo ' current';} ?>"><a class="menu-link" href="<?php echo route('home_brandlist'); ?>">品牌团</a></li>
            <li class="menu-goodslist<?php if(route('home_goodslist') == url()->full()){echo ' current';} ?>"><a class="menu-link" href="<?php echo route('home_goodslist'); ?>">优质精选</a></li>
                        <li class="menu-goodslist<?php if(route('home_goodslist',array('orderby'=>1)) == url()->full()){echo ' current';} ?>"><a class="menu-link" href="<?php echo route('home_goodslist',array('orderby'=>1)); ?>">超值热卖</a></li>
            <li class="menu-qqjx<?php if(route('home_arclist') == url()->full()){echo ' current';} ?>"><a class="menu-link" href="<?php echo route('home_arclist'); ?>">动态</a></li>
            <li class="menu-liangfan<?php if(route('home_singlepage',array('id'=>'about')) == url()->full()){echo ' current';} ?>"><a class="menu-link" href="<?php echo route('home_singlepage',array('id'=>'about')); ?>">关于我们</a></li>
        </ul>
    </div>             
</div>