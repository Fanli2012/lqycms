<!DOCTYPE html><html><head><meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
<title><?php echo $post["title"]; ?>_<?php echo sysconfig('CMS_WEBNAME'); ?></title><meta name="keywords" content="{dede:field.keywords/}" /><meta name="description" content="{dede:field.description function='html2text(@me)'/}" /><link rel="stylesheet" href="<?php echo sysconfig('CMS_BASEHOST'); ?>/css/style.css"><script type="text/javascript" src="<?php echo sysconfig('CMS_BASEHOST'); ?>/js/ad.js"></script></head><body>
@include('home.common.header')
<div class="box" style="padding-top:20px;">
<h1 class="page-header" style="text-align:center;"><?php echo $post["title"]; ?></h1>
<div class="content mt10"><?php echo $post["body"]; ?></div>
</div>
@include('home.common.footer')</body></html>