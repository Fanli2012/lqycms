<div class="navbar-wrapper">
  <div class="container">
	<nav class="navbar navbar-inverse navbar-static-top">
	  <div class="container">
		<div class="navbar-header">
		  <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
		  </button>
		  <a class="navbar-brand" href="<?php echo sysconfig('CMS_BASEHOST'); ?>">首页</a>
		</div>
		<div id="navbar" class="navbar-collapse collapse">
		  <ul class="nav navbar-nav">
			<li><a href="<?php echo get_front_url(array('catid'=>4,'type'=>'list')); ?>">新闻动态</a></li>
            <li><a href="<?php echo get_front_url(array('catid'=>2,'type'=>'list')); ?>">案例中心</a></li>
			<li><a href="<?php echo get_front_url(array('pagename'=>'contact','type'=>'page')); ?>">联系我们</a></li>
			<li class="dropdown">
			  <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">关于我们 <span class="caret"></span></a>
			  <ul class="dropdown-menu">
				<li><a href="<?php echo get_front_url(array('pagename'=>'about','type'=>'page')); ?>">公司简介</a></li>
				<li><a href="<?php echo get_front_url(array('pagename'=>'culture','type'=>'page')); ?>">企业文化</a></li>
			  </ul>
			</li>
		  </ul>
		</div>
	  </div>
	</nav>
  </div>
</div>

<div class="jumbotron banner"><div class="container">
<h1>全球最大的中文搜索引擎</h1>
<p>中国最具价值的品牌之一，英国《金融时报》将百度列为“中国十大世界级品牌”，成为这个榜单中最年轻的一家公司，也是唯一一家互联网公司。</p>
<p><a class="btn btn-success btn-lg" href="<?php echo get_front_url(array('pagename'=>'about','type'=>'page')); ?>" role="button">阅读更多...</a></p>
</div></div>