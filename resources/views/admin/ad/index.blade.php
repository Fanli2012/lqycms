@extends('admin.layouts.app')
@section('title', '广告列表')

@section('content')
<h2 class="sub-header">广告管理</h2>[ <a href="/fladmin/ad/add">添加广告</a> ]<br><br>

<form name="listarc"><div class="table-responsive"><table class="table table-striped table-hover">
<thead><tr>
<th>ID</th>
<th>名称</th>
<th>是否限时</th>
<th>结束时间</th>
<th>管理</th>
</tr></thead>
<tbody>
<?php if ($list) { foreach ($list as $row) { ?><tr>
<td><?php echo $row->id; ?></td>
<td><?php echo $row->name; ?></td>
<td><?php if ($row->is_expire == 0) { echo '不限时间'; } else { echo '限时标记'; } ?></td>
<td><?php if ($row->end_time > 0) { echo date('Y-m-d', $row->end_time); } ?></td>
<td><a href="/fladmin/ad/edit?id=<?php echo $row->id; ?>">修改</a> | <a onclick="delconfirm('/fladmin/ad/del?id=<?php echo $row->id; ?>')" href="javascript:;">删除</a></td>
</tr><?php } } ?>
</tbody></table></div><!-- 表格结束 --></form><!-- 表单结束 -->

<nav aria-label="Page navigation">{{ $list->links() }}</nav>
@endsection