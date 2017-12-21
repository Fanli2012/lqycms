@extends('admin.layouts.app')
@section('title', '会员列表')

@section('content')
<h2 class="sub-header">会员列表</h2>[ <a href="<?php echo route('admin_user_add'); ?>">添加会员</a> ] [ <a href="<?php echo route('admin_user_money'); ?>">账户记录</a> ] [ <a href="<?php echo route('admin_userrank'); ?>">会员等级</a> ]<br><br>

<form name="listarc"><div class="table-responsive"><table class="table table-hover">
<thead><tr class="info">
<th>ID</th>
<th>头像</th>
<th>用户名</th>
<th>性别</th>
<th>余额</th>
<th>积分</th>
<th>佣金</th>
<th>注册时间</th>
<th>状态</th>
<th>管理</th>
</tr></thead>
<tbody>
<?php if($posts){foreach($posts as $row){ ?><tr>
<td><?php echo $row->id; ?></td>
<td><img src="<?php echo $row->head_img; ?>" style="width:24px;height:24px;"></td>
<td><?php if($row->user_name){echo $row->user_name;}else{echo $row->mobile;} ?></td>
<td><?php echo $row->sex_text; ?></td>
<td><?php echo $row->money; ?></td>
<td><?php echo $row->point; ?></td>
<td><font color="red"><?php echo $row->commission; ?></font></td>
<td><?php echo date('Y-m-d H:i:s',$row->add_time); ?></td>
<td><?php echo $row->status_text; ?></td>
<td><a href="<?php echo route('admin_user_manual_recharge',array('user_id'=>$row->id)); ?>">人工充值</a> | <a href="<?php echo route('admin_user_money',array('user_id'=>$row->id)); ?>">帐户记录</a> | <a href="<?php echo route('admin_user_edit'); ?>?id=<?php echo $row->id; ?>">修改</a><?php if($row->status==1){ ?> | <a onclick="delconfirm('<?php echo route('admin_user_del'); ?>?id=<?php echo $row->id; ?>')" href="javascript:;">删除</a><?php } ?></td>
</tr><?php }} ?>
</tbody></table></div><!-- 表格结束 --></form><!-- 表单结束 -->

<nav aria-label="Page navigation">{{ $posts->links() }}</nav>
@endsection