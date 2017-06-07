<!DOCTYPE html><html><head><title>管理员列表_后台管理</title>@include('admin.common.header')
<div class="container-fluid">
<div class="row">
<!-- 左边开始 --><div class="col-sm-3 col-md-2 sidebar">@include('admin.common.leftmenu')</div><!-- 左边结束 -->

<!-- 右边开始 --><div class="col-sm-9 col-md-10 rightbox"><div id="mainbox">
<h2 class="sub-header">管理员列表</h2>[ <a href="/fladmin/user/add">添加管理员</a> ]<br><br>

<form name="listarc"><div class="table-responsive"><table class="table table-striped table-hover">
<thead><tr>
<th>ID</th>
<th>用户名</th>
<th>邮箱</th>
<th>状态</th>
<th>管理</th>
</tr></thead>
<tbody>
<?php foreach($posts as $row){ ?><tr>
<td><?php echo $row->id; ?></td>
<td><?php echo $row->username; ?></td>
<td><?php echo $row->email; ?></td>
<td><?php if($row->status==0){echo '正常';}elseif($row->status==1){echo '禁用';}elseif($row->status==2){echo '禁用';} ?></td>
<td><a href="/fladmin/user/edit?id=<?php echo $row->id; ?>">权限设置</a> | <a href="/fladmin/user/edit?id=<?php echo $row->id; ?>">修改</a> | <a onclick="delconfirm('/fladmin/user/del?id=<?php echo $row->id; ?>')" href="javascript:;">删除</a></td>
</tr><?php } ?>
</tbody></table></div><!-- 表格结束 --></form><!-- 表单结束 -->

<nav aria-label="Page navigation">{{ $posts->links() }}</nav>

</div></div><!-- 右边结束 --></div></div>
</body></html>