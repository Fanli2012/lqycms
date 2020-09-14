<nav class="mnav-a"><ul class="mnav-m">
<li><a href="/" class="<?php if(route('wap_home') == url()->full()){echo ' cur';} ?>">首页</a></li>
<li><a href="<?php echo get_wap_front_url(array('pagename'=>'about','type'=>'page')); ?>" class="<?php if(get_wap_front_url(array('pagename'=>'about','type'=>'page')) == $_SERVER['REQUEST_URI']){echo ' cur';} ?>">关于我们</a></li>
<li><a href="<?php echo get_wap_front_url(array('catid'=>4,'type'=>'list')); ?>" class="<?php if(get_wap_front_url(array('catid'=>4,'type'=>'list')) == $_SERVER['REQUEST_URI']){echo ' cur';} ?>">新闻中心</a></li>
<li><a href="<?php echo get_wap_front_url(array('pagename'=>'contact','type'=>'page')); ?>" class="<?php if(get_wap_front_url(array('pagename'=>'contact','type'=>'page')) == $_SERVER['REQUEST_URI']){echo ' cur';} ?>">联系我们</a></li>
</ul></nav>