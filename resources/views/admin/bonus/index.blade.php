@extends('admin.layouts.app')
@section('title', '优惠券列表')

@section('content')
<h2 class="sub-header">优惠券管理</h2>[ <a href="<?php echo route('admin_bonus_add'); ?>">添加优惠券</a> ]<br><br>

<form name="listarc"><div class="table-responsive"><table class="table table-hover">
<thead><tr class="info">
<th>ID</th>
<th>名称</th>
<th>金额</th>
<th>满多少使用</th>
<th>开始领取时间</th>
<th>结束领取时间</th>
<th>数量</th>
<th>状态</th>
<th>管理</th>
</tr></thead>
<tbody>
<?php if($posts){foreach($posts as $row){ ?><tr>
<td><?php echo $row->id; ?></td>
<td><?php echo $row->name; ?></td>
<td><?php echo $row->money; ?></td>
<td><?php echo $row->min_amount; ?></td>
<td><?php echo $row->start_time; ?></td>
<td><?php echo $row->end_time; ?></td>
<td><?php if($row->num==-1){echo "不限";}else{echo "<font color=red>".$row->num."</font>";} ?></td>
<td><?php if($row->status==0){echo "可用";}else{echo "<font color=red>不可用</font>";} ?></td>
<td><a href="<?php echo route('admin_bonus_edit',array('id'=>$row->id)); ?>">修改</a> | <a onclick="delconfirm('<?php echo route('admin_bonus_del',array('id'=>$row->id)); ?>')" href="javascript:;">删除</a></td>
</tr><?php }} ?>
</tbody></table></div><!-- 表格结束 --></form><!-- 表单结束 -->

<nav aria-label="Page navigation">{{ $posts->links() }}</nav>
@endsection