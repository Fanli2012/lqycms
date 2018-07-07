@extends('admin.layouts.app')
@section('title', '角色管理')

@section('content')
<h2 class="sub-header">角色管理</h2>[ <a href="<?php echo route('admin_adminrole_add'); ?>">添加角色</a> ]<br><br>

<form name="listarc"><div class="table-responsive"><table class="table table-striped table-hover">
<thead><tr class="info">
<th>ID</th>
<th>角色名称</th>
<th>角色描述</th>
<th>状态</th>
<th>管理</th>
</tr></thead>
<tbody>
<?php if($posts){foreach($posts as $row){ ?><tr>
<td><?php echo $row->id; ?></td>
<td><?php echo $row->name; ?></td>
<td><?php echo $row->des; ?></td>
<td><?php echo $row->status_text; ?></td>
<td><?php if($row->id<>1){ ?><a href="<?php echo route('admin_adminrole_permissions'); ?>?id=<?php echo $row->id; ?>">权限设置</a> | <?php } ?><a href="<?php echo route('admin_adminrole_edit'); ?>?id=<?php echo $row->id; ?>">修改</a><?php if($row->id<>1){ ?> | <a onclick="delconfirm('<?php echo route('admin_adminrole_del'); ?>?id=<?php echo $row->id; ?>')" href="javascript:;">删除</a><?php } ?></td>
</tr><?php }} ?>
</tbody></table></div><!-- 表格结束 --></form><!-- 表单结束 -->

<nav aria-label="Page navigation">{{ $posts->links() }}</nav>
@endsection