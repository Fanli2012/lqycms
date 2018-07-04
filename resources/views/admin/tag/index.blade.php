@extends('admin.layouts.app')
@section('title', 'Tag列表')

@section('content')
<h2 class="sub-header">Tag管理</h2>[ <a href="/fladmin/tag/add">增加Tag标签</a> ]<br><br>

<form name="listarc"><div class="table-responsive"><table class="table table-striped table-hover">
<thead>
<tr>
  <th>编号</th>
  <th>标签</th>
  <th>文档数</th>
  <th>更新时间</th>
  <th>管理</th>
</tr>
</thead>
<tbody>
<?php foreach($posts as $row){ ?>
<tr>
  <td><?php echo $row->id; ?></td>
  <td><a href="/fladmin/tag/edit?id=<?php echo $row->id; ?>"><?php echo $row->tag; ?></a></td><td><?php echo tagarcnum($row->id); ?></td>
  <td><?php echo date('Y-m-d',$row->pubdate); ?></td>
  <td><a target="_blank" href="<?php echo route('home_tag', array('tag'=>$row->id)); ?>">预览</a>&nbsp;<a href="/fladmin/tag/edit?id=<?php echo $row->id; ?>">修改</a>&nbsp;<a onclick="delconfirm('/fladmin/tag/del?id=<?php echo $row->id; ?>')" href="javascript:;">删除</a></td>
</tr>
<?php } ?>
</tbody>
</table></div><!-- 表格结束 --></form><!-- 表单结束 -->

<nav aria-label="Page navigation">{{ $posts->links() }}</nav>
@endsection