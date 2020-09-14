<meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="<?php echo route('home'); ?>/css/bootstrap.min.css"><link rel="stylesheet" href="<?php echo route('home'); ?>/css/admin.css">
<script src="<?php echo route('home'); ?>/js/jquery.min.js"></script><script src="/js/ad.js"></script><script src="<?php echo route('home'); ?>/js/bootstrap.min.js"></script><script type="text/javascript" src="<?php echo route('home'); ?>/js/jquery.uploadify.min.js"></script></head><body>

<div class="blog-masthead clearfix"><nav class="blog-nav">
<a class="blog-nav-item active" href="<?php echo route('admin'); ?>"><span class="glyphicon glyphicon-star"></span> <strong>后台管理中心</strong> <span class="glyphicon glyphicon-star-empty"></span></a>
<a class="blog-nav-item" href="<?php echo route('home'); ?>" target="_blank"><span class="glyphicon glyphicon-home"></span> 网站主页</a>
<a class="blog-nav-item" href="<?php echo route('admin'); ?>/index/upcache"><span class="glyphicon glyphicon-refresh"></span> 更新缓存</a>
<a class="blog-nav-item" id="navexit" href="<?php echo route('admin_logout'); ?>"><span class="glyphicon glyphicon-off"></span> 注销</a>
<a class="blog-nav-item pull-right" href="javascript:;"><small>您好：<span class="glyphicon glyphicon-user"></span> <?php if(isset($_SESSION['admin_info'])){echo $_SESSION['admin_info']['user'].' ['.$_SESSION['admin_user_info']['rolename'].']';} ?></small></a>
</nav></div>