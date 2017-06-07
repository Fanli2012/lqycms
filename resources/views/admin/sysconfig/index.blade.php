<!DOCTYPE html><html><head><title>系统配置参数_后台管理</title>@include('admin.common.header')
<div class="container-fluid">
<div class="row">
<!-- 左边开始 --><div class="col-sm-3 col-md-2 sidebar">@include('admin.common.leftmenu')</div><!-- 左边结束 -->

<!-- 右边开始 --><div class="col-sm-9 col-md-10 rightbox"><div id="mainbox">
<h2 class="sub-header">系统配置参数</h2>[ <a href="/fladmin/sysconfig/add">添加参数</a> ] [ <a href="<?php echo route('admin_index_upconfig'); ?>">更新配置缓存</a> ]<br><br>

<form name="listarc"><div class="table-responsive"><table class="table table-striped table-hover">
<thead><tr>
<th>编号</th>
<th>参数说明</th>
<th>参数值</th>
<th>变量名</th>
<th>管理</th>
</tr></thead>
<tbody>
<?php foreach($posts as $row){ ?><tr>
<td><?php echo $row->id; ?></td>
<td><?php echo $row->info; ?></td>
<td><?php echo mb_strcut($row->value,0,80,'utf-8'); ?></td>
<td><?php echo $row->varname; ?></td>
<td><a href="/fladmin/sysconfig/edit?id=<?php echo $row->id; ?>">修改</a> | <a onclick="delconfirm('/fladmin/sysconfig/del?id=<?php echo $row->id; ?>')" href="javascript:;">删除</a></td>
</tr><?php } ?>
</tbody></table></div><!-- 表格结束 --></form><!-- 表单结束 -->

<nav aria-label="Page navigation">{{ $posts->links() }}</nav>

</div></div><!-- 右边结束 --></div></div>
</body></html>