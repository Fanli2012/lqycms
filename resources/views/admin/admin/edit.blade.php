@extends('admin.layouts.app')
@section('title', '管理员修改')

@section('content')
<h5 class="sub-header"><a href="<?php echo route('admin_admin'); ?>">管理员列表</a> > 管理员修改</h5>

<form id="addarc" method="post" action="<?php echo route('admin_admin_doedit'); ?>" role="form" enctype="multipart/form-data" class="table-responsive">{{ csrf_field() }}
<table class="table table-striped table-bordered">
<tbody>
    <tr>
        <td align="right">用户名：</td>
        <td><input name="name" type="text" id="name" value="<?php echo $post->name; ?>" class="required" style="width:30%" placeholder="在此输入用户名"><input style="display:none;" type="text" name="id" id="id" value="<?php echo $id; ?>"></td>
    </tr>
    <tr>
        <td align="right">密码：</td>
        <td><input name="pwd" type="password" id="pwd" value="" class="required" style="width:30%"></td>
    </tr>
    <tr>
        <td align="right">邮箱：</td>
        <td><input name="email" type="text" id="email" value="<?php echo $post->email; ?>" style="width:30%"></td>
    </tr>
    <tr>
        <td align="right">角色：</td>
        <td>
		<select name="role_id" id="role_id">
			<?php if($rolelist){foreach($rolelist as $row){ ?>
				<?php if($post->role_id==$row->id){ ?>
				<option selected value="<?php echo $row->id; ?>"><?php echo $row->name; ?></option>
				<?php }else{ ?>
				<option value="<?php echo $row->id; ?>"><?php echo $row->name; ?></option>
			<?php }}} ?>
		</select>
		</td>
    </tr>
    <tr>
        <td colspan="2"><button type="submit" class="btn btn-success" value="Submit">保存(Submit)</button>&nbsp;&nbsp;<button type="reset" class="btn btn-default" value="Reset">重置(Reset)</button></td>
    </tr>
</tbody></table></form><!-- 表单结束 -->
<script>
$(function(){
    $(".required").blur(function(){
        var $parent = $(this).parent();
        $parent.find(".formtips").remove();
        if(this.value=="")
        {
            $parent.append(' <small class="formtips onError"><font color="red">不能为空！</font></small>');
        }
        else
        {
            $parent.append(' <small class="formtips onSuccess"><font color="green">OK</font></small>');
        }
    });

    //重置
    $('#addarc input[type="reset"]').click(function(){
            $(".formtips").remove(); 
    });

    $("#addarc").submit(function(){
        $(".required").trigger('blur');
        var numError = $('#addarc .onError').length;
        
        if(numError){return false;}
    });
});
</script>
@endsection