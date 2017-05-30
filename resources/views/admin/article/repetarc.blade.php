<!DOCTYPE html><html><head><title>重复文档列表_后台管理</title>@include('admin.common.header')
<div class="container-fluid">
<div class="row">
<!-- 左边开始 --><div class="col-sm-3 col-md-2 sidebar">@include('admin.common.leftmenu')</div><!-- 左边结束 -->

<!-- 右边开始 --><div class="col-sm-9 col-md-10 rightbox"><div id="mainbox">
<h2 class="sub-header">重复文档列表</h2>[ <a href="/fladmin/article">文章列表</a> ] [ <a href="/fladmin/article/add">发布文章</a> ]<br><br>

<form name="listarc">
<div class="table-responsive"><table class="table table-striped table-hover">
<thead><tr>
<th>文档标题</th>
<th>重复数量</th>
</tr></thead>
<tbody>
<?php if($posts){ foreach ($posts as $row) { ?>
<tr>
    <td><a href="/fladmin/article/index?typeid=0&keyword=<?php echo $row["title"]; ?>"><?php echo $row["title"]; ?></a></td>
    <td><?php echo $row["count"]; ?></td>
</tr>
<?php }} ?>
</tbody>
</table></div><!-- 表格结束 --></form><!-- 表单结束 -->

</div></div><!-- 右边结束 --></div></div>
</body></html>