<!DOCTYPE html><html><head><meta http-equiv="Content-Type" content="text/html;charset=UTF-8" /><meta name="viewport" content="width=device-width, initial-scale=1">
<title><?php echo $post["title"]; ?>_<?php echo sysconfig('CMS_WEBNAME'); ?></title>
<link rel="stylesheet" href="/css/bootstrap.min.css"><link rel="stylesheet" href="/css/style.css"><script src="/js/jquery.min.js"></script><script src="/js/bootstrap.min.js"></script></head><body>
@include('home.common.header')
<div class="container"><div class="row row-offcanvas row-offcanvas-right"><div class="col-xs-12 col-sm-9">
<div class="bread"><a href=""><?php echo sysconfig('CMS_INDEXNAME'); ?></a> > <?php echo get_cat_path($post["typeid"]); ?></div>
<h1 class="page-header"><?php echo $post["title"]; ?></h1>
<div class="content"><?php echo $post["body"]; ?>
<div class="dinfo"><span class="addtime"><?php echo date("Y-m-d",$post["pubdate"]); ?></span>
<br><br>下一篇：<?php if($pre){ ?><a href="<?php echo get_front_url(array("id"=>$pre['id'],"catid"=>$pre["typeid"],"type"=>'content')); ?>"><?php echo $pre["title"]; ?></a><?php }else{echo '没有了';} ?><div class="cl"></div></div>
</div>
</div><!--/.col-xs-12.col-sm-9-->

<div class="col-xs-12 col-sm-3 sidebar-offcanvas" id="sidebar">
		
<div class="panel panel-info">
  <div class="panel-heading">热门推荐</div>

  <div class="list-group"><?php $posts=arclist(array("row"=>5,"typeid"=>$post['typeid'],"expression"=>[['id', '<', $pre?$pre['id']:$post["id"]]]));if($posts){foreach($posts as $row){ ?>
  <a class="list-group-item" href="<?php echo get_front_url(array("id"=>$row['id'],"catid"=>$row['typeid'],"type"=>'content')); ?>"><?php echo $row['title']; ?></a><?php }} ?>
  </div>
</div>
</div><!--/.sidebar-offcanvas--></div><!--/row--></div><!-- /.container -->
@include('home.common.footer')</body></html>