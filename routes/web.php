<?php
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
//wap路由，要放到最前面，否则解析不到
Route::group(['domain' => env('APP_SUBDOMAIN'), 'namespace' => 'Wap'], function () {
	Route::get('/', 'IndexController@index')->name('wap_home');
	Route::get('/page404', 'IndexController@page404')->name('wap_page404');     //404页面
	Route::get('/tags', 'IndexController@tags')->name('wap_tags');
	Route::get('/search/{id}', 'IndexController@search')->name('wap_search');   //搜索页面
	Route::get('/p/{id}', 'IndexController@detail')->name('wap_detail');        //详情页
	Route::get('/cat{cat}/{page}', 'IndexController@category');                 //分类页，分页
	Route::get('/cat{cat}', 'IndexController@category')->name('wap_category');  //分类页
	Route::get('/tag{tag}/{page}', 'IndexController@tag');                      //标签页，分页
	Route::get('/tag{tag}', 'IndexController@tag')->name('wap_tag');            //标签页
	Route::get('/page/{id}', 'IndexController@page')->name('wap_singlepage');   //单页
	Route::get('/goods/{id}', 'IndexController@goods')->name('wap_goods');      //商品详情页
	Route::get('/goodstype{cat}', 'IndexController@goodstype')->name('wap_goodstype'); //产品分类页
	Route::get('/sitemap.xml', 'IndexController@sitemap')->name('wap_sitemap'); //sitemap
});


//前台路由
Route::group(['namespace' => 'Home'], function () {
	Route::get('/', 'IndexController@index')->name('home');
	Route::get('/page404', 'IndexController@page404')->name('page404');         //404页面
	Route::get('/tags', 'IndexController@tags')->name('home_tags');
	Route::get('/search/{id}', 'IndexController@search')->name('home_search');  //搜索页面
	Route::get('/p/{id}', 'IndexController@detail')->name('home_detail');       //详情页
	Route::get('/cat{cat}/{page}', 'IndexController@category');                 //分类页，分页
	Route::get('/cat{cat}', 'IndexController@category')->name('home_category'); //分类页
    Route::get('/arclist', 'IndexController@arclist')->name('home_arclist');    //文章列表
	Route::get('/tag{tag}/{page}', 'IndexController@tag');                      //标签页，分页
	Route::get('/tag{tag}', 'IndexController@tag')->name('home_tag');           //标签页
	Route::get('/page/{id}', 'IndexController@page')->name('home_singlepage');  //单页
	Route::get('/goods/{id}', 'IndexController@goods')->name('home_goods');     //商品详情页
	Route::get('/goodslist', 'IndexController@goodslist')->name('home_goodslist'); //产品分类页
    Route::get('/brandlist', 'IndexController@brandList')->name('home_brandlist'); //品牌列表
	Route::get('/sitemap.xml', 'IndexController@sitemap')->name('home_sitemap');//sitemap
	
	Route::get('/test', 'IndexController@test')->name('home_test');             //测试
	Route::get('/aaa', function () {
		dd('wap');
	});
});


//微信路由，无需登录
Route::group(['prefix' => 'weixin', 'namespace' => 'Weixin'], function () {
	Route::get('/', 'IndexController@index')->name('weixin');
	Route::get('/category', 'IndexController@category')->name('weixin_category');
    Route::get('/category_goods_list', 'GoodsController@categoryGoodsList')->name('weixin_category_goods_list'); //产品分类页
    Route::get('/page404', 'IndexController@page404')->name('weixin_page404');  //404页面
	Route::get('/search', 'IndexController@search')->name('weixin_search');     //搜索页面
	Route::get('/p/{id}', 'ArticleController@detail')->name('weixin_article_detail'); //文章详情页
	Route::get('/cat{cat}', 'ArticleController@category')->name('weixin_article_category'); //分类页
	Route::get('/tag{tag}', 'IndexController@tag')->name('weixin_tag');         //标签页
	Route::get('/page/{id}', 'IndexController@page')->name('weixin_singlepage');//单页
	Route::get('/goods/{id}', 'GoodsController@goodsDetail')->name('weixin_goods_detail'); //商品详情页
	Route::get('/goodslist', 'GoodsController@goodsList')->name('weixin_goods_list'); //商品筛选列表
    Route::get('/brandlist', 'GoodsBrandController@brandList')->name('weixin_brand_list'); //品牌列表
    Route::get('/brand_detail/{id}', 'GoodsBrandController@brandDetail')->name('weixin_brand_detail'); //品牌详情
    
    Route::get('/bonus_list', 'BonusController@bonusList')->name('weixin_bonus_list');
    Route::any('/wxpay_notify', 'WxPayController@wxpayNotify')->name('weixin_wxpay_notify'); //微信回调
    Route::any('/wxoauth', 'UserController@oauth')->name('weixin_wxoauth');     //微信网页授权
    Route::any('/login', 'UserController@login')->name('weixin_login');
    Route::any('/register', 'UserController@register')->name('weixin_register');
    Route::get('/logout', 'UserController@logout')->name('weixin_user_logout'); //退出
    //页面跳转
	Route::get('/jump', 'IndexController@jump')->name('weixin_jump');
    
	Route::get('/test', 'IndexController@test')->name('weixin_test');           //测试
});

//微信路由，需登录，全局
Route::group(['prefix' => 'weixin', 'namespace' => 'Weixin', 'middleware' => ['web','wxlogin']], function () {
    //个人中心
	Route::get('/user', 'UserController@index')->name('weixin_user');
    Route::get('/userinfo', 'UserController@userinfo')->name('weixin_userinfo');
    Route::get('/user_account', 'UserController@userAccount')->name('weixin_user_account');
    Route::get('/user_money_list', 'UserController@userMoneyList')->name('weixin_user_money_list');
    Route::get('/user_point_list', 'UserController@userPointList')->name('weixin_user_point_list');
    Route::get('/user_message_list', 'UserController@userMessageList')->name('weixin_user_message_list');
    Route::get('/user_distribution', 'UserController@userDistribution')->name('weixin_user_distribution');
    Route::any('/user_withdraw', 'UserController@userWithdraw')->name('weixin_user_withdraw');
    Route::get('/user_withdraw_list', 'UserController@userWithdrawList')->name('weixin_user_withdraw_list');
    //用户充值
    Route::get('/user_recharge', 'UserController@userRecharge')->name('weixin_user_recharge');
    Route::get('/user_recharge_order', 'UserController@userRechargeOrder')->name('weixin_user_recharge_order');
    //优惠券、红包
    Route::get('/user_bonus_list', 'UserController@userBonusList')->name('weixin_user_bonus_list');
    //浏览记录
    Route::get('/user_goods_history', 'UserController@userGoodsHistory')->name('weixin_user_goods_history');
    Route::get('/user_goods_history_delete', 'UserController@userGoodsHistoryDelete')->name('weixin_user_goods_history_delete');
    Route::get('/user_goods_history_clear', 'UserController@userGoodsHistoryClear')->name('weixin_user_goods_history_clear');
    //商品收藏
    Route::get('/collect_goods', 'CollectGoodsController@index')->name('weixin_user_collect_goods');
    //购物车
    Route::get('/cart', 'CartController@index')->name('weixin_cart');
    Route::get('/cart_checkout/{ids}', 'CartController@cartCheckout')->name('weixin_cart_checkout');
    Route::post('/cart_done', 'CartController@cartDone')->name('weixin_cart_done');
    //订单
    Route::get('/order_pay/{id}', 'OrderController@pay')->name('weixin_order_pay'); //订单支付
    Route::post('/order_dopay', 'OrderController@dopay')->name('weixin_order_dopay'); //订单支付
    Route::get('/order_list', 'OrderController@orderList')->name('weixin_order_list'); //全部订单列表
    Route::get('/order_detail', 'OrderController@orderDetail')->name('weixin_order_detail'); //订单详情
    Route::get('/order_wxpay', 'OrderController@orderWxpay')->name('weixin_order_wxpay'); //订单微信支付
    Route::get('/order_yuepay', 'OrderController@orderYuepay')->name('weixin_order_yuepay'); //订单余额支付
    Route::any('/order_comment', 'OrderController@orderComment')->name('weixin_order_comment'); //订单评价
    //收货地址
    Route::get('/user_address', 'AddressController@index')->name('weixin_user_address_list');
    Route::get('/user_address_add', 'AddressController@userAddressAdd')->name('weixin_user_address_add');
    Route::get('/user_address_update', 'AddressController@userAddressUpdate')->name('weixin_user_address_update');
});


//无需token验证，全局
Route::group(['middleware' => ['web']], function () {
    Route::get('/weixin_user_recharge_order_detail', 'Weixin\UserController@userRechargeOrderDetail')->name('weixin_user_recharge_order_detail'); //微信充值支付，为了配合公众号支付授权目录
    Route::post('/dataapi/listarc', 'Api\IndexController@listarc')->name('api_listarc');
    Route::post('/dataapi/customer_login', 'Api\WechatAuthController@customerLogin');
	Route::post('/dataapi/', 'Api\UserController@signin'); //签到
});

//API接口路由，无需token验证
Route::group(['prefix' => 'dataapi', 'namespace' => 'Api', 'middleware' => ['web']], function () {
    //轮播图
	Route::get('/slide_list', 'SlideController@slideList');
    //文章
	Route::get('/article_list', 'ArticleController@articleList');
    Route::get('/article_detail', 'ArticleController@articleDetail');
    Route::get('/arctype_list', 'ArctypeController@arctypeList');
    Route::get('/arctype_detail', 'ArctypeController@arctypeDetail');
    //商品
    Route::get('/goods_detail', 'GoodsController@goodsDetail'); //商品详情
    Route::get('/goods_list', 'GoodsController@goodsList'); //商品列表
    Route::get('/goodstype_list', 'GoodsTypeController@goodsTypeList'); //商品分类列表
    Route::get('/goods_searchword_list', 'GoodsController@goodsSearchwordList'); //商品搜索词列表
    Route::get('/goodsbrand_detail', 'GoodsBrandController@goodsBrandDetail'); //商品品牌详情
    Route::get('/goodsbrand_list', 'GoodsBrandController@goodsBrandList'); //商品品牌列表
    //地区，省市区
	Route::get('/region_list', 'RegionController@regionList');
    Route::get('/region_detail', 'RegionController@regionDetail');
    //用户
	Route::post('/wx_register', 'UserController@wxRegister'); //注册
    Route::post('/wx_login', 'UserController@wxLogin'); //登录
    Route::post('/wx_oauth_register', 'UserController@wxOauthRegister'); //微信授权注册登录
    //可用的优惠券列表
    Route::get('/bonus_list', 'BonusController@bonusList'); //可用获取的优惠券列表
});

//API接口路由，需token验证
Route::group(['prefix' => 'dataapi', 'namespace' => 'Api', 'middleware' => ['web','token']], function () {
    //用户中心
    Route::post('/user_signin', 'UserController@signin'); //签到
    Route::get('/user_info', 'UserController@userInfo'); //用户详细信息
    Route::post('/user_info_update', 'UserController@userInfoUpdate'); //修改用户信息
    Route::post('/user_password_update', 'UserController@userPasswordUpdate'); //修改用户密码、支付密码
    Route::get('/user_list', 'UserController@userList'); //用户列表
    Route::post('/user_money_update', 'UserController@userMoneyUpdate'); //修改用户余额
    //用户充值
    Route::post('/user_recharge_add', 'UserRechargeController@userRechargeAdd');
    Route::get('/user_recharge_detail', 'UserRechargeController@userRechargeDetail');
    Route::get('/user_recharge_list', 'UserRechargeController@userRechargeList');
    //用户余额(钱包)
    Route::get('/user_money_list', 'UserMoneyController@userMoneyList');
    Route::post('/user_money_add', 'UserMoneyController@userMoneyAdd');
    //用户消息
    Route::get('/user_message_list', 'UserMessageController@userMessageList');
    Route::post('/user_message_add', 'UserMessageController@userMessageAdd');
    Route::post('/user_message_update', 'UserMessageController@userMessageUpdate');
    //用户提现
    Route::get('/user_withdraw_list', 'UserWithdrawController@userWithdrawList');
    Route::post('/user_withdraw_add', 'UserWithdrawController@userWithdrawAdd');
    Route::post('/user_withdraw_update', 'UserWithdrawController@userWithdrawUpdate');
    //浏览记录
    Route::get('/user_goods_history_list', 'UserGoodsHistoryController@userGoodsHistoryList'); //我的足迹列表
    Route::post('/user_goods_history_delete', 'UserGoodsHistoryController@userGoodsHistoryDelete'); //我的足迹删除一条
    Route::post('/user_goods_history_clear', 'UserGoodsHistoryController@userGoodsHistoryClear'); //我的足迹清空
    Route::post('/user_goods_history_add', 'UserGoodsHistoryController@userGoodsHistoryAdd'); //我的足迹添加
    //评价
    Route::get('/comment_list', 'CommentController@commentList'); //商品评价列表
    Route::post('/comment_add', 'CommentController@commentAdd'); //商品评价添加
    Route::post('/comment_batch_add', 'CommentController@commentBatchAdd'); //商品评价批量添加
    Route::post('/comment_update', 'CommentController@commentUpdate'); //商品评价修改
    Route::post('/comment_delete', 'CommentController@commentDelete'); //商品评价删除
    //商品收藏
    Route::get('/collect_goods_list', 'CollectGoodsController@collectGoodsList'); //收藏商品列表
    Route::post('/collect_goods_add', 'CollectGoodsController@collectGoodsAdd'); //收藏商品
    Route::post('/collect_goods_delete', 'CollectGoodsController@collectGoodsDelete'); //取消收藏商品
    //订单
    Route::post('/order_add', 'OrderController@orderAdd'); //生成订单
    Route::post('/order_update', 'OrderController@orderUpdate'); //订单修改
    Route::post('/order_status_update', 'OrderController@orderStatusUpdate'); //订单状态修改
    Route::get('/order_list', 'OrderController@orderList'); //订单列表
    Route::get('/order_detail', 'OrderController@orderDetail'); //订单详情
    //购物车
    Route::get('/cart_list', 'CartController@cartList'); //购物车列表
    Route::post('/cart_clear', 'CartController@cartClear'); //清空购物车
    Route::post('/cart_add', 'CartController@cartAdd'); //添加购物车
    Route::post('/cart_delete', 'CartController@cartDelete'); //删除购物
    Route::get('/cart_checkout_goods_list', 'CartController@cartCheckoutGoodsList'); //购物车结算商品列表
    
    //分销
    
    //积分
    Route::get('/user_point_list', 'UserPointController@userPointList'); //用户积分列表
    Route::post('/user_point_add', 'UserPointController@userPointAdd');
    //优惠券
    Route::get('/user_available_bonus_list', 'UserBonusController@userAvailableBonusList'); //用户结算时获取可用优惠券列表
    Route::get('/user_bonus_list', 'UserBonusController@userBonusList'); //用户优惠券列表
    Route::post('/user_bonus_add', 'UserBonusController@userBonusAdd'); //用户获取优惠券
    Route::post('/bonus_add', 'BonusController@bonusAdd'); //添加优惠券
    Route::post('/bonus_update', 'BonusController@bonusUpdate'); //修改优惠券
    Route::post('/bonus_delete', 'BonusController@bonusDelete'); //删除优惠券
    //微信
    
    //意见反馈
    Route::get('/feedback_list', 'FeedBackController@feedbackList');
    Route::post('/feedback_add', 'FeedBackController@feedbackAdd');
    
    //其它
    Route::get('/verifycode_check', 'VerifyCodeController@verifyCodeCheck'); //验证码校验
    Route::get('/andriod_upgrade', 'IndexController@andriodUpgrade'); //安卓升级
    Route::get('/payment_list', 'PaymentController@paymentList'); //支付方式列表
    //图片上传
    Route::post('/image_upload', 'ImageController@imageUpload'); //普通文件/图片上传
    Route::post('/multiple_file_upload', 'ImageController@multipleFileUpload'); //多文件上传
    //二维码
    Route::get('/create_simple_qrcode', 'QrcodeController@createSimpleQrcode');
    //收货地址
    Route::get('/user_address_list', 'UserAddressController@userAddressList');
    Route::get('/user_address_detail', 'UserAddressController@userAddressDetail');
    Route::get('/user_default_address', 'UserAddressController@userDefaultAddress'); //获取用户默认地址
    Route::post('/user_address_setdefault', 'UserAddressController@userAddressSetDefault');
    Route::post('/user_address_add', 'UserAddressController@userAddressAdd');
    Route::post('/user_address_update', 'UserAddressController@userAddressUpdate');
    Route::post('/user_address_delete', 'UserAddressController@userAddressDelete');
});


//后台路由
Route::group(['prefix' => 'fladmin', 'namespace' => 'Admin', 'middleware' => ['web']], function () {
	Route::get('/', 'IndexController@index')->name('admin');
	Route::get('/welcome', 'IndexController@welcome')->name('admin_welcome');
	Route::get('/index/upconfig', 'IndexController@upconfig')->name('admin_index_upconfig'); //更新系统参数配置
	Route::get('/index/upcache', 'IndexController@upcache')->name('admin_index_upcache'); //更新缓存
	//文章
	Route::get('/article', 'ArticleController@index')->name('admin_article');
	Route::get('/article/add', 'ArticleController@add')->name('admin_article_add');
	Route::post('/article/doadd', 'ArticleController@doadd')->name('admin_article_doadd');
	Route::get('/article/edit', 'ArticleController@edit')->name('admin_article_edit');
	Route::post('/article/doedit', 'ArticleController@doedit')->name('admin_article_doedit');
	Route::get('/article/del', 'ArticleController@del')->name('admin_article_del');
	Route::get('/article/repetarc', 'ArticleController@repetarc')->name('admin_article_repetarc');
	Route::get('/article/recommendarc', 'ArticleController@recommendarc')->name('admin_article_recommendarc');
	Route::get('/article/articleexists', 'ArticleController@articleexists')->name('admin_article_articleexists');
	//栏目
	Route::get('/category', 'CategoryController@index')->name('admin_category');
	Route::get('/category/add', 'CategoryController@add')->name('admin_category_add');
	Route::post('/category/doadd', 'CategoryController@doadd')->name('admin_category_doadd');
	Route::get('/category/edit', 'CategoryController@edit')->name('admin_category_edit');
	Route::post('/category/doedit', 'CategoryController@doedit')->name('admin_category_doedit');
	Route::get('/category/del', 'CategoryController@del')->name('admin_category_del');
	//标签
	Route::get('/tag', 'TagController@index')->name('admin_tag');
	Route::get('/tag/add', 'TagController@add')->name('admin_tag_add');
	Route::post('/tag/doadd', 'TagController@doadd')->name('admin_tag_doadd');
	Route::get('/tag/edit', 'TagController@edit')->name('admin_tag_edit');
	Route::post('/tag/doedit', 'TagController@doedit')->name('admin_tag_doedit');
	Route::get('/tag/del', 'TagController@del')->name('admin_tag_del');
	//单页
	Route::get('/page', 'PageController@index')->name('admin_page');
	Route::get('/page/add', 'PageController@add')->name('admin_page_add');
	Route::post('/page/doadd', 'PageController@doadd')->name('admin_page_doadd');
	Route::get('/page/edit', 'PageController@edit')->name('admin_page_edit');
	Route::post('/page/doedit', 'PageController@doedit')->name('admin_page_doedit');
	Route::get('/page/del', 'PageController@del')->name('admin_page_del');
	//产品
	Route::get('/goods', 'GoodsController@index')->name('admin_goods');
	Route::get('/goods/add', 'GoodsController@add')->name('admin_goods_add');
	Route::post('/goods/doadd', 'GoodsController@doadd')->name('admin_goods_doadd');
	Route::get('/goods/edit', 'GoodsController@edit')->name('admin_goods_edit');
	Route::post('/goods/doedit', 'GoodsController@doedit')->name('admin_goods_doedit');
	Route::get('/goods/del', 'GoodsController@del')->name('admin_goods_del');
	Route::get('/goods/recommendarc', 'GoodsController@recommendarc')->name('admin_goods_recommendarc');
	Route::get('/goods/articleexists', 'GoodsController@goodsexists')->name('admin_goods_goodsexists');
	//产品分类
	Route::get('/goodstype', 'GoodsTypeController@index')->name('admin_goodstype');
	Route::get('/goodstype/add', 'GoodsTypeController@add')->name('admin_goodstype_add');
	Route::post('/goodstype/doadd', 'GoodsTypeController@doadd')->name('admin_goodstype_doadd');
	Route::get('/goodstype/edit', 'GoodsTypeController@edit')->name('admin_goodstype_edit');
	Route::post('/goodstype/doedit', 'GoodsTypeController@doedit')->name('admin_goodstype_doedit');
	Route::get('/goodstype/del', 'GoodsTypeController@del')->name('admin_goodstype_del');
    //订单
	Route::get('/order', 'OrderController@index')->name('admin_order');
    Route::get('/order/detail', 'OrderController@detail')->name('admin_order_detail');
	Route::get('/order/edit', 'OrderController@edit')->name('admin_order_edit');
	Route::post('/order/doedit', 'OrderController@doedit')->name('admin_order_doedit');
	Route::get('/order/del', 'OrderController@del')->name('admin_order_del');
    Route::any('/order/output_excel', 'OrderController@outputExcel')->name('admin_order_output_excel');
    Route::post('/order/change_shipping', 'OrderController@changeShipping')->name('admin_order_change_shipping');
    Route::post('/order/change_status', 'OrderController@changeStatus')->name('admin_order_change_status');
    //快递管理
	Route::get('/kuaidi', 'KuaidiController@index')->name('admin_kuaidi');
	Route::any('/kuaidi/add', 'KuaidiController@add')->name('admin_kuaidi_add');
	Route::any('/kuaidi/edit', 'KuaidiController@edit')->name('admin_kuaidi_edit');
	Route::get('/kuaidi/del', 'KuaidiController@del')->name('admin_kuaidi_del');
    //优惠券管理
	Route::get('/bonus', 'BonusController@index')->name('admin_bonus');
	Route::any('/bonus/add', 'BonusController@add')->name('admin_bonus_add');
	Route::any('/bonus/edit', 'BonusController@edit')->name('admin_bonus_edit');
	Route::get('/bonus/del', 'BonusController@del')->name('admin_bonus_del');
    //商品品牌
	Route::get('/goodsbrand', 'GoodsBrandController@index')->name('admin_goodsbrand');
	Route::get('/goodsbrand/add', 'GoodsBrandController@add')->name('admin_goodsbrand_add');
	Route::post('/goodsbrand/doadd', 'GoodsBrandController@doadd')->name('admin_goodsbrand_doadd');
	Route::get('/goodsbrand/edit', 'GoodsBrandController@edit')->name('admin_goodsbrand_edit');
	Route::post('/goodsbrand/doedit', 'GoodsBrandController@doedit')->name('admin_goodsbrand_doedit');
	Route::get('/goodsbrand/del', 'GoodsBrandController@del')->name('admin_goodsbrand_del');
	//友情链接
	Route::get('/friendlink', 'FriendlinkController@index')->name('admin_friendlink');
	Route::get('/friendlink/add', 'FriendlinkController@add')->name('admin_friendlink_add');
	Route::post('/friendlink/doadd', 'FriendlinkController@doadd')->name('admin_friendlink_doadd');
	Route::get('/friendlink/edit', 'FriendlinkController@edit')->name('admin_friendlink_edit');
	Route::post('/friendlink/doedit', 'FriendlinkController@doedit')->name('admin_friendlink_doedit');
	Route::get('/friendlink/del', 'FriendlinkController@del')->name('admin_friendlink_del');
	//关键词管理
	Route::get('/keyword', 'KeywordController@index')->name('admin_keyword');
	Route::get('/keyword/add', 'KeywordController@add')->name('admin_keyword_add');
	Route::post('/keyword/doadd', 'KeywordController@doadd')->name('admin_keyword_doadd');
	Route::get('/keyword/edit', 'KeywordController@edit')->name('admin_keyword_edit');
	Route::post('/keyword/doedit', 'KeywordController@doedit')->name('admin_keyword_doedit');
	Route::get('/keyword/del', 'KeywordController@del')->name('admin_keyword_del');
	//搜索关键词
	Route::get('/searchword', 'SearchwordController@index')->name('admin_searchword');
	Route::get('/searchword/add', 'SearchwordController@add')->name('admin_searchword_add');
	Route::post('/searchword/doadd', 'SearchwordController@doadd')->name('admin_searchword_doadd');
	Route::get('/searchword/edit', 'SearchwordController@edit')->name('admin_searchword_edit');
	Route::post('/searchword/doedit', 'SearchwordController@doedit')->name('admin_searchword_doedit');
	Route::get('/searchword/del', 'SearchwordController@del')->name('admin_searchword_del');
	//幻灯片
	Route::get('/slide', 'SlideController@index')->name('admin_slide');
	Route::get('/slide/add', 'SlideController@add')->name('admin_slide_add');
	Route::post('/slide/doadd', 'SlideController@doadd')->name('admin_slide_doadd');
	Route::get('/slide/edit', 'SlideController@edit')->name('admin_slide_edit');
	Route::post('/slide/doedit', 'SlideController@doedit')->name('admin_slide_doedit');
	Route::get('/slide/del', 'SlideController@del')->name('admin_slide_del');
	//在线留言管理
	Route::get('/guestbook', 'GuestbookController@index')->name('admin_guestbook');
	Route::get('/guestbook/del', 'GuestbookController@del')->name('admin_guestbook_del');
	//系统参数配置
	Route::get('/sysconfig', 'SysconfigController@index')->name('admin_sysconfig');
	Route::get('/sysconfig/add', 'SysconfigController@add')->name('admin_sysconfig_add');
	Route::post('/sysconfig/doadd', 'SysconfigController@doadd')->name('admin_sysconfig_doadd');
	Route::get('/sysconfig/edit', 'SysconfigController@edit')->name('admin_sysconfig_edit');
	Route::post('/sysconfig/doedit', 'SysconfigController@doedit')->name('admin_sysconfig_doedit');
	Route::get('/sysconfig/del', 'SysconfigController@del')->name('admin_sysconfig_del');
    //意见反馈
	Route::get('/feedback', 'FeedbackController@index')->name('admin_feedback');
	Route::get('/feedback/add', 'FeedbackController@add')->name('admin_feedback_add');
	Route::post('/feedback/doadd', 'FeedbackController@doadd')->name('admin_feedback_doadd');
	Route::get('/feedback/edit', 'FeedbackController@edit')->name('admin_feedback_edit');
	Route::post('/feedback/doedit', 'FeedbackController@doedit')->name('admin_feedback_doedit');
	Route::get('/feedback/del', 'FeedbackController@del')->name('admin_feedback_del');
    //会员管理
	Route::get('/user', 'UserController@index')->name('admin_user');
	Route::any('/user/add', 'UserController@add')->name('admin_user_add');
	Route::any('/user/edit', 'UserController@edit')->name('admin_user_edit');
	Route::get('/user/del', 'UserController@del')->name('admin_user_del');
    Route::get('/user/money', 'UserController@money')->name('admin_user_money'); //会员账户记录
    Route::any('/user/manual_recharge', 'UserController@manualRecharge')->name('admin_user_manual_recharge'); //人工充值
    //会员管理
	Route::get('/userrank', 'UserRankController@index')->name('admin_userrank');
	Route::any('/userrank/add', 'UserRankController@add')->name('admin_userrank_add');
	Route::any('/userrank/edit', 'UserRankController@edit')->name('admin_userrank_edit');
	Route::get('/userrank/del', 'UserRankController@del')->name('admin_userrank_del');
    //提现申请
	Route::get('/userwithdraw', 'UserWithdrawController@index')->name('admin_userwithdraw');
	Route::get('/userwithdraw/edit', 'UserWithdrawController@edit')->name('admin_userwithdraw_edit');
	Route::post('/userwithdraw/doedit', 'UserWithdrawController@doedit')->name('admin_userwithdraw_doedit');
    Route::post('/userwithdraw/change_status', 'UserWithdrawController@changeStatus')->name('admin_userwithdraw_change_status');
	//管理员管理
	Route::get('/admin', 'AdminController@index')->name('admin_admin');
	Route::get('/admin/add', 'AdminController@add')->name('admin_admin_add');
	Route::post('/admin/doadd', 'AdminController@doadd')->name('admin_admin_doadd');
	Route::get('/admin/edit', 'AdminController@edit')->name('admin_admin_edit');
	Route::post('/admin/doedit', 'AdminController@doedit')->name('admin_admin_doedit');
	Route::get('/admin/del', 'AdminController@del')->name('admin_admin_del');
	//角色管理
	Route::get('/adminrole', 'AdminRoleController@index')->name('admin_adminrole');
	Route::get('/adminrole/add', 'AdminRoleController@add')->name('admin_adminrole_add');
	Route::post('/adminrole/doadd', 'AdminRoleController@doadd')->name('admin_adminrole_doadd');
	Route::get('/adminrole/edit', 'AdminRoleController@edit')->name('admin_adminrole_edit');
	Route::post('/adminrole/doedit', 'AdminRoleController@doedit')->name('admin_adminrole_doedit');
	Route::get('/adminrole/del', 'AdminRoleController@del')->name('admin_adminrole_del');
	Route::get('/adminrole/permissions', 'AdminRoleController@permissions')->name('admin_adminrole_permissions'); //权限设置
	Route::post('/adminrole/dopermissions', 'AdminRoleController@dopermissions')->name('admin_adminrole_dopermissions');
	//菜单管理
	Route::get('/menu', 'MenuController@index')->name('admin_menu');
	Route::get('/menu/add', 'MenuController@add')->name('admin_menu_add');
	Route::post('/menu/doadd', 'MenuController@doadd')->name('admin_menu_doadd');
	Route::get('/menu/edit', 'MenuController@edit')->name('admin_menu_edit');
	Route::post('/menu/doedit', 'MenuController@doedit')->name('admin_menu_doedit');
	Route::get('/menu/del', 'MenuController@del')->name('admin_menu_del');
    //微信自定义菜单管理
	Route::get('/weixinmenu', 'WeixinMenuController@index')->name('admin_weixinmenu');
	Route::get('/weixinmenu/add', 'WeixinMenuController@add')->name('admin_weixinmenu_add');
	Route::post('/weixinmenu/doadd', 'WeixinMenuController@doadd')->name('admin_weixinmenu_doadd');
	Route::get('/weixinmenu/edit', 'WeixinMenuController@edit')->name('admin_weixinmenu_edit');
	Route::post('/weixinmenu/doedit', 'WeixinMenuController@doedit')->name('admin_weixinmenu_doedit');
	Route::get('/weixinmenu/del', 'WeixinMenuController@del')->name('admin_weixinmenu_del');
    Route::get('/weixinmenu/createmenu', 'WeixinMenuController@createmenu')->name('admin_weixinmenu_createmenu'); //生成自定义菜单
	//后台登录注销
	Route::get('/login', 'LoginController@login')->name('admin_login');
	Route::post('/dologin', 'LoginController@dologin')->name('admin_dologin');
	Route::get('/logout', 'LoginController@logout')->name('admin_logout');
	Route::get('/recoverpwd', 'LoginController@recoverpwd')->name('admin_recoverpwd');
	//页面跳转
	Route::get('/jump', 'LoginController@jump')->name('admin_jump');
	//测试
	Route::get('/test', 'LoginController@test')->name('admin_test');
});