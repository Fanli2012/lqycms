@extends('admin.layouts.app')
@section('title', '关键词列表')

@section('content')
<h2 class="sub-header">关键词管理</h2>[ <a href="/fladmin/keyword/add">添加关键词</a> ]<br><br>

<form name="listarc"><div class="table-responsive"><table class="table table-striped table-hover">
<thead><tr>
<th>编号</th>
<th>关键词</th>
<th>链接网址</th>
<th>管理</th>
</tr></thead>
<tbody>
<?php foreach($posts as $row){ ?><tr>
<td><?php echo $row->id; ?></td>
<td><?php echo $row->keyword; ?></td>
<td><?php echo $row->rpurl; ?></td>
<td><a href="/fladmin/keyword/edit?id=<?php echo $row->id; ?>">修改</a> | <a onclick="delconfirm('/fladmin/keyword/del?id=<?php echo $row->id; ?>')" href="javascript:;">删除</a></td>
</tr><?php } ?>
</tbody></table></div><!-- 表格结束 --></form><!-- 表单结束 -->

<nav aria-label="Page navigation">{{ $posts->links() }}</nav>
@endsection