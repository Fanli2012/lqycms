<!DOCTYPE html><html><head><title>商品列表_<?php echo sysconfig('CMS_WEBNAME'); ?>后台管理</title>@include('admin.common.header')
<div class="container-fluid">
<div class="row">
<!-- 左边开始 --><div class="col-sm-3 col-md-2 sidebar">@include('admin.common.leftmenu')</div><!-- 左边结束 -->

<!-- 右边开始 --><div class="col-sm-9 col-md-10 rightbox"><div id="mainbox"><h5 class="sub-header"><a href="/fladmin/producttype">商品分类</a> > <a href="/fladmin/product">商品列表</a> [ <a href="/fladmin/product/add<?php if(!empty($_GET["id"])){echo '?catid='.$_GET["id"];}?>">发布商品</a> ]</h5>

<div class="table-responsive">
<table class="table table-striped table-hover">
  <thead>
	<tr>
	  <th>ID</th>
	  <th>选择</th>
	  <th>商品标题</th>
	  <th>更新时间</th>
	  <th>类目</th><th>点击</th><th>操作</th>
	</tr>
  </thead>
  <tbody>
  <?php if($posts){foreach($posts as $row){ ?>
	<tr>
	  <td><?php echo $row->id; ?></td>
	  <td><input name="arcID" type="checkbox" value="<?php echo $row->id; ?>" class="np"></td>
	  <td><a href="/fladmin/product/edit?id=<?php echo $row->id; ?>"><?php echo $row->title; ?></a> <?php if(!empty($row->litpic)){echo "<small style='color:red'>[图]</small>";}if($row->tuijian==1){echo "<small style='color:#22ac38'>[荐]</small>";} ?> </td>
	  <td><?php echo date('Y-m-d',$row->pubdate); ?></td>
	  <td><a href="/fladmin/product?id=<?php echo $row->typeid; ?>"><?php echo $row->typename; ?></a></td><td><?php echo $row->click; ?></td><td><a target="_blank" href="<?php echo route('product',['id'=>$row->id]); ?>">预览</a>&nbsp;<a href="/fladmin/product/edit?id=<?php echo $row->id; ?>">修改</a>&nbsp;<a onclick="delconfirm('/fladmin/product/del?id=<?php echo $row->id; ?>')" href="javascript:;">删除</a></td>
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
<div>
<form id="searcharc" class="navbar-form" action="/fladmin/product" method="get">
<select name="typeid" id="typeid" style="padding:6px 5px;vertical-align:middle;border:1px solid #DBDBDB;border-radius:4px;">
<option value="0">选择栏目...</option>
<?php $catlist = category_tree(get_category('product_type',0));if($catlist){foreach($catlist as $row){ ?><option value="<?php echo $row["id"]; ?>"><?php for($i=0;$i<$row["deep"];$i++){echo "—";}echo $row["typename"]; ?></option><?php }} ?>
</select>
<div class="form-group"><input type="text" name="keyword" id="keyword" class="form-control required" placeholder="搜索关键词..."></div>
<button type="submit" class="btn btn-info" value="Submit">搜索一下</button></form>

<div class="backpages">{{ $posts->links() }}</div>

<script>
//批量删除商品
function delArc(aid)
{
	var checkvalue=getItems();
	
	if(checkvalue=='')
	{
		alert('必须选择一个或多个商品！');
		return;
	}
	
	if(confirm("确定删除吗"))
	{
		location="<?php echo route('admin_product_del'); ?>?id="+checkvalue;
	}
	else
	{
		
	}
}

//推荐商品
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
		location="<?php echo route('admin_product_recommendarc'); ?>?id="+checkvalue;
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