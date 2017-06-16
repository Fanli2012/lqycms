<!DOCTYPE html><html><head><meta http-equiv="Content-Type" content="text/html;charset=UTF-8" /><meta name="viewport" content="width=device-width,initial-scale=1.0">
<title><?php echo $post["seotitle"];if(!empty($_GET["page"])){echo ' '.$_GET["page"];} ?></title>
<meta name="keywords" content="<?php echo $post["keywords"]; ?>"><meta name="description" content="<?php echo $post["description"]; ?>">
<link rel="stylesheet" href="/css/wap.css" media="all"></head><body>

<header class="mheader-a"><h2 class="bt"><?php echo sysconfig('CMS_WEBNAME'); ?></h2><a href="javascript:;"><div class="phone-icon telphone"></div></a></header>

@include('wap.common.header')
<article class="mbanner-b mb10"><a href=""><img src="/images/banner.jpg"></a></article>

<article class="mbox">
<h3 class="tit"><i class="tit_icon"></i><?php echo $post["name"]; ?></h3>
<ul class="mnewpic2"><?php if($posts){foreach($posts as $row){ ?>
<li><a href="<?php echo get_wap_front_url(array("id"=>$row['id'],"type"=>'productdetail')); ?>"><img src="<?php echo sysconfig('CMS_BASEHOST'); echo $row['litpic']; ?>" alt="<?php echo $row['title']; ?>"></a></li><?php }} ?>
</ul><div class="pnav clear"><?php echo $pagenav; ?></div></article>

</body></html>