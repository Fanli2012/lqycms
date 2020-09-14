@extends('admin.layouts.app')
@section('title', '操作记录列表')

@section('content')
<h2 class="sub-header">操作记录列表 <small class="badge"><?php echo $list->count(); ?> 条</small></h2>
[ <a href="<?php echo url('fladmin/log'); ?>?type=1">后台日志</a> <a href="<?php echo url('fladmin/log'); ?>?type=2">前台日志</a> <a href="<?php echo url('fladmin/log'); ?>?type=3">API日志</a> ]<br>

<div class="bg-info" style="margin:10px 0;padding:10px;">
    <div class="form-inline" style="display:inline;float:left;">
        <select name="type_id" class="form-control">
		  <option value="">请选择模块</option>
		  <option value="1">fladmin</option>
		  <option value="2">index</option>
		  <option value="3">api</option>
		  <option value="0">未知</option>
		</select>
		<div class="form-group"><input type="text" name="keyword" id="keyword" class="form-control required" placeholder="搜索关键词..."></div>
		<button type="submit" class="btn btn-info" value="Submit">搜索一下</button>
    </div>
    <div style="clear:both;"></div>
</div>

<?php if ($list->count() > 0) { ?>
<form name="listarc"><div class="table-responsive"><table class="table table-striped table-hover">
<thead><tr class="info">
<th>ID</th>
<th>模块</th>
<th>操作者</th>
<th>操作记录</th>
<th>来源</th>
<th>IP地址</th>
<th>操作时间</th>
<th>操作</th>
</tr></thead>
<tbody>
<?php foreach ($list as $row) { ?><tr>
<td><?php echo $row->id; ?></td>
<td><a href="{:url('index')}?type=<?php echo $row->type; ?>"><?php echo $row->type_text; ?></a></td>
<td><a href="{:url('index')}?login_id=<?php echo $row->login_id; ?>"><?php if (!empty($row->login_name)) { echo $row->login_name; } else { echo '未登录'; } ?></a></td>
<td style="width:300px;word-wrap:break-word;white-space:normal;word-break:break-all;">【<a href="{:url('index')}?http_method=<?php echo $row->http_method; ?>"><?php echo $row->http_method; ?></a>】<a href="<?php echo $row->url; ?>" target="_blank"><?php echo $row->url; ?></a> <?php if ($row->content) { echo ' - ' . htmlentities($row->content, ENT_QUOTES, "UTF-8"); } ?></td>
<td style="width:300px;word-wrap:break-word;white-space:normal;word-break:break-all;"><a href="<?php echo $row->http_referer; ?>" target="_blank"><?php echo $row->http_referer; ?></a></td>
<td><a href="{:url('index')}?ip=<?php echo $row->ip; ?>"><?php echo $row->ip; ?></a> <a href="https://www.baidu.com/s?wd=<?php echo $row->ip; ?>" target="_blank">查看</a></td>
<td><?php echo date('Y-m-d H:i:s', $row->add_time); ?></td>
<td><a onclick="confirm_prompt('<?php echo url('del').'?id=' . $row->id; ?>')" href="javascript:;">删除</a></td>
</tr><?php } ?>
</tbody></table></div><!-- 表格结束 --></form><!-- 表单结束 -->
<?php } ?>

<nav aria-label="Page navigation">{{ $list->links() }}</nav>
@endsection