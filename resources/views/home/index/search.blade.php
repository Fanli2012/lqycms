<!DOCTYPE html><html><head><meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>搜索结果_<?php echo CMS_WEBNAME; ?></title>
<link rel="stylesheet" href="/css/bootstrap.min.css"><link rel="stylesheet" href="/css/style.css"><script src="/js/jquery.min.js"></script><script src="/js/bootstrap.min.js"></script></head><body>

@include('home.common.header')
<div class="container">

      <div class="row row-offcanvas row-offcanvas-right">

<div class="col-xs-12 col-sm-9">
<div class="bread"><a href="/"><?php echo CMS_INDEXNAME; ?></a> > <?php echo '搜索结果'; ?></div>
<h1 class="page-header">搜索结果</h1>

<?php foreach($posts as $row){ ?><div class="list"><?php if(!empty($row['litpic'])){echo '<a class="limg" href="'.get_front_url(array("id"=>$row['id'],"catid"=>$row['typeid'],"type"=>'content')).'"><img alt="'.$row["title"].'" src="'.$row["litpic"].'"></a>';} ?>
<strong class="tit"><a href="<?php echo get_front_url(array("id"=>$row['id'],"catid"=>$row['typeid'],"type"=>'content')); ?>" target="_blank"><?php echo $row['title']; ?></a></strong><p><?php echo mb_strcut($row['description'],0,160,'utf-8'); ?></p>
<div class="info"><span class="fl"><?php $taglist=taglist($row['id']);foreach($taglist as $row){ ?><a target="_blank" href="<?php echo get_front_url(array("tagid"=>$row['id'],"type"=>'tags')); ?>"><?php echo $row['tag']; ?></a><?php } ?><em><?php echo date("Y-m-d",$row["pubdate"]); ?></em></span><span class="fr"><em><?php echo $row['click']; ?></em>人阅读</span></div><div class="cl"></div></div><?php } ?>

<div class="pages"><ul><?php echo $pagenav; ?></ul><div class="cl"></div></div>

</div><!--/.col-xs-12.col-sm-9-->

        <div class="col-xs-12 col-sm-3 sidebar-offcanvas" id="sidebar">
		
		<div class="panel panel-info">
  <div class="panel-heading">热门推荐</div>
  <div class="list-group"><?php $posts=arclist(array("row"=>5,"orderby"=>'rand()'));foreach($posts as $row){ ?>
  <a class="list-group-item" href="<?php echo get_front_url(array("id"=>$row['id'],"catid"=>$row['typeid'],"type"=>'content')); ?>"><?php echo $row['title']; ?></a><?php } ?>
  </div>
</div>
        </div><!--/.sidebar-offcanvas-->
      </div><!--/row-->

</div><!-- /.container -->
@include('home.common.footer')</body></html>