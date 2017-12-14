@extends('admin.layouts.app')
@section('title', '角色修改')

@section('content')
<h5 class="sub-header"><a href="<?php echo route('admin_adminrole'); ?>">角色列表</a> > 角色修改</h5>

<form id="addarc" method="post" action="<?php echo route('admin_adminrole_doedit'); ?>" role="form" enctype="multipart/form-data" class="table-responsive">{{ csrf_field() }}
<table class="table table-striped table-bordered">
<tbody>
    <tr>
        <td align="right">角色名称：</td>
        <td><input name="name" type="text" id="name" value="<?php echo $post["name"]; ?>" class="required" style="width:30%" placeholder="在此输入角色名称"><input style="display:none;" name="id" type="text" id="id" value="<?php echo $id; ?>"></td>
    </tr>
    <tr>
        <td align="right">角色描述：</td>
        <td><input name="des" type="text" id="des" value="<?php echo $post["des"]; ?>" style="width:60%"></td>
    </tr>
    <tr>
        <td align="right">状态：</td>
        <td>
            <input type="radio" value='0' name="status" <?php if($post['status']==0){echo 'checked';} ?> />&nbsp;启用&nbsp;&nbsp;
            <input type="radio" value='1' name="status" <?php if($post['status']==1){echo 'checked';} ?> />&nbsp;禁用
        </td>
    </tr>
    <tr>
        <td align="right">排序：</td>
        <td><input name="listorder" type="text" id="listorder" value="<?php echo $post["listorder"]; ?>" style="width:60%"></td>
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