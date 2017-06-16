<!DOCTYPE html><html><head><meta http-equiv="Content-Type" content="text/html;charset=UTF-8" /><meta name="viewport" content="width=device-width,initial-scale=1.0">
<title>标签云_<?php echo sysconfig('CMS_WEBNAME'); ?></title><link rel="stylesheet" href="/css/wap.css" media="all"></head><body>

<header class="mheader-a"><h2 class="bt"><?php echo sysconfig('CMS_WEBNAME'); ?></h2><a href="javascript:;"><div class="phone-icon telphone"></div></a></header>

@include('wap.common.header')
<article class="mbanner-b mb10"><a href=""><img src="/images/banner.jpg"></a></article>

<article class="mbox cinfo"><h1 class="tith">标签云</h1>
<div class="mabout-a">
<?php $posts=tagslist(); if($posts){foreach($posts as $row) { ?>
<a target="_blank" href="<?php echo get_front_url(array("tagid"=>$row['id'],"type"=>'tags')); ?>"><?php echo $row['tag']; ?></a>&nbsp;<?php }} ?>
<br><br>
<h2>随机标签</h2>
<?php $posts=tagslist(array("row"=>30,"orderby"=>"rand()")); foreach($posts as $row) { ?>
<a target="_blank" href="<?php echo get_front_url(array("tagid"=>$row['id'],"type"=>'tags')); ?>"><?php echo $row['tag']; ?></a>&nbsp;
<?php } ?>
</div></article>

</body></html>