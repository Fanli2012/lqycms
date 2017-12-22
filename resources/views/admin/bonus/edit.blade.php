@extends('admin.layouts.app')
@section('title', '快递修改')

@section('content')
<h5 class="sub-header"><a href="<?php echo route('admin_kuaidi'); ?>">快递列表</a> > 快递修改</h5>

<form id="addarc" method="post" action="" role="form" enctype="multipart/form-data" class="table-responsive">{{ csrf_field() }}
<table class="table table-striped table-bordered">
<tbody>
    <tr>
        <td align="right" width="150px">快递名称：</td>
        <td><input name="name" type="text" id="name" value="<?php echo $post['name']; ?>" class="required" style="width:30%" placeholder="在此输入关键词"><input style="display:none;" name="id" type="text" id="id" value="<?php echo $id; ?>"></td>
    </tr>
    <tr>
        <td align="right">编码：</td>
        <td><input name="code" type="text" id="code" value="<?php echo $post['code']; ?>" size="15" class="required"></td>
    </tr>
    <tr>
        <td align="right">金额：</td>
        <td><input name="money" type="text" id="money" value="<?php echo $post['money']; ?>" size="10"></td>
    </tr>
    <tr>
        <td align="right">说明：</td>
        <td><input name="des" type="text" id="des" value="<?php echo $post['des']; ?>" style="width:60%"></td>
    </tr>
    <tr>
        <td align="right">电话：</td>
        <td><input name="tel" type="text" id="tel" value="<?php echo $post['tel']; ?>" size="15"></td>
    </tr>
    <tr>
        <td align="right">官网：</td>
        <td><input name="website" type="text" id="website" value="<?php echo $post['website']; ?>" size="30"></td>
    </tr>
    <tr>
        <td align="right">是否显示：</td>
        <td>
			<input type="radio" value='0' name="status" <?php if(isset($post['status']) && $post['status']==0){echo 'checked';} ?> />&nbsp;是&nbsp;&nbsp;
			<input type="radio" value='1' name="status" <?php if(isset($post['status']) && $post['status']==1){echo 'checked';} ?> />&nbsp;否
		</td>
    </tr>
    <tr>
        <td align="right">排序：</td>
        <td>
			<input name="listorder" type="text" id="listorder" value="<?php echo $post['listorder']; ?>" size="3" />
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