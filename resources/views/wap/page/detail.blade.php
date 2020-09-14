<!DOCTYPE html><html><head><meta http-equiv="Content-Type" content="text/html;charset=UTF-8" /><meta name="viewport" content="width=device-width,initial-scale=1.0">
<title><?php echo $post["title"]; ?>_<?php echo sysconfig('CMS_WEBNAME'); ?></title><link rel="stylesheet" href="/css/wap.css" media="all"></head><body>

<header class="mheader-a"><h2 class="bt"><?php echo sysconfig('CMS_WEBNAME'); ?></h2><a href="javascript:;"><div class="phone-icon telphone"></div></a></header>

@include('wap.common.header')
<article class="mbanner-b mb10"><a href=""><img src="/images/banner.jpg"></a></article>

<article class="mbox cinfo"><h1 class="tith"><?php echo $post["title"]; ?></h1>
<div class="mabout-a"><?php echo $post["body"]; ?></div></article>

</body></html>