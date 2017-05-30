<!DOCTYPE html><html><head><title>栏目列表_后台管理</title>@include('admin.common.header')
<div class="container-fluid">
<div class="row">
<!-- 左边开始 --><div class="col-sm-3 col-md-2 sidebar">@include('admin.common.leftmenu')</div><!-- 左边结束 -->

<!-- 右边开始 --><div class="col-sm-9 col-md-10 rightbox"><div id="mainbox">
<h2 class="sub-header">网站栏目管理</h2>[ <a href="/fladmin/category/add">增加顶级栏目</a> ] [ <a href="/fladmin/article/add">发布文章</a> ]<br><br>

<form name="listarc"><div class="table-responsive">
<table class="table table-striped table-hover">
<thead><tr><th>ID</th><th>名称</th><th>文章数</th><th>别名</th><th>更新时间</th><th>操作</th></tr></thead>
<tbody id="cat-list">
<?php $catlist = category_tree(get_category('arctype',0));foreach($catlist as $row){ ?>
<tr id="cat-<?php echo $row["id"]; ?>">
<td><?php echo $row["id"]; ?></td>
<td><a href="/fladmin/article?id=<?php echo $row["id"]; ?>"><?php for($i=0;$i<$row["deep"];$i++){echo "— ";}echo $row["typename"]; ?></a></td><td><?php echo catarcnum($row["id"],'article'); ?></td><td><?php echo $row["typedir"]; ?></td><td><?php echo date('Y-m-d',$row["addtime"]); ?></td>
<td><a href="<?php echo get_front_url(array("type"=>"list","catid"=>$row["id"])); ?>" target="_blank">预览</a> | <a href="/fladmin/article/add?catid=<?php echo $row["id"]; ?>">发布文章</a> | <a href="/fladmin/category/add?reid=<?php echo $row["id"]; ?>">增加子类</a> | <a href="/fladmin/category/edit?id=<?php echo $row["id"]; ?>">更改</a> | <a onclick="delconfirm('/fladmin/category/del?id=<?php echo $row["id"]; ?>')" href="javascript:;">删除</a></td>
</tr><?php } ?>
</tbody></table></div><!-- 表格结束 --></form><!-- 表单结束 -->
</div></div><!-- 右边结束 --></div></div>
</body></html>