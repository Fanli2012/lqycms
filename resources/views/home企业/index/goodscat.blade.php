<!DOCTYPE html><html><head><meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?php if(empty($post["seotitle"])){echo $post["name"];}else{echo $post["seotitle"];} ?></title>
<link rel="stylesheet" href="/css/bootstrap.min.css"><link rel="stylesheet" href="/css/style.css"><script src="/js/jquery.min.js"></script><script src="/js/bootstrap.min.js"></script><script src="<?php echo sysconfig('CMS_BASEHOST'); ?>/js/ad.js"></script></head><body>

@include('home.common.header')
<div class="container"><div class="row">
<div class="bread"><a href="<?php echo sysconfig('CMS_BASEHOST'); ?>"><?php echo sysconfig('CMS_INDEXNAME'); ?></a> > <?php echo $post["name"]; ?></div>
<?php if($posts){foreach($posts as $row){ ?>
<div class="col-xs-6 col-sm-3" style="margin-top:20px;margin-bottom:10px;">
<a href="<?php echo get_front_url(array("id"=>$row['id'],"type"=>'productdetail')); ?>" target="_blank">
<img src="<?php echo $row['litpic']; ?>" alt="<?php echo $row['title']; ?>" class="imgzsy">
<p style="padding-top:10px;"><?php echo $row['title']; ?></p>
</a></div><?php }} ?>
<br class="cl">
<div class="pages"><ul><?php echo $pagenav; ?></ul><div class="cl"></div></div>
</div></div><!-- /.container -->
<script>
$(function(){
	$(".imgzsy").height(function(){return $(this).width()*2/3;});
});
</script>
@include('home.common.footer')</body></html>