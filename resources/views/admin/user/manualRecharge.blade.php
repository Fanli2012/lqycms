@extends('admin.layouts.app')
@section('title', '人工充值')

@section('content')
<h2 class="sub-header">人工充值</h2>

<form id="addarc" method="post" action="" role="form" enctype="multipart/form-data" class="table-responsive">{{ csrf_field() }}
<table class="table table-striped table-bordered">
<tbody>
    <tr>
        <td colspan="2">当前充值用户：<?php if($user['user_name']){echo $user['user_name'];}else{echo $user['mobile'];} ?>，账户余额<font color="red"><?php echo $user['money']; ?></font>元</td>
    </tr>
    <tr>
        <td colspan="2">说明：正数为增加，负数为扣除</td>
    </tr>
    <tr>
        <td align="right" width="150px">充值金额：</td>
        <td>
			<input name="money" class="required" type="text" id="money" value="" /><input name="id" type="hidden" value="<?php echo $user['id']; ?>" />
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