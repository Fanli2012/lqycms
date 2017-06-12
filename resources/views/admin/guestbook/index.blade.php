@extends('admin.layouts.app')
@section('title', '留言列表')

@section('content')<form id="searcharc" class="navbar-form" action="/fladmin/guestbook" method="get">
<div class="form-group"><input type="text" name="keyword" id="keyword" class="form-control required" placeholder="搜索关键词..."></div>
<button type="submit" class="btn btn-info" value="Submit">搜索一下</button></form>

<div class="table-responsive">
<table class="table table-striped table-hover">
  <thead>
	<tr>
	  <th>ID</th>
	  <th width=25%>标题</th>
	  <th>留言时间</th>
	  <th width=45%>内容</th><th>操作</th>
	</tr>
  </thead>
  <tbody>
  <?php if($posts){foreach($posts as $row){ ?>
	<tr>
	  <td><?php echo $row->id; ?></td>
	  <td><?php echo $row->title; ?></td>
	  <td><?php echo date('Y-m-d H:i:s',$row->addtime); ?></td>
	  <td><?php echo $row->msg; ?></td><td>&nbsp;<a onclick="delconfirm('/fladmin/guestbook/del?id=<?php echo $row->id; ?>')" href="javascript:;">删除</a></td>
	</tr>
  <?php }} ?>
  </tbody>
</table>
</div><!-- 表格结束 -->

<nav aria-label="Page navigation">{{ $posts->links() }}</nav>

<script>
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
@endsection