<!DOCTYPE html><html><head><title>商品分类_后台管理</title>@include('admin.common.header')
<div class="container-fluid">
<div class="row">
<!-- 左边开始 --><div class="col-sm-3 col-md-2 sidebar">@include('admin.common.leftmenu')</div><!-- 左边结束 -->

<!-- 右边开始 --><div class="col-sm-9 col-md-10 rightbox"><div id="mainbox">
<h2 class="sub-header">商品分类管理</h2>[ <a href="/fladmin/producttype/add">增加顶级分类</a> ] [ <a href="/fladmin/product/add">发布商品</a> ]<br><br>

<form name="listarc"><div class="table-responsive">
<table class="table table-striped table-hover">
<thead><tr><th>ID</th><th>名称</th><th>商品数</th><th>别名</th><th>更新时间</th><th>操作</th></tr></thead>
<tbody id="cat-list">
<?php if($catlist){foreach($catlist as $row){ ?>
<tr id="cat-<?php echo $row["id"]; ?>">
<td><?php echo $row["id"]; ?></td>
<td><a href="/fladmin/product?id=<?php echo $row["id"]; ?>"><?php for($i=0;$i<$row["deep"];$i++){echo "— ";}echo $row["typename"]; ?></a></td>
<td><?php echo catarcnum($row["id"].'product'); ?></td>
<td><?php echo $row["typedir"]; ?></td>
<td><?php echo date('Y-m-d',$row["addtime"]); ?></td>
<td><a href="<?php echo get_front_url(array("type"=>"list","catid"=>$row["id"])); ?>" target="_blank">预览</a> | <a href="/fladmin/product/add?catid=<?php echo $row["id"]; ?>">发布商品</a> | <a href="/fladmin/producttype/add?reid=<?php echo $row["id"]; ?>">增加子类</a> | <a href="/fladmin/producttype/edit?id=<?php echo $row["id"]; ?>">更改</a> | <a onclick="delconfirm('/fladmin/producttype/del?id=<?php echo $row["id"]; ?>')" href="javascript:;">删除</a></td>
</tr><?php }} ?>
</tbody></table></div><!-- 表格结束 --></form><!-- 表单结束 -->
</div></div><!-- 右边结束 --></div></div>
</body></html>