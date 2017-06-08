<script type="text/javascript">
$(document).ready(function() {
	$('.inactive').click(function(){
		var className=$(this).parents('li').parents().attr('class');
		if($(this).siblings('ul').css('display')=='none'){
			if(className=="yiji"){
				$(this).parents('li').siblings('li').children('ul').parent('li').children('a').removeClass('inactives');
				$(this).parents('li').siblings('li').children('ul').slideUp(100);
				$(this).parents('li').children('ul').children('li').children('ul').parent('li').children('a').removeClass('inactives');
				$(this).parents('li').children('ul').children('li').children('ul').slideUp(100);
			}
			$(this).addClass('inactives');
			$(this).siblings('ul').slideDown(100);
		}else{
			$(this).removeClass('inactives');
			$(this).siblings('ul').slideUp(100);
		}
	})
});
</script>
<style type="text/css">
.list ul{padding:0;}
.list ul li{background-color:#467ca2; border:solid 1px #316a91; border-bottom:0;}
.list ul li a{padding-left:20px;color:#fff;display:block;height:40px;line-height:40px;position:relative;}
.list ul li .inactive{background:url(/images/off.png) no-repeat 90% center;}
.list ul li .inactives{background:url(/images/on.png) no-repeat 90% center;} 
.list ul li ul{display:none;padding:0;}
.list ul li ul li {border-left:0; border-right:0; background-color:#6196bb; border-color:#467ca2;}
.list ul li ul li ul{display:none;padding:0;}
.list ul li ul li a{padding-left:40px;}
.list ul li ul li ul li {background-color:#d6e6f1; border-color:#6196bb; }
.last{background-color:#d6e6f1; border-color:#6196bb; }
.list ul li ul li ul li a{color:#316a91; padding-left:60px;}
</style>

<div class="list">
        <ul class="yiji">
            <li><a href="#">中国美协章程</a></li>
            <li><a href="#" class="inactive active">常用操作</a>
                <ul>
                    <li><a href="#"><small class="glyphicon glyphicon-triangle-right"></small> 网站栏目管理</a></li>
                    <li><a href="#"><small class="glyphicon glyphicon-triangle-right"></small> 文章列表</a></li>
                    <li><a href="#"><small class="glyphicon glyphicon-triangle-right"></small> 未审核的文章</a></li>
                    <li><a href="#"><small class="glyphicon glyphicon-triangle-right"></small> 发布文章</a></li>
                    <li><a href="#"><small class="glyphicon glyphicon-triangle-right"></small> 单页文档管理</a></li>
                </ul>
            </li>
			<li><a href="#" class="inactive active">商品管理</a>
                <ul>
                    <li><a href="#">商品列表</a></li>
                    <li><a href="#">添加商品</a></li>
                    <li><a href="#">商品分类</a></li>
                </ul>
            </li>
            <li><a href="#" class="inactive">组织机构</a>
                <ul style="display: none">
                    <li><a href="#" class="inactive active"><small class="glyphicon glyphicon-triangle-right"></small> 美协机关</a>
                        <ul>
                            <li><a href="#"><small class="glyphicon glyphicon-menu-right"></small> 办公室</a></li>
                            <li><a href="#"><small class="glyphicon glyphicon-menu-right"></small> 人事处</a></li>
                            <li><a href="#"><small class="glyphicon glyphicon-menu-right"></small> 组联部</a></li>
                            <li><a href="#"><small class="glyphicon glyphicon-menu-right"></small> 外联部</a></li>
                            <li><a href="#"><small class="glyphicon glyphicon-menu-right"></small> 研究部</a></li>
                            <li><a href="#"><small class="glyphicon glyphicon-menu-right"></small> 维权办</a></li>
                        </ul>
                    </li> 
                    <li><a href="#" class="inactive active"><small class="glyphicon glyphicon-triangle-right"></small> 中国文联美术艺术中心</a>   
                        <ul>
                            <li><a href="#">综合部</a></li>
                            <li><a href="#">大型活动部</a></li>
                            <li><a href="#">展览部</a></li>
                            <li><a href="#">艺委会工作部</a></li>
                            <li><a href="#">信息资源部</a></li>
                            <li><a href="#">双年展办公室</a></li>
                        </ul>
                    </li>
                    <li class="last"><a href="#"><small class="glyphicon glyphicon-triangle-right"></small> 《美术》杂志社</a></li>
                </ul>
            </li>


            <li><a href="#" class="inactive">组织机构</a>
                <ul style="display: none">
                    <li><a href="#" class="inactive active">美协机关</a>
                        <ul>
                            <li><a href="#">办公室</a></li>
                            <li><a href="#">人事处</a></li>
                            <li><a href="#">组联部</a></li>
                            <li><a href="#">外联部</a></li>
                            <li><a href="#">研究部</a></li>
                            <li><a href="#">维权办</a></li>
                        </ul>
                    </li>
                    <li><a href="#" class="inactive active">中国文联美术艺术中心</a>
                        <ul>
                            <li><a href="#">综合部</a></li>
                            <li><a href="#">大型活动部</a></li>
                            <li><a href="#">展览部</a></li>
                            <li><a href="#">艺委会工作部</a></li>
                            <li><a href="#">信息资源部</a></li>
                            <li><a href="#">双年展办公室</a></li>
                        </ul>
                    </li>
                    <li class="last"><a href="#">《美术》杂志社</a></li>
                </ul>
            </li>
        </ul>
</div>
<dl class="lnav">
<dt>常用操作</dt>
<dd><a href="<?php echo route('admin'); ?>/category"><span class="glyphicon glyphicon-th-list"></span> 网站栏目管理</a></dd>
<dd><a href="<?php echo route('admin'); ?>/article"><span class="glyphicon glyphicon-pencil"></span> 文章列表</a></dd>
<dd><a href="<?php echo route('admin'); ?>/article?ischeck=1"><span class="glyphicon glyphicon-pencil"></span> 未审核的文章</a></dd>
<dd><a href="<?php echo route('admin'); ?>/article/add"><span class="glyphicon glyphicon-file"></span> 发布文章</a></dd>
<dd><a href="<?php echo route('admin'); ?>/page"><span class="glyphicon glyphicon-equalizer"></span> 单页文档管理</a></dd>
<dt>商品管理</dt>
<dd><a href="<?php echo route('admin'); ?>/product"><span class="glyphicon glyphicon-pencil"></span> 商品列表</a></dd>
<dd><a href="<?php echo route('admin'); ?>/product/add"><span class="glyphicon glyphicon-file"></span> 添加商品</a></dd>
<dd><a href="<?php echo route('admin'); ?>/producttype"><span class="glyphicon glyphicon-th-list"></span> 商品分类</a></dd>
<dt>批量维护</dt>
<dd><a href="<?php echo route('admin'); ?>/tag"><span class="glyphicon glyphicon-tag"></span> TAG标签管理</a></dd>
<dd><a href="<?php echo route('admin'); ?>/searchword"><span class="glyphicon glyphicon-fire"></span> 关键词管理</a></dd>
<dd><a href="<?php echo route('admin'); ?>/keyword"><span class="glyphicon glyphicon-fire"></span> 內链关键词维护</a></dd>
<dd><a href="<?php echo route('admin'); ?>/friendlink"><span class="glyphicon glyphicon-leaf"></span> 友情链接</a></dd>
<dd><a href="<?php echo route('admin'); ?>/slide"><span class="glyphicon glyphicon-leaf"></span> 轮播图</a></dd>
<dd><a href="<?php echo route('admin'); ?>/article/repetarc"><span class="glyphicon glyphicon-cog"></span> 重复文档检测</a></dd>
<dd><a href="<?php echo route('admin'); ?>/menu"><span class="glyphicon glyphicon-fire"></span> 菜单管理</a></dd>
<dt>用户管理</dt>
<dd><a href="<?php echo route('admin'); ?>/userrole"><span class="glyphicon glyphicon-pencil"></span> 角色管理</a></dd>
<dd><a href="<?php echo route('admin'); ?>/user"><span class="glyphicon glyphicon-user"></span> 管理员</a></dd>
<dt>系统设置</dt>
<dd><a href="<?php echo route('admin'); ?>/sysconfig"><span class="glyphicon glyphicon-wrench"></span> 系统基本参数</a></dd>
<dd><a href="<?php echo route('admin'); ?>/index/upcache"><span class="glyphicon glyphicon-refresh"></span> 更新缓存</a></dd>
<dd><a href="<?php echo route('admin'); ?>/guestbook"><span class="glyphicon glyphicon-wrench"></span> 所有留言</a></dd>
<dd><a href="<?php echo route('admin'); ?>/sysconfig" target="_blank"><span class="glyphicon glyphicon-book"></span> 参考文档</a></dd>
<dd><a href="<?php echo route('admin'); ?>/sysconfig" target="_blank"><span class="glyphicon glyphicon-envelope"></span> 意见反馈/官方交流</a></dd>
</dl>