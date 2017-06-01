<!DOCTYPE html><html><head><meta http-equiv="Content-Type" content="text/html;charset=UTF-8" /><meta http-equiv="Cache-Control" content="no-siteapp" /><meta http-equiv="Cache-Control" content="no-transform" /><meta name="mobile-agent" content="format=xhtml;url=http://m.bnbni.com/cat{dede:type}[field:id/]{/dede:type}/id{dede:field name='aid' /}">
<title><?php if(empty($post["seotitle"])){echo $post["title"];}else{echo $post["seotitle"];} ?>_<?php echo CMS_WEBNAME; ?></title><meta name="keywords" content="<?php echo $post["keywords"]; ?>" /><meta name="description" content="<?php echo $post["description"]; ?>" /><link rel="stylesheet" href="<?php echo CMS_BASEHOST; ?>/images/style.css" media="all"><script type="text/javascript" src="<?php echo CMS_BASEHOST; ?>/js/ad.js"></script><script>uaredirect("http://m.bnbni.com/cat{dede:type}[field:id/]{/dede:type}/id{dede:field name='aid' /}");</script></head><body><script>site();</script>
@include('home.common.header')<div id="tad"><script>tjs();</script></div>

<div class="box mt10">
<h1 class="arct" style="text-align:center"><?php echo $post["title"]; ?></h1><div class="dad1"><script>djs1();</script></div>
<div class="content"><?php echo $post["body"]; ?><div class="dad2"><script>djs2();</script></div></div>
</div><!-- box end -->@include('home.common.footer')</body></html>