@extends('admin.layouts.app')
@section('title', '快递列表')

@section('content')
<h2 class="sub-header">快递管理</h2>[ <a href="<?php echo route('admin_kuaidi_add'); ?>">添加快递</a> ]<br><br>

<form name="listarc"><div class="table-responsive"><table class="table table-hover">
<thead><tr class="info">
<th>ID</th>
<th>快递名称</th>
<th>编码</th>
<th>金额</th>
<th>说明</th>
<th>电话</th>
<th>官网</th>
<th>排序</th>
<th>是否显示</th>
<th>管理</th>
</tr></thead>
<tbody>
<?php if($posts){foreach($posts as $row){ ?><tr>
<td><?php echo $row->id; ?></td>
<td><?php echo $row->name; ?></td>
<td><?php echo $row->code; ?></td>
<td><?php echo $row->money; ?></td>
<td><?php echo $row->des; ?></td>
<td><?php echo $row->tel; ?></td>
<td><?php echo $row->website; ?></td>
<td><?php echo $row->listorder; ?></td>
<td><?php if($row->status==0){echo "是";}else{echo "<font color=red>否</font>";} ?></td>
<td><a href="<?php echo route('admin_kuaidi_edit',array('id'=>$row->id)); ?>">修改</a> | <a onclick="delconfirm('<?php echo route('admin_kuaidi_del',array('id'=>$row->id)); ?>')" href="javascript:;">删除</a></td>
</tr><?php }} ?>
</tbody></table></div><!-- 表格结束 --></form><!-- 表单结束 -->

<nav aria-label="Page navigation">{{ $posts->links() }}</nav>
@endsection