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
  <td><a href="/fladmin/goodsbrand/edit?id=<?php echo $row["id"]; ?>"><?php echo $row["title"]; ?></a></td>
  <td><?php if(){echo $row["filename"];} ?></td>
  <td><?php echo date('Y-m-d',$row["pubdate"]); ?></td>
  <td><a target="_blank" href="<?php echo get_front_url(array("type"=>"page","pagename"=>$row["filename"])); ?>">预览</a>&nbsp;<a href="/fladmin/goodsbrand/edit?id=<?php echo $row["id"]; ?>">修改</a>&nbsp;<a onclick="delconfirm('/fladmin/goodsbrand/del?id=<?php echo $row["id"]; ?>')" href="javascript:;">删除</a></td>
</tr>
<?php }} ?>
</tbody>
</table></div><!-- 表格结束 --></form><!-- 表单结束 -->
@endsection