@extends('admin.layouts.app')
@section('title', '意见反馈列表')

@section('content')
<h2 class="sub-header">意见反馈列表</h2>

<form name="listarc"><div class="table-responsive"><table class="table table-hover">
<thead><tr class="info">
<th>ID</th>
<th>标题</th>
<th>内容</th>
<th>时间</th>
<th>管理</th>
</tr></thead>
<tbody>
<?php if($posts){foreach($posts as $row){ ?><tr>
<td><?php echo $row->id; ?></td>
<td><?php echo $row->title; ?></td>
<td><?php echo $row->content; ?></td>
<td><?php echo $row->created_at; ?></td>
<td><a onclick="delconfirm('<?php echo route('admin_feedback_del',array('id'=>$row->id)); ?>')" href="javascript:;">删除</a></td>
</tr><?php }} ?>
</tbody></table></div><!-- 表格结束 --></form><!-- 表单结束 -->

<nav aria-label="Page navigation">{{ $posts->links() }}</nav>
@endsection