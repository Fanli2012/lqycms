<!DOCTYPE html><html><head><meta http-equiv="Content-Type" content="text/html;charset=UTF-8" /><meta name="viewport" content="width=device-width,initial-scale=1.0">
<title><?php if(empty($post["title"])){echo $post["tag"];}else{echo $post["title"];} ?></title>
<meta name="keywords" content="<?php echo $post["keywords"]; ?>"><meta name="description" content="<?php echo $post["description"]; ?>">
<link rel="stylesheet" href="/css/wap.css" media="all"></head><body>

<header class="mheader-a"><h2 class="bt"><?php echo sysconfig('CMS_WEBNAME'); ?></h2><a href="javascript:;"><div class="phone-icon telphone"></div></a></header>

@include('wap.common.header')
<article class="mbanner-b mb10"><a href=""><img src="/images/banner.jpg"></a></article>

<article class="mbox">
<h3 class="tit"><i class="tit_icon"></i><?php echo $post["tag"]; ?></h3>
<ul class="mnews-b"><?php foreach($posts as $row){ ?><li><span class="group">[<?php echo date("Y-m-d",$row["pubdate"]); ?>]</span><a href="<?php echo get_front_url(array("id"=>$row['id'],"type"=>'content')); ?>"><?php echo $row['title']; ?></a></li><?php } ?></ul>
<div class="pnav clear"><?php echo $pagenav; ?></div></article>

</body></html>