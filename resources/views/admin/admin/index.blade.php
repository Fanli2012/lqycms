@extends('admin.layouts.app')
@section('title', '管理员列表')

@section('content')
<h2 class="sub-header">管理员列表</h2>[ <a href="<?php echo route('admin_admin_add'); ?>">添加管理员</a> ]<br><br>

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
<td><a href="<?php echo route('admin_admin_edit'); ?>?id=<?php echo $row->id; ?>">修改</a><?php if($row->id<>1){ ?> | <a onclick="delconfirm('<?php echo route('admin_admin_del'); ?>?id=<?php echo $row->id; ?>')" href="javascript:;">删除</a><?php } ?></td>
</tr><?php } ?>
</tbody></table></div><!-- 表格结束 --></form><!-- 表单结束 -->

<nav aria-label="Page navigation">{{ $posts->links() }}</nav>
@endsection