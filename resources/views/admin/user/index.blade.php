<!DOCTYPE html><html><head><title>用户列表_后台管理</title>@include('admin.common.header')
<div class="container-fluid">
<div class="row">
<!-- 左边开始 --><div class="col-sm-3 col-md-2 sidebar">@include('admin.common.leftmenu')</div><!-- 左边结束 -->

<!-- 右边开始 --><div class="col-sm-9 col-md-10 rightbox"><div id="mainbox">
<h2 class="sub-header">用户管理</h2>

<a href="/fladmin/user/edit" class="btn btn-success">修改密码</a>

</div></div><!-- 右边结束 --></div></div>
</body></html>