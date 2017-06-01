<!DOCTYPE html><html><head><meta http-equiv="Content-Type" content="text/html;charset=UTF-8" /><meta http-equiv="Cache-Control" content="no-siteapp" /><meta http-equiv="Cache-Control" content="no-transform" /><meta name="mobile-agent" content="format=xhtml;url=http://m.bnbni.com/cat{dede:type}[field:id/]{/dede:type}/id{dede:field name='aid' /}">
<title>笔记本电脑相关知识_<?php echo sysconfig('CMS_WEBNAME'); ?></title><meta name="keywords" content="" /><meta name="description" content="" /><link rel="stylesheet" href="<?php echo CMS_BASEHOST; ?>/images/style.css" media="all"><script type="text/javascript" src="<?php echo CMS_BASEHOST; ?>/js/ad.js"></script><script>uaredirect("http://m.bnbni.com/cat{dede:type}[field:id/]{/dede:type}/id{dede:field name='aid' /}");</script></head><body><script>site();</script>
@include('home.common.header')<div id="tad"><script>tjs();</script></div>
<div class="box mt10">
<div class="ws-tag"><?php $posts=tagslist(); foreach($posts as $row) { ?>
<a target="_blank" href="<?php echo get_front_url(array("type"=>"tags","tagid"=>$row["id"])); ?>"><?php echo $row['tag']; ?></a>&nbsp;<?php } ?></div>
</div><!-- box end -->@include('home.common.footer')</body></html>