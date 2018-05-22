<!DOCTYPE html><html><head><meta http-equiv="content-type" content="text/html;charset=utf-8"/>
<title>个人中心</title><meta name="keywords" content="关键词"><meta name="description" content="描述"><meta content="width=device-width,initial-scale=1.0,minimum-scale=1.0,maximum-scale=1.0,user-scalable=0" name="viewport">
<link href="<?php echo env('APP_URL'); ?>/css/weixin/style.css" type="text/css" rel="stylesheet">
<script type="text/javascript" src="<?php echo env('APP_URL'); ?>/js/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo env('APP_URL'); ?>/js/weixin/mobile.js"></script></head><body>
<div class="myhearder" style="background:#ec5151;color:#fff;">
    <div class="person">
        <div class="personicon">
            <a href="<?php echo route('weixin_userinfo'); ?>"><img src="<?php echo $user_info['head_img']; ?>" onerror="this.src='<?php echo env('APP_URL'); ?>/images/weixin/no_user.jpg'"></a>
        </div>
        <div class="lors">
            <a style="color:#fff;" href="<?php echo route('weixin_userinfo'); ?>"><?php if($user_info['user_name']){echo $user_info['user_name'];}else{echo $user_info['mobile'];} ?></a>
        </div>
    </div>
    <div class="set">
        <!--设置-->
        <a class="setting" href="<?php echo route('weixin_userinfo'); ?>"><i></i></a>
        <!--我的留言-->
        <!--<a class="massage" href="<?php echo route('weixin_user_message_list'); ?>"><i></i></a>-->
    </div>
    <!-- <div class="scgz">
        <ul>
            <li>
                <a href="<?php echo route('weixin_user_collect_goods'); ?>">
                    <h2><?php echo $user_info['collect_goods_count']; ?></h2>
                    <p>我的收藏</p>
                </a>
            </li>
            <li>
                <a href="<?php echo route('weixin_user_message_list'); ?>">
                    <h2>0</h2>
                    <p>消息通知</p>
                </a>
            </li>
        </ul>
    </div>
    <img src="<?php echo env('APP_URL'); ?>/images/weixin/bjm.jpg" width="100%" height="100%" class="user_bg"> -->
</div>

<div class="floor my g4">
    <div class="content">
        <!--订单管理模块-s-->
        <div class="floor myorder">
            <div class="content30">
                <div class="order">
                    <div class="fl">
                        <img src="<?php echo env('APP_URL'); ?>/images/weixin/mlist.png">
                        <span>我的订单</span>
                    </div>
                    <div class="fr">
                        <a href="<?php echo route('weixin_order_list'); ?>">
                            <span>全部订单</span>
                            <i class="Mright"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="floor floor_order">
            <ul>
                <li>
                    <a href="<?php echo route('weixin_order_list',array('status'=>1)); ?>">
                        <!-- <span>0</span> -->
                        <img src="<?php echo env('APP_URL'); ?>/images/weixin/q1.png" alt="">
                        <p>待付款</p>
                    </a>
                </li>
                <li>
                    <a href="<?php echo route('weixin_order_list',array('status'=>3)); ?>">
                        <!-- <span>0</span> -->
                        <img src="<?php echo env('APP_URL'); ?>/images/weixin/q2.png" alt="">
                        <p>待收货</p>
                    </a>
                </li>
                <li>
                    <a href="<?php echo route('weixin_order_list',array('status'=>4)); ?>">
                        <!-- <span>0</span> -->
                        <img src="<?php echo env('APP_URL'); ?>/images/weixin/q3.png" alt="">
                        <p>待评价</p>
                    </a>
                </li>
                <li>
                    <a href="<?php echo route('weixin_order_list',array('status'=>5)); ?>">
                        <!-- <span>0</span> -->
                        <img src="<?php echo env('APP_URL'); ?>/images/weixin/q4.png" alt="">
                        <p>退款/退货</p>
                    </a>
                </li>
            </ul>
        </div>
        <!--订单管理模块-e-->

        <!--资金管理-s-->
        <div class="floor myorder mt10">
            <div class="content30">
                <div class="order">
                    <div class="fl">
                        <img src="<?php echo env('APP_URL'); ?>/images/weixin/mwallet.png">
                        <span>我的钱包</span>
                    </div>
                    <div class="fr">
                        <!--<a href="bankrollmm.html">-->
                        <a href="<?php echo route('weixin_user_account'); ?>">
                            <span>资金管理</span>
                            <i class="Mright"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="floor w3">
            <ul>
                <li>
                    <a href="<?php echo route('weixin_user_money_list'); ?>">
                        <div class="tit"><?php echo $user_info['money']; ?></div>
                        <p>余额</p>
                    </a>
                </li>
                <li>
                    <a href="<?php echo route('weixin_user_bonus_list'); ?>">
                        <div class="tit"><?php echo $user_info['bonus_count']; ?></div>
                        <p>优惠券</p>
                    </a>
                </li>
                <li>
                    <a href="<?php echo route('weixin_user_point_list'); ?>">
                        <div class="tit"><?php echo $user_info['point']; ?></div>
                        <p>积分</p>
                    </a>
                </li>
            </ul>
        </div>
        <!--资金管理-e-->

        <div class="floor list7 mt10">
            <div class="myorder p">
                <div class="content30">
                    <a href="<?php echo route('weixin_user_distribution'); ?>">
                        <div class="order">
                            <div class="fl">
                                <img src="<?php echo env('APP_URL'); ?>/images/weixin/w1.png">
                                <span>我的分销</span>
                            </div>
                            <div class="fr">
                                <i class="Mright"></i>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
            <div class="myorder p">
                <div class="content30">
                    <a href="<?php echo route('weixin_user_collect_goods'); ?>">
                        <div class="order">
                            <div class="fl">
                                <img src="<?php echo env('APP_URL'); ?>/images/weixin/w9.png">
                                <span>我的收藏</span>
                            </div>
                            <div class="fr">
                                <i class="Mright"></i>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
            <div class="myorder p">
                <div class="content30">
                    <a href="<?php echo route('weixin_user_goods_history'); ?>">
                        <div class="order">
                            <div class="fl">
                                <img src="<?php echo env('APP_URL'); ?>/images/weixin/w3.png">
                                <span>我的足迹</span>
                            </div>
                            <div class="fr">
                                <i class="Mright"></i>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
            <div class="myorder p">
                <div class="content30">
                    <a href="<?php echo route('weixin_user_address_list'); ?>">
                        <div class="order">
                            <div class="fl">
                                <img src="<?php echo env('APP_URL'); ?>/images/weixin/w10.png">
                                <span>地址管理</span>
                            </div>
                            <div class="fr">
                                <i class="Mright"></i>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
            <!-- <div class="myorder p">
                <div class="content30">
                    <a href="">
                        <div class="order">
                            <div class="fl">
                                <img src="<?php echo env('APP_URL'); ?>/images/weixin/w11.png"/>
                                <span>推介赚钱</span>
                            </div>
                            <div class="fr">
                                <i class="Mright"></i>
                            </div>
                        </div>
                    </a>
                </div>
            </div> -->
            <div class="myorder p">
                <div class="content30">
                    <a href="<?php echo route('weixin_singlepage',array('id'=>'help')); ?>">
                        <div class="order">
                            <div class="fl">
                                <img src="<?php echo env('APP_URL'); ?>/images/weixin/w6.png"/>
                                <span>帮助中心</span>
                            </div>
                            <div class="fr">
                                <i class="Mright"></i>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
            <div class="myorder p">
                <div class="content30">
                    <a href="<?php echo route('weixin_user_feedback_add'); ?>">
                        <div class="order">
                            <div class="fl">
                                <img src="<?php echo env('APP_URL'); ?>/images/weixin/w7.png"/>
                                <span>意见反馈</span>
                            </div>
                            <div class="fr">
                                <i class="Mright"></i>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
            
            <!-- <div class="myorder p">
                <div class="content30">
                    <a href="/index.php/Mobile/User/comment/status/1.html">
                        <div class="order">
                            <div class="fl">
                                <img src="<?php echo env('APP_URL'); ?>/images/weixin/w2.png">
                                <span>我的评价</span>
                            </div>
                            <div class="fr">
                                <i class="Mright"></i>
                            </div>
                        </div>
                    </a>
                </div>
            </div> -->
            <!-- <div class="myorder p">
                <div class="content30">
                    <a href="/index.php/Mobile/Goods/integralMall.html">
                        <div class="order">
                            <div class="fl">
                                <img src="<?php echo env('APP_URL'); ?>/images/weixin/w5.png">
                                <span>积分商城</span>
                            </div>
                            <div class="fr">
                                <i class="Mright"></i>
                            </div>
                        </div>
                    </a>
                </div>
            </div> -->
            <!-- <div class="myorder p">
                <div class="content30">
                    <a href="<?php echo route('weixin_bonus_list',array('parent_id'=>$_SESSION['weixin_user_info']['id'])); ?>">
                        <div class="order">
                            <div class="fl">
                                <img src="<?php echo env('APP_URL'); ?>/images/weixin/w7.png">
                                <span>领券中心</span>
                            </div>
                            <div class="fr">
                                <i class="Mright"></i>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
            <div class="myorder p">
                <div class="content30">
                    <a href="">
                        <div class="order">
                            <div class="fl">
                                <img src="images/w3.png"/>
                                <span>我的预售</span>
                            </div>
                            <div class="fr">
                                <i class="Mright"></i>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
            <div class="myorder p">
                <div class="content30">
                    <a href="">
                        <div class="order">
                            <div class="fl">
                                <img src="images/w4.png"/>
                                <span>我的拼团</span>
                            </div>
                            <div class="fr">
                                <i class="Mright"></i>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
            -->
        </div>
    </div>
    <div class="setting"><div class="close"><a href="<?php echo route('weixin_user_logout'); ?>" id="logout">安全退出</a></div></div>
</div>

@include('weixin.common.footer')
</body></html>