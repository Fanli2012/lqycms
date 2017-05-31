<!DOCTYPE html><html><head><title><?php echo sysconfig('CMS_WEBNAME'); ?>后台管理</title>@include('admin.common.header')
<div class="container-fluid">
<div class="row">
<!-- 左边开始 --><div class="col-sm-3 col-md-2 sidebar">@include('admin.common.leftmenu')</div><!-- 左边结束 -->

<!-- 右边开始 --><div class="col-sm-9 col-md-10 rightbox"><div id="mainbox">
<h2 class="sub-header">LQYCMS管理中心</h2>
<p>· 欢迎使用专业的PHP网站管理系统，轻松建站的首选利器，完全免费、开源、无授权限制。<br>
· LQYCMS采用PHP+Mysql架构，符合企业网站SEO优化理念、功能全面、安全稳定。</p>
<h3>网站基本信息</h3>
域名/IP：<?php echo $_SERVER["SERVER_NAME"]; ?> | <?php echo $_SERVER["REMOTE_ADDR"]; ?><br>
<h3>开发人员</h3>
 FLi、当代范蠡<br><br>
我们的联系方式：374861669@qq.com<br><br>
&copy; LQYCMS 版权所有
</div></div><!-- 右边结束 --></div></div>
</body></html>