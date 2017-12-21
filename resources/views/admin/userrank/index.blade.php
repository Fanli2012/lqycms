@extends('admin.layouts.app')
@section('title', '会员等级列表')

@section('content')
<h2 class="sub-header">会员等级管理</h2>[ <a href="<?php echo route('admin_userrank_add'); ?>">添加会员等级</a> ]<br><br>

<form name="listarc"><div class="table-responsive"><table class="table table-hover">
<thead><tr class="info">
<th>ID</th>
<th>等级名称</th>
<th>等级</th>
<th>排序</th>
<th>管理</th>
</tr></thead>
<tbody>
<?php if($posts){foreach($posts as $row){ ?><tr>
<td><?php echo $row->id; ?></td>
<td><?php echo $row->title; ?></td>
<td><?php echo $row->rank; ?></td>
<td><?php echo $row->listorder; ?></td>
<td><a href="<?php echo route('admin_userrank_edit',array('id'=>$row->id)); ?>">修改</a> | <a onclick="delconfirm('<?php echo route('admin_userrank_del',array('id'=>$row->id)); ?>')" href="javascript:;">删除</a></td>
</tr><?php }} ?>
</tbody></table></div><!-- 表格结束 --></form><!-- 表单结束 -->

<nav aria-label="Page navigation">{{ $posts->links() }}</nav>
@endsection