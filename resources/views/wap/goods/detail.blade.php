<!DOCTYPE html><html><head><meta http-equiv="Content-Type" content="text/html;charset=UTF-8" /><meta name="viewport" content="width=device-width,initial-scale=1.0">
<title><?php echo $post["title"]; ?>_<?php echo sysconfig('CMS_WEBNAME'); ?></title><link rel="stylesheet" href="/css/wap.css" media="all"><script type="text/javascript" src="/js/jquery.min.js"></script></head><body>

<header class="mheader-a"><h2 class="bt"><?php echo sysconfig('CMS_WEBNAME'); ?></h2><a href="javascript:;"><div class="phone-icon telphone"></div></a></header>

@include('wap.common.header')
<article class="mbanner-b mb10"><a href=""><img src="/images/banner.jpg"></a></article>

<article class="mbox cinfo"><h1 class="tith"><?php echo $post["title"]; ?></h1>
<div class="mabout-a"><p><strong>价格</strong>：<?php echo $post["price"]; ?></p>
<p><strong>原价</strong>：<del><?php echo $post["origin_price"]; ?></del></p>
<p><strong>销量</strong>：<?php echo $post["sales"]; ?></p>
<?php echo $post["body"]; ?>
<br>下一篇：<?php if($pre){ ?><a href="<?php echo get_front_url(array("id"=>$pre['id'],"type"=>'productdetail')); ?>"><?php echo $pre["title"]; ?></a><?php }else{echo '没有了';} ?></div></article>

</body></html>