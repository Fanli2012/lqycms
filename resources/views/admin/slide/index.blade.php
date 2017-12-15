@extends('admin.layouts.app')
@section('title', '轮播图列表')

@section('content')
<h2 class="sub-header">轮播图管理</h2>[ <a href="/fladmin/slide/add">添加轮播图</a> ]<br><br>

<form name="listarc"><div class="table-responsive"><table class="table table-hover">
<thead><tr class="info">
<th>ID</th>
<th>图片</th>
<th>标题</th>
<th>链接网址</th>
<th>显示平台</th>
<th>排序</th>
<th>是否显示</th>
<th>管理</th>
</tr></thead>
<tbody>
<?php if($posts){foreach($posts as $row){ ?><tr>
<td><?php echo $row->id; ?></td>
<td><img style="<?php if(empty($row->pic) || !imgmatch($row->pic)){ echo "display:none;"; } ?>" src="<?php if(imgmatch($row->pic)){echo $row->pic;} ?>" width="90" height="60"></td>
<td><?php echo $row->title; ?></td>
<td><?php echo $row->url; ?></td>
<td><font color="red"><?php echo $row->type_text; ?></font></td>
<td><?php echo $row->listorder; ?></td>
<td><?php if($row->is_show==0){echo "是";}else{echo "<font color=red>否</font>";} ?></td>
<td><a href="/fladmin/slide/edit?id=<?php echo $row->id; ?>">修改</a> | <a onclick="delconfirm('/fladmin/slide/del?id=<?php echo $row->id; ?>')" href="javascript:;">删除</a></td>
</tr><?php }} ?>
</tbody></table></div><!-- 表格结束 --></form><!-- 表单结束 -->

<nav aria-label="Page navigation">{{ $posts->links() }}</nav>
@endsection