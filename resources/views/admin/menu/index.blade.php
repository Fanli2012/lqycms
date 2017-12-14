@extends('admin.layouts.app')
@section('title', '菜单管理')

@section('content')
<h2 class="sub-header">菜单管理</h2>[ <a href="/fladmin/menu/add">菜单添加</a> ]<br><br>

<form name="listarc"><div class="table-responsive"><table class="table table-striped table-hover">
<thead><tr class="info">
<th>ID</th>
<th>菜单名称</th>
<th>操作方法</th>
<th>状态</th>
<th>管理</th>
</tr></thead>
<tbody>
<?php foreach($posts as $row){ ?><tr>
<td><?php echo $row->id; ?></td>
<td><?php echo $row->name; ?></td>
<td><?php echo $row->action; ?></td>
<td><?php if($row->status==1){echo '显示';}else{echo '隐藏';} ?></td>
<td><a href="<?php echo route('admin_menu_add',['pid' => $row->id]); ?>">添加子菜单</a> | <a href="/fladmin/menu/edit?id=<?php echo $row->id; ?>">修改</a> | <a onclick="delconfirm('/fladmin/menu/del?id=<?php echo $row->id; ?>')" href="javascript:;">删除</a></td>
</tr><?php } ?>
</tbody></table></div><!-- 表格结束 --></form><!-- 表单结束 -->

<nav aria-label="Page navigation">{{ $posts->links() }}</nav>
@endsection