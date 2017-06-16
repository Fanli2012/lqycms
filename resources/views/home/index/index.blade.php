<!DOCTYPE html><html><head><meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1"><link href="<?php echo sysconfig('CMS_BASEHOST'); ?>/favicon.ico" type="image/x-icon" rel="shortcut icon">
<title><?php echo sysconfig('CMS_WEBNAME'); ?></title>
<link rel="stylesheet" href="<?php echo sysconfig('CMS_BASEHOST'); ?>/css/bootstrap.min.css"><link rel="stylesheet" href="<?php echo sysconfig('CMS_BASEHOST'); ?>/css/style.css"><script src="<?php echo sysconfig('CMS_BASEHOST'); ?>/js/jquery.min.js"></script><script src="<?php echo sysconfig('CMS_BASEHOST'); ?>/js/bootstrap.min.js"></script><script src="<?php echo sysconfig('CMS_BASEHOST'); ?>/js/ad.js"></script></head><body>

@include('home.common.header')
<div class="container marketing">
    <div class="row">
        <div class="col-lg-4">
            <img class="img-circle" src="<?php echo sysconfig('CMS_BASEHOST'); ?>/images/1.jpg" alt="Generic placeholder image" width="140" height="140">
            <h2>网页搜索</h2>
            <p>作为全球最大的中文搜索引擎公司，百度一直致力于让网民更便捷地获取信息，</p>
            <p><a class="btn btn-default" href="<?php echo get_front_url(array("id"=>1,"type"=>'content')); ?>" role="button">更多详情 &raquo;</a></p>
        </div><!-- /.col-lg-4 -->
        <div class="col-lg-4">
            <img class="img-circle" src="<?php echo sysconfig('CMS_BASEHOST'); ?>/images/3.jpg" alt="Generic placeholder image" width="140" height="140">
            <h2>社区产品</h2>
            <p>信息获取的最快捷方式是人与人直接交流，为了让那些对同一个话题感兴趣的人们聚集在一起。</p>
            <p><a class="btn btn-default" href="<?php echo get_front_url(array("id"=>2,"type"=>'content')); ?>" role="button">更多详情 &raquo;</a></p>
        </div><!-- /.col-lg-4 -->
        <div class="col-lg-4">
            <img class="img-circle" src="<?php echo sysconfig('CMS_BASEHOST'); ?>/images/4.jpg" alt="Generic placeholder image" width="140" height="140">
            <h2>电子商务</h2>
            <p>基于百度独有的搜索技术和强大社区资源，百度有啊突破性实现了网络交易和网络社区的无缝结合。</p>
            <p><a class="btn btn-default" href="<?php echo get_front_url(array("id"=>3,"type"=>'content')); ?>" role="button">更多详情 &raquo;</a></p>
        </div><!-- /.col-lg-4 -->
    </div><!-- /.row -->

    <!-- START THE FEATURETTES -->
    <hr class="featurette-divider">

      <div class="row featurette">
        <div class="col-md-7">
          <h2 class="featurette-heading"> <span class="text-muted">主营业务</span></h2>
          <p class="lead">作为全球最大的中文搜索引擎公司，百度一直致力于让网民更便捷地获取信息，找到所求。用户通过百度主页，可以瞬间找到相关的搜索结果，
这些结果来自于百度超过百亿的中文网页数据库。</p>
        </div>
        <div class="col-md-5">
          <img class="featurette-image img-responsive center-block" src="<?php echo sysconfig('CMS_BASEHOST'); ?>/images/applead.png" alt="Generic placeholder image">
        </div>
      </div>

      <hr class="featurette-divider">

      <div class="row featurette">
        <div class="col-md-7 col-md-push-5">
          <h2 class="featurette-heading">人才理念 <span class="text-muted"></span></h2>
          <p class="lead">对于一个人才，我们更多注重的是，你能不能够创造，为自身创造价值，给用户带来更好的体验，这是百度所关心的，所看重的。——李彦宏</p>
        </div>
        <div class="col-md-5 col-md-pull-7">
          <img class="featurette-image img-responsive center-block" src="<?php echo sysconfig('CMS_BASEHOST'); ?>/images/applead.png" alt="Generic placeholder image">
        </div>
      </div>

      <hr class="featurette-divider">

      <div class="row featurette">
        <div class="col-md-7">
          <h2 class="featurette-heading">联系我们 <span class="text-muted"></span></h2>
          <p class="lead">地址：北京市海淀区上地十街10号百度大厦，邮编：100085，总机：(+86 10) 5992 8888</p>
        </div>
        <div class="col-md-5">
          <img class="featurette-image img-responsive center-block" src="<?php echo sysconfig('CMS_BASEHOST'); ?>/images/applead.png" alt="Generic placeholder image">
        </div>
      </div>

      <hr class="featurette-divider">

      <div class="row">
      <?php $posts=arclist(array("row"=>3,"tuijian"=>1,"typeid"=>4));foreach($posts as $row){ ?>
        <div class="col-lg-4">
          <h2><?php echo $row['title']; ?></h2>
          <p><?php echo mb_strcut($row['description'],0,150,'UTF-8'); ?></p>
          <p><a class="btn btn-primary" href="<?php echo get_front_url(array("id"=>$row['id'],"catid"=>$row['typeid'],"type"=>'content')); ?>" role="button">View details &raquo;</a></p>
        </div><?php } ?>
      </div>
	  
<div class="bs-docs-featurette">
<div class="container">
<h2 class="bs-docs-featurette-title">案例中心/Case Show</h2>
<p class="lead">我们在这里展示了许多精美的案例，欢迎欣赏。</p>

<hr class="half-rule">
	
<div class="row">
    <?php $posts=arclist(array("row"=>4,"tuijian"=>1,"typeid"=>2,"expression"=>[["litpic","<>","''"]]));foreach($posts as $row){ ?>
    <div class="col-xs-6 col-sm-3" style="margin-bottom:15px;">
    <a href="<?php echo get_front_url(array("id"=>$row['id'],"catid"=>$row['typeid'],"type"=>'content')); ?>">
    <img src="<?php echo $row['litpic']; ?>" alt="<?php echo $row['title']; ?>" class="imgzsy">
    </a>
    </div>
    <?php } ?>
</div>
</div>
</div>

<!-- <div class="searchbox row" style="text-align:center;padding-bottom:50px;">
<form class="form-inline" method="get" action="/search" role="form">
<div class="form-group">
<input type="text" class="form-control" id="keyword" name="keyword" placeholder="请输入关键词...">
</div>
<button type="submit" class="btn btn-success">搜索一下</button>
</form>
</div> -->

<div class="row">
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;友情链接：
<?php $posts=arclist(array("table"=>"friendlink","row"=>5));foreach($posts as $row){ ?>
<a href="<?php echo $row['url']; ?>"><?php echo $row['webname']; ?></a>&nbsp;
<?php } ?></div>
</div><!-- /.container -->
<script>
$(function(){
	$(".imgzsy").height(function(){return $(this).width()*2/3;});
});
</script>
@include('home.common.footer')</body></html>