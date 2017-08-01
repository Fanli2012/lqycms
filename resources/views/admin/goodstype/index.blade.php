@extends('admin.layouts.app')
@section('title', '商品分类')

@section('content')
<h2 class="sub-header">商品分类管理</h2>[ <a href="/fladmin/goodstype/add">增加顶级分类</a> ] [ <a href="/fladmin/goods/add">发布商品</a> ]<br><br>

<form name="listarc"><div class="table-responsive">
<table class="table table-striped table-hover">
<thead><tr><th>ID</th><th>名称</th><th>商品数</th><th>别名</th><th>更新时间</th><th>操作</th></tr></thead>
<tbody id="cat-list">
<?php if($catlist){foreach($catlist as $row){ ?>
<tr id="cat-<?php echo $row["id"]; ?>">
<td><?php echo $row["id"]; ?></td>
<td><a href="/fladmin/goods?id=<?php echo $row["id"]; ?>"><?php for($i=0;$i<$row["deep"];$i++){echo "— ";}echo $row["name"]; ?></a></td>
<td><?php echo catarcnum($row["id"].'goods'); ?></td>
<td><?php echo $row["typedir"]; ?></td>
<td><?php echo date('Y-m-d',$row["addtime"]); ?></td>
<td><a href="<?php echo get_front_url(array("type"=>"list","catid"=>$row["id"])); ?>" target="_blank">预览</a> | <a href="/fladmin/goods/add?catid=<?php echo $row["id"]; ?>">发布商品</a> | <a href="/fladmin/goodstype/add?reid=<?php echo $row["id"]; ?>">增加子类</a> | <a href="/fladmin/goodstype/edit?id=<?php echo $row["id"]; ?>">更改</a> | <a onclick="delconfirm('/fladmin/goodstype/del?id=<?php echo $row["id"]; ?>')" href="javascript:;">删除</a></td>
</tr><?php }} ?>
</tbody></table></div><!-- 表格结束 --></form><!-- 表单结束 -->
@endsection