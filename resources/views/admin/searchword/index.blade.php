<!DOCTYPE html><html><head><title>搜索关键词列表_后台管理</title>@include('admin.common.header')
<div class="container-fluid">
<div class="row">
<!-- 左边开始 --><div class="col-sm-3 col-md-2 sidebar">@include('admin.common.leftmenu')</div><!-- 左边结束 -->

<!-- 右边开始 --><div class="col-sm-9 col-md-10 rightbox"><div id="mainbox">
<h2 class="sub-header">搜索关键词管理</h2>[ <a href="/fladmin/searchword/add">增加关键词</a> ]<br><br>

<form name="listarc"><div class="table-responsive"><table class="table table-striped table-hover">
<thead>
<tr>
  <th>编号</th>
  <th>名称</th>
  <th>更新时间</th>
  <th>管理</th>
</tr>
</thead>
<tbody>
<?php foreach($posts as $row){ ?>
<tr>
  <td><?php echo $row->id; ?></td>
  <td><a href="/fladmin/searchword/edit?id=<?php echo $row->id; ?>"><?php echo $row->name; ?></a></td>
  <td><?php echo date('Y-m-d',$row->pubdate); ?></td>
  <td><a target="_blank" href="<?php echo get_front_url(array("type"=>"tags","tagid"=>$row->id)); ?>">预览</a>&nbsp;<a href="/fladmin/searchword/edit?id=<?php echo $row->id; ?>">修改</a>&nbsp;<a onclick="delconfirm('/fladmin/searchword/del?id=<?php echo $row->id; ?>')" href="javascript:;">删除</a></td>
</tr>
<?php } ?>
</tbody>
</table></div><!-- 表格结束 --></form><!-- 表单结束 -->

<div class="backpages">{{ $posts->links() }}</div>

</div></div><!-- 右边结束 --></div></div>
</body></html>