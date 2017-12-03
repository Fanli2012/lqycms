@extends('admin.layouts.app')
@section('title', '品牌列表')

@section('content')
<h2 class="sub-header">品牌管理</h2>[ <a href="/fladmin/goodsbrand/add">品牌添加</a> ]<br><br>

<form name="listarc"><div class="table-responsive"><table class="table table-striped table-hover">
<thead>
<tr>
  <th>编号</th>
  <th>名称</th>
  <th>是否显示</th>
  <th>更新时间</th>
  <th>管理</th>
</tr>
</thead>
<tbody>
<?php if($posts){foreach($posts as $row){ ?>
<tr>
  <td><?php echo $row["id"]; ?></td>
  <td><a href="<?php echo route('admin_goodsbrand_edit',array('id'=>$row["id"])); ?>"><?php echo $row["title"]; ?></a></td>
  <td><?php if($row['status']==0){echo "是";}else{echo "<font color=red>否</font>";} ?></td>
  <td><?php echo date('Y-m-d',$row["add_time"]); ?></td>
  <td><a href="<?php echo route('admin_goodsbrand_edit',array('id'=>$row["id"])); ?>">修改</a>&nbsp;<a onclick="delconfirm('<?php echo route('admin_goodsbrand_del',array('id'=>$row["id"])); ?>')" href="javascript:;">删除</a></td>
</tr>
<?php }} ?>
</tbody>
</table></div><!-- 表格结束 --></form><!-- 表单结束 -->
@endsection