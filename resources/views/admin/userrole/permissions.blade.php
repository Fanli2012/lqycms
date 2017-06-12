@extends('admin.layouts.app')
@section('title', '角色权限设置')

@section('content')
<h2 class="sub-header">角色权限设置</h2>[ <a href="<?php echo route('admin_userrole'); ?>">角色列表</a> ]<br><br>

<form method="post" action="<?php echo route('admin_userrole_dopermissions'); ?>" role="form" enctype="multipart/form-data" class="table-responsive"><div class="table-responsive">{{ csrf_field() }}
<input style="display:none;" name="role_id" type="text" id="role_id" value="<?php echo $role_id; ?>">
<ul class="list-group">
<?php if($menus){foreach($menus as $row){ ?>
<li class="list-group-item <?php if($row["deep"]==0){echo 'list-group-item-info';} ?>"><?php echo '<span style="padding-left:'.($row["deep"]*30).'px;"></span>'; ?><input type='checkbox' <?php if($row["is_access"]==1){echo "checked='checked'";} ?> name='menuid[]' value='<?php echo $row["id"]; ?>' level='<?php echo $row["deep"]; ?>' onclick='javascript:checknode(this);'> <?php for($i=0;$i<$row["deep"];$i++){echo "—";}echo $row["name"]; ?></li>
<?php }} ?>
</ul>

<button type="submit" class="btn btn-success" value="Submit">保存(Submit)</button><br><br>
</div><!-- 表格结束 --></form><!-- 表单结束 -->

<script>
function checknode(obj)
{
	var chk = $("input[type='checkbox']");
	var count = chk.length;
	var num = chk.index(obj);
	var level_top = level_bottom = chk.eq(num).attr('level');
	
	for (var i = num; i >= 0; i--)
	{
		var le = chk.eq(i).attr('level');
		if (le <level_top)
		{
			chk.eq(i).prop("checked", true);
			var level_top = level_top - 1;
		}
	}
	
	for (var j = num + 1; j < count; j++)
	{
		var le = chk.eq(j).attr('level');
		
		if (chk.eq(num).prop("checked"))
		{
			if (le > level_bottom)
			{
				chk.eq(j).prop("checked", true);
			}
			else if (le == level_bottom)
			{
				break;
			}
		}
		else
		{
			if (le >level_bottom)
			{
				chk.eq(j).prop("checked", false);
			}else if(le == level_bottom)
			{
				break;
			}
		}
	}
}
</script>
@endsection