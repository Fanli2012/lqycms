@extends('admin.layouts.app')
@section('title', '账户记录列表')

@section('content')
<h2 class="sub-header">账户记录列表</h2>

<form name="listarc"><div class="table-responsive"><table class="table table-hover">
<thead><tr class="info">
<th>ID</th>
<th>用户名</th>
<th>金额</th>
<th>说明</th>
<th>时间</th>
</tr></thead>
<tbody>
<?php if($posts){foreach($posts as $row){ ?><tr>
<td><?php echo $row->id; ?></td>
<td><a href="<?php echo route('admin_user_money',array('user_id'=>$row->user_id)); ?>"><?php if($row->user->user_name){echo $row->user->user_name;}else{echo $row->user->mobile;} ?></a></td>
<td><font<?php if($row->type==1){echo ' color="#0C0"';}else{echo ' color="red"';} ?>><?php if($row->type==1){echo '-';} ?><?php echo $row->money; ?></font></td>
<td><?php echo $row->des; ?></td>
<td><?php echo date('Y-m-d H:i:s',$row->add_time); ?></td>
</tr><?php }} ?>
</tbody></table></div><!-- 表格结束 --></form><!-- 表单结束 -->

<nav aria-label="Page navigation">{{ $posts->links() }}</nav>
@endsection