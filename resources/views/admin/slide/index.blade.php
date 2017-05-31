<!DOCTYPE html><html><head><title>轮播图列表_后台管理</title>@include('admin.common.header')
<div class="container-fluid">
<div class="row">
<!-- 左边开始 --><div class="col-sm-3 col-md-2 sidebar">@include('admin.common.leftmenu')</div><!-- 左边结束 -->

<!-- 右边开始 --><div class="col-sm-9 col-md-10 rightbox"><div id="mainbox">
<h2 class="sub-header">轮播图管理</h2>[ <a href="/fladmin/slide/add">添加轮播图</a> ]<br><br>

<form name="listarc"><div class="table-responsive"><table class="table table-striped table-hover">
<thead><tr>
<th>图片</th>
<th>标题</th>
<th>链接网址</th>
<th>排序</th>
<th>是否显示</th>
<th>管理</th>
</tr></thead>
<tbody>
<?php if($posts){foreach($posts as $row){ ?><tr>
<td><img style="<?php if(empty($row->pic) || !imgmatch($row->pic)){ echo "display:none;"; } ?>" src="<?php if(imgmatch($row->pic)){echo $row->pic;} ?>" width="90" height="60"></td>
<td><?php echo $row->title; ?></td>
<td><?php echo $row->url; ?></td>
<td><?php echo $row->rank; ?></td>
<td><?php if($row->is_show==0){echo "是";}else{echo "<font color=red>否</font>";} ?></td>
<td><a href="/fladmin/slide/edit?id=<?php echo $row->id; ?>">修改</a> | <a onclick="delconfirm('/fladmin/slide/del?id=<?php echo $row->id; ?>')" href="javascript:;">删除</a></td>
</tr><?php }} ?>
</tbody></table></div><!-- 表格结束 --></form><!-- 表单结束 -->

<div class="backpages">{{ $posts->links() }}</div>

</div></div><!-- 右边结束 --></div></div>
</body></html>