@extends('admin.layouts.app')
@section('title', '会员添加')

@section('content')
<h5 class="sub-header"><a href="<?php echo route('admin_user'); ?>">会员列表</a> > 会员添加</h5>

<form id="addarc" method="post" action="" role="form" enctype="multipart/form-data" class="table-responsive">{{ csrf_field() }}
<table class="table table-striped table-bordered">
<tbody>
    <tr>
        <td align="right" width="150px">用户名：</td>
        <td><input name="user_name" type="text" id="user_name" value="" class="required" size="15" placeholder="在此输入用户名"></td>
    </tr>
    <tr>
        <td align="right">手机号：</td>
        <td><input name="mobile" type="text" id="mobile" value="" class="required" size="15" placeholder="在此输入手机号"></td>
    </tr>
    <tr>
        <td align="right">密码：</td>
        <td><input name="password" type="password" id="password" value="" class="required" size="30"></td>
    </tr>
    <tr>
        <td align="right">金额</td>
        <td><input name="money" type="text" id="money" value="0" size="6"></td>
    </tr>
    <tr>
        <td align="right">性别：</td>
        <td>
		<select name="sex" id="sex">
            <option selected value="1">男</option>
            <option value="2">女</option>
		</select>
		</td>
    </tr>
    <tr>
        <td align="right">会员等级：</td>
        <td>
		<select name="user_rank" id="user_rank">
            <option selected value="0">请选择</option>
            <?php if($user_rank){foreach($user_rank as $k=>$v){ ?>
            <option value="<?php echo $v->rank; ?>"><?php echo $v->title; ?></option>
            <?php }} ?>
		</select>
		</td>
    </tr>
    <tr>
        <td align="right">父级id</td>
        <td><input name="parent_id" type="text" id="parent_id" value="0" size="3"></td>
    </tr>
    <tr>
        <td colspan="2"><button type="submit" class="btn btn-success" value="Submit">保存(Submit)</button>&nbsp;&nbsp;<button type="reset" class="btn btn-default" value="Reset">重置(Reset)</button><input type="hidden"></input></td>
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