<!DOCTYPE html><html><head><title>文章列表_<?php echo sysconfig('CMS_WEBNAME'); ?>后台管理</title>@include('admin.common.header')
<div class="container-fluid">
<div class="row">
<!-- 左边开始 --><div class="col-sm-3 col-md-2 sidebar">@include('admin.common.leftmenu')</div><!-- 左边结束 -->

<!-- 右边开始 --><div class="col-sm-9 col-md-10 rightbox"><div id="mainbox"><h5 class="sub-header"><a href="/fladmin/category">栏目管理</a> > <a href="/fladmin/article">文章列表</a> [ <a href="/fladmin/article/add<?php if(!empty($_GET["id"])){echo '?catid='.$_GET["id"];}?>">发布文章</a> ]</h5>

<div class="table-responsive">
<table class="table table-striped table-hover">
  <thead>
	<tr>
	  <th>ID</th>
	  <th>选择</th>
	  <th>文章标题</th>
	  <th>更新时间</th>
	  <th>类目</th><th>点击</th><th>操作</th>
	</tr>
  </thead>
  <tbody>
  <?php if($posts){foreach($posts as $row){ ?>
	<tr>
	  <td><?php echo $row->id; ?></td>
	  <td><input name="arcID" type="checkbox" value="<?php echo $row->id; ?>" class="np"></td>
	  <td><a href="/fladmin/article/edit?id=<?php echo $row->id; ?>"><?php echo $row->title; ?></a> <?php if(!empty($row->litpic)){echo "<small style='color:red'>[图]</small>";}if($row->tuijian==1){echo "<small style='color:#22ac38'>[荐]</small>";} ?> </td>
	  <td><?php echo date('Y-m-d',$row->pubdate); ?></td>
	  <td><a href="/fladmin/article?id=<?php echo $row->typeid; ?>"><?php echo $row->name; ?></a></td><td><?php echo $row->click; ?></td><td><a target="_blank" href="<?php echo get_front_url(array("type"=>"content","catid"=>$row->typeid,"id"=>$row->id)); ?>">预览</a>&nbsp;<a href="/fladmin/article/edit?id=<?php echo $row->id; ?>">修改</a>&nbsp;<a onclick="delconfirm('/fladmin/article/del?id=<?php echo $row->id; ?>')" href="javascript:;">删除</a></td>
	</tr>
	<?php }} ?>
	<tr>
		<td colspan="8">
		<a href="javascript:selAll('arcID')" class="coolbg">反选</a>&nbsp;
		<a href="javascript:delArc()" class="coolbg">删除</a>&nbsp;
		<a href="javascript:tjArc()" class="coolbg">特荐</a>
		</td>
	</tr>
  </tbody>
</table>
</div><!-- 表格结束 -->

<form id="searcharc" class="navbar-form" action="/fladmin/article" method="get">
<select name="typeid" id="typeid" style="padding:6px 5px;vertical-align:middle;border:1px solid #DBDBDB;border-radius:4px;">
<option value="0">选择栏目...</option>
<?php $catlist = category_tree(get_category('arctype', 0)); foreach($catlist as $row) { ?><option value="<?php echo $row['id']; ?>"><?php for($i=0; $i<$row["deep"]; $i++) { echo "—"; } echo $row["name"]; ?></option><?php } ?>
</select>
<div class="form-group"><input type="text" name="keyword" id="keyword" class="form-control required" placeholder="搜索关键词..."></div>
<button type="submit" class="btn btn-info" value="Submit">搜索一下</button></form>

<nav aria-label="Page navigation">{{ $posts->links() }}</nav>

<script>
//推荐文章
function tjArc(aid)
{
	var checkvalue=getItems();
	
	if(checkvalue=='')
	{
		alert('必须选择一个或多个文档！');
		return;
	}
	
	if(confirm("确定要推荐吗"))
	{
		location="/fladmin/article/recommendarc?id="+checkvalue;
	}
	else
	{
		
	}
}

//批量删除文章
function delArc(aid)
{
	var checkvalue=getItems();
	
	if(checkvalue=='')
	{
		alert('必须选择一个或多个文档！');
		return;
	}
	
	if(confirm("确定删除吗"))
	{
		location="/fladmin/article/del?id="+checkvalue;
	}
	else
	{
		
	}
}

$(function(){
	$('.required').on('focus', function() {
		$(this).removeClass('input-error');
	});
	
    $("#searcharc").submit(function(e){
		$(this).find('.required').each(function(){
			if( $(this).val() == "" )
			{
				e.preventDefault();
				$(this).addClass('input-error');
			}
			else
			{
				$(this).removeClass('input-error');
			}
		});
    });
});
</script>

</div></div><!-- 右边结束 --></div></div>
</body></html>