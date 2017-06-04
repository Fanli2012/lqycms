<!DOCTYPE html><html><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1">
<title>您的网站名称</title>
<meta name="description" content="请用一段语句通顺的话来描述您的网站定位，字数不超过200字。">
<meta name="keywords" content="关键词1,关键词2,关键词3,关键词4,关键词5">
<link href="<?php echo sysconfig('CMS_BASEHOST'); ?>/css/bootstrap.css" rel="stylesheet">
<link href="<?php echo sysconfig('CMS_BASEHOST'); ?>/css/style.css" rel="stylesheet">
<script src="<?php echo sysconfig('CMS_BASEHOST'); ?>/js/jquery.min.js"></script>
<link href="<?php echo sysconfig('CMS_BASEHOST'); ?>/css/bxslider.css" rel="stylesheet">
<script src="<?php echo sysconfig('CMS_BASEHOST'); ?>/js/bxslider.min.js"></script>
<script src="<?php echo sysconfig('CMS_BASEHOST'); ?>/js/common.js"></script>
<script src="<?php echo sysconfig('CMS_BASEHOST'); ?>/js/bootstrap.js"></script><link rel="stylesheet" href="css/share_style0_16.css"></head><body>
<script type="text/javascript">try {var urlhash = window.location.hash;if (!urlhash.match("fromapp")){if ((navigator.userAgent.match(/(iPhone|iPod|Android|ios|iPad)/i))){window.location="wap_index.asp";}}}catch(err){}</script>
<link href="<?php echo sysconfig('CMS_BASEHOST'); ?>/css/lanrenzhijia.css" rel="stylesheet" type="text/css">
<script src="<?php echo sysconfig('CMS_BASEHOST'); ?>/js/jquery.KinSlideshow-1.2.1.min.js" type="text/javascript"></script>
<div id="online_qq_layer" style="z-index:1000;"><div id="online_qq_tab"><div class="online_icon"><a title="" id="floatShow" style="display:none" href="javascript:void(0);">&nbsp;</a><a title="" id="floatHide" style="display:block" href="javascript:void(0);">&nbsp;</a></div></div><div id="onlineService" style="display: block;"><div class="online_windows overz"><div class="online_w_top"></div><div class="online_w_c overz"><div class="online_bar expand" id="onlineSort1"><h2><a onclick="changeOnline(1)">在线客服</a></h2><div class="online_content overz" id="onlineType1" style="display: block;"><ul class="overz"><li><a title="点击这里给我发消息" href="http://wpa.qq.com/msgrd?v=3&amp;uin=12345678&amp;site=qq&amp;menu=yes" target="_blank" class="qq_icon">售前咨询</a></li><li><a title="点击这里给我发消息" href="http://wpa.qq.com/msgrd?v=3&amp;uin=987654321&amp;site=qq&amp;menu=yes" target="_blank" class="qq_icon">售后服务</a></li><li><a title="点击这里给我发消息" href="http://wpa.qq.com/msgrd?v=3&amp;uin=11223344&amp;site=qq&amp;menu=yes" target="_blank" class="qq_icon">加盟代理</a></li><li><a title="点击这里给我发消息" href="http://www.taobao.com/webww/ww.php?ver=3&amp;touid=taobao&amp;siteid=cntaobao&amp;status=1&amp;charset=utf-8" target="_blank" class="ww_icon">淘宝客服</a></li></ul></div></div><div class="online_bar collapse2" id="onlineSort2"><h2><a onclick="changeOnline(2)">电话客服</a></h2><div class="online_content overz" id="onlineType2" style="display: none;"><ul class="overz"><li>010-10086</li><li>010-10010</li></ul></div></div><div class="online_bar collapse2" id="onlineSort3"><h2><a onclick="changeOnline(3)">网站二维码</a></h2><div class="online_content overz" id="onlineType3" style="display: none;"><ul class="overz"><img src="images/index.png" width="120"></ul></div></div><div class="online_bar collapse2" id="onlineSort4"><h2><a onclick="changeOnline(4)">微信公众号</a></h2><div class="online_content overz" id="onlineType4" style="display: none;"><ul class="overz"><img src="images/20150921144410012.jpg" width="120"></ul></div></div></div><div class="online_w_bottom"></div></div></div></div>
<div class="toolbar"><a href="" class="toolbar-item toolbar-item-feedback"></a><a href="javascript:scroll(0,0)" class="toolbar-item toolbar-item-top"></a></div>
<link href="css/language-selector.css" rel="stylesheet" type="text/css">
<header>
  <div class="container">
    <div class="row">
      <div class="col-xs-12 col-sm-9 col-md-9"> <a href="/"><img src="<?php echo sysconfig('CMS_BASEHOST'); ?>/images/20160820232652166.png" class="logo" alt=""></a> </div>
      <div id="topsearch" class="col-xs-12 col-sm-3 col-md-3">
        <form id="searchform" name="formsearch" action="" method="post">
        
          <div class="input-group search_group">
            <input type="text" name="keyword" class="form-control input-sm" placeholder="在这里搜索">
            <span class="input-group-btn"> <a href="javascript:searchform.submit();" class="btn btn-sm mysearch_btn" type="button">搜 索</a> </span> </div>
        </form>
      </div>
    </div>
  </div>
  <nav class="navbar navbar-default navbar-static-top">
    <div class="container">
      <div class="navbar-header">
        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar"> <span class="sr-only">Toggle navigation</span> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </button>
        <span id="small_search" class="glyphicon glyphicon-search" aria-hidden="true"></span> <span class="glyphicon glyphicon-home home-btn" style="cursor: pointer"></span> <a class="navbar-brand" href="<?php echo sysconfig('CMS_BASEHOST'); ?>/">导航菜单</a> </div>
      <div id="navbar" class="navbar-collapse collapse">
        <ul class="nav navbar-nav"><li class="dropdown"> <a href="<?php echo sysconfig('CMS_BASEHOST'); ?>/">网站首页</a></li>
		<li class="dropdown"> <a href="<?php echo route('productcat', ['cat'=>1]); ?>">产品展示</a></li>
		<li class="dropdown"> <a href="<?php echo route('home_category', ['cat'=>2]); ?>">案例中心</a></li>
		<li class="dropdown"> <a href="<?php echo route('home_category', ['cat'=>1]); ?>">新闻中心</a></li>
		<li class="dropdown"> <a href="<?php echo route('singlepage', ['id'=>'contact']); ?>">联系我们</a></li></ul>
      </div>
       
    </div>
  </nav>
<div class="flash">
    <ul class="bxslider"><li><a href="#"><img src="<?php echo sysconfig('CMS_BASEHOST'); ?>/images/20161108163633172.jpg" /></a></li><li><a href="#"><img src="<?php echo sysconfig('CMS_BASEHOST'); ?>/images/20161108163616914.jpg" /></a></li></ul>
</div>
<script type="text/javascript">
$('.bxslider').bxSlider({
	adaptiveHeight: true,
	infiniteLoop: true,
	hideControlOnEnd: true,
	auto:true
});
</script>
</header>

<div class="container">
  <div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12">
	    <div class="about_box">        <h1 class="about_h1">公司简介</h1>        <span class="about_span">Itroduction</span>        <section>        <img align="left" src="/images/20161108163706251.png" alt="公司简介">        <p class="about_contents"> XXX有限公司是于1966年为了通过试验评价技术的支援以提高产业技术而成 立的试验评价机构,是和先进（发达）国家的试验、认证机构进行交流和合作的大韩民国代表性机构。为了保护本国产业的各种认证制度日渐完善,为保护消费者安 全和环境的各种制度的重要性日趋增加,KTL为适应形势的发展,从产品开发到获得认证的整个阶段提供支援,以帮助企业提高技术能力以及拥有更强的竞争力。为了两国企业间和认证机构和客户间的有..</p>        <a href="/page/about" class="about_more">查看详细 &gt;&gt;</a>        <section>      </section></section></div>
    </div>
  </div>
</div>
<div class="container">
  <div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12">
      <div class="index_product">
        <h1 class="about_h1">产品展示</h1>
        <span class="about_span">PRODUCT DISPLAY</span>
        <div class="product_list">
<?php $posts=dataList('product',array("row"=>4));if($posts){foreach($posts as $row){ ?>
<div class="col-sm-4 col-md-3 col-mm-6 product_img"><a href="<?php echo route('product',['id'=>$row['id']]); ?>"> <img src="<?php echo $row['litpic']; ?>" style="width: 261px;" class="opacity_img" alt="<?php echo $row['title']; ?>"></a><p class="product_title"><a href="/product<?php echo $row['typeid']; ?>/id<?php echo $row['id']; ?>"></a></p></div>
<?php }} ?>
 </div>
      </div>
    </div>
  </div>
</div>
<div class="container">
  <div class="row">
    <div class="col-xs-12 col-sm-8 col-md-7">
      <div class="news_box">
        <h1 class="about_h1">新闻中心</h1>
        <span class="about_span">NEWS CENTER</span>
        <ul class="index_news">
<?php $posts=arclist(array("row"=>6,"tuijian"=>array('<>',1)));foreach($posts as $row){ ?>
<li><a href="<?php echo route('home_detail',['id'=>$row['id']]); ?>"><?php echo $row['title']; ?></a><span class="news_time"><?php echo date('Y-m-d',$row['pubdate']); ?></span></li>
<?php } ?>
        </ul>
      </div>
    </div>
    <div class="col-xs-12 col-sm-4 col-md-5">
      <div class="index_contact">
        <h1 class="about_h1">联系我们</h1>
        <span class="about_span">CONTACT US</span>
        <p style="padding-top:20px;">地址：上海市xx区xx路xx广场x号<br>
电话：86-021-xxxxxxxx<br>
传真：86-021-xxxxxxxxxxxxxxxx<br>
邮箱：xxxxxxxxx@qq.com<br>
网址：www.xxxxxx.com<br></p>
        </div>
    </div>
  </div>
</div>

<nav class="navbar navbar-default navbar-fixed-bottom footer_nav">
  <div class="foot_nav btn-group dropup"> <a class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" href="http://s66.demo.s-cms.cn/#"> <span class="glyphicon glyphicon-share btn-lg" aria-hidden="true"></span> 分享</a>
    <div class="dropdown-menu webshare">
      <div class="bdsharebuttonbox bdshare-button-style0-16" style="display: inline-block" data-bd-bind="1482888324373"><a href="http://s66.demo.s-cms.cn/#" class="bds_more" data-cmd="more"></a><a href="http://s66.demo.s-cms.cn/#" class="bds_qzone" data-cmd="qzone" title="分享到QQ空间"></a><a href="http://s66.demo.s-cms.cn/#" class="bds_tsina" data-cmd="tsina" title="分享到新浪微博"></a><a href="http://s66.demo.s-cms.cn/#" class="bds_tqq" data-cmd="tqq" title="分享到腾讯微博"></a><a href="http://s66.demo.s-cms.cn/#" class="bds_renren" data-cmd="renren" title="分享到人人网"></a><a href="http://s66.demo.s-cms.cn/#" class="bds_weixin" data-cmd="weixin" title="分享到微信"></a></div>
    </div>
  </div>
  <div class="foot_nav"><a href="tel:"><span class="glyphicon glyphicon-phone btn-lg" aria-hidden="true"></span>手机</a></div>
  <div class="foot_nav"><a id="gotocate" href="http://s66.demo.s-cms.cn/#"><span class="glyphicon glyphicon-th-list btn-lg" aria-hidden="true"></span>分类</a></div>
  <div class="foot_nav"><a id="gototop" href="http://s66.demo.s-cms.cn/#"><span class="glyphicon glyphicon-circle-arrow-up btn-lg" aria-hidden="true"></span>顶部</a></div>
</nav>
<footer>
  <div class="copyright">
    <p>COPYRIGHT © 2009-2011,WWW.YOURNAME.COM,ALL RIGHTS RESERVED版权所有 © 您的公司名称</p>
    <p class="copyright_p"><a href="http://www.51.la/?18651498" target="_blank" title="51.La 网站流量统计系统">站长统计</a></p>
  </div>
</footer>
<link rel="stylesheet" type="text/css" href="css/online.css">
</body></html>