@extends('admin.layouts.app')
@section('title', '优惠券修改')

@section('content')
<script language="javascript" type="text/javascript" src="http://<?php echo env('APP_DOMAIN'); ?>/js/My97DatePicker/WdatePicker.js"></script>

<h5 class="sub-header"><a href="<?php echo route('admin_bonus'); ?>">优惠券列表</a> > 优惠券修改</h5>

<form id="addarc" method="post" action="" role="form" enctype="multipart/form-data" class="table-responsive">{{ csrf_field() }}
<table class="table table-striped table-bordered">
<tbody>
    <tr>
        <td align="right" width="150px">名称：</td>
        <td><input name="name" type="text" id="name" value="<?php echo $post['name']; ?>" class="required" style="width:30%" placeholder="在此输入名称"><input style="display:none;" name="id" type="text" id="id" value="<?php echo $id; ?>"></td>
    </tr>
    <tr>
        <td align="right">金额：</td>
        <td><input name="money" type="text" id="money" value="<?php echo $post['money']; ?>" size="10"></td>
    </tr>
    <tr>
        <td align="right">满多少使用：</td>
        <td><input name="min_amount" type="text" id="min_amount" value="<?php echo $post['min_amount']; ?>" size="10"></td>
    </tr>
    <tr>
        <td align="right">数量：</td>
        <td><input name="num" type="text" id="num" value="<?php echo $post['num']; ?>" size="5"> (-1表示不限)</td>
    </tr>
    <tr>
        <td align="right">期限：</td>
        <td>
            起：<input value="<?php echo $post['start_time']; ?>" size="18" onclick="WdatePicker({el:this,dateFmt:'yyyy-MM-dd HH:mm:ss'})" type="text" id="start_time" name="start_time" placeholder="开始时间"> - 
            止：<input value="<?php echo $post['end_time']; ?>" size="18" onclick="WdatePicker({el:this,dateFmt:'yyyy-MM-dd HH:mm:ss'})" type="text" id="end_time" name="end_time" placeholder="结束时间">
        </td>
    </tr>
    <tr>
        <td align="right">是否可用：</td>
        <td>
			<input type="radio" value='0' name="status" <?php if(isset($post['status']) && $post['status']==0){echo 'checked';} ?> />&nbsp;是&nbsp;&nbsp;
			<input type="radio" value='1' name="status" <?php if(isset($post['status']) && $post['status']==1){echo 'checked';} ?> />&nbsp;否
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