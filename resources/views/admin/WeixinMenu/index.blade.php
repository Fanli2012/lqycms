@extends('admin.layouts.app')
@section('title', '微信公众号自定义菜单列表')

@section('content')
<h2 class="sub-header">微信自定义菜单</h2>[ <a href="/fladmin/weixinmenu/add">增加顶级菜单</a> ] [ <a onclick="createmenu_confirm('/fladmin/weixinmenu/createmenu')" href="javascript:;">生成菜单</a> ]<br><br>

<form name="listarc"><div class="table-responsive">
<table class="table table-striped table-hover">
<thead><tr><th>ID</th><th>名称</th><th>菜单动作类型</th><th>是否显示</th><th>更新时间</th><th>操作</th></tr></thead>
<tbody id="cat-list">
<?php if($catlist){foreach($catlist as $row){ ?>
<tr id="cat-<?php echo $row["id"]; ?>">
<td><?php echo $row["id"]; ?></td>
<td><?php if($row["pid"]!=0){echo "— ";}echo $row["name"]; ?></td><td><?php echo $row["type"]; ?></td><td><?php if($row["is_show"]==0){echo '是';}else{echo '<font color="red">否</font>';} ?></td><td><?php echo date('Y-m-d',$row["addtime"]); ?></td>
<td><a href="/fladmin/weixinmenu/edit?id=<?php echo $row["id"]; ?>">更改</a> | <a onclick="delconfirm('/fladmin/weixinmenu/del?id=<?php echo $row["id"]; ?>')" href="javascript:;">删除</a><?php if($row["pid"]==0){ ?> | <a href="/fladmin/weixinmenu/add?reid=<?php echo $row["id"]; ?>">增加子类</a><?php } ?></td>
</tr><?php }} ?>
</tbody></table></div><!-- 表格结束 --></form><!-- 表单结束 -->

<script>
function createmenu_confirm(url)
{
	if(confirm("确定要重新生成微信自定义菜单吗？"))
	{
		location.href= url;
	}
	else
	{
		
	}
}
</script>
@endsection