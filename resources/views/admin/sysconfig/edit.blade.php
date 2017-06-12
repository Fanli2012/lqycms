@extends('admin.layouts.app')
@section('title', '参数修改')

@section('content')
<h5 class="sub-header"><a href="/fladmin/sysconfig">系统配置参数</a> > 参数修改</h5>

<form id="addarc" method="post" action="/fladmin/sysconfig/doedit" role="form" enctype="multipart/form-data" class="table-responsive">{{ csrf_field() }}
<table class="table table-striped table-bordered">
<tbody>
    <tr>
        <td align="right">参数名称：</td>
        <td><input name="varname" type="text" id="varname" value="<?php echo $post["varname"]; ?>" class="required" style="width:30%" placeholder="在此输入参数变量">(必须是字母)<input style="display:none;" name="id" type="text" id="id" value="<?php echo $id; ?>"></td>
    </tr>
    <tr>
        <td align="right">参数说明：</td>
        <td><input name="info" type="text" id="info" value="<?php echo $post["info"]; ?>" style="width:60%"></td>
    </tr>
    <tr>
        <td align="right">参数值：</td>
        <td><textarea name="value" rows="5" id="value" style="width:80%;height:70px;vertical-align:middle;"><?php echo $post["value"]; ?></textarea></td>
    </tr>
    <tr>
        <td colspan="2"><button type="submit" class="btn btn-success" value="Submit">保存(Submit)</button>&nbsp;&nbsp;<button type="reset" class="btn btn-default" value="Reset">重置(Reset)</button><input type="hidden"></input></td>
    </tr>
</tbody></table></form><!-- 表单结束 -->
<script>
$(function(){
	var bempty = true;
    $("#varname").blur(function(){
        var reg = /^cms_[a-z]+$/i; // 创建正则表达式模式
        var str = this.value;
        if(!str.match(reg)){bempty=false;alert('输入错误，请重新输入！');}else{bempty=true}
    });
    $(".required").blur(function(){
        var $parent = $(this).parent();
        $parent.find(".formtips").remove();
        if(this.value=="")
        {
            $parent.append(' <small class="formtips onError"><font color="red">不能为空！</font></small>');
        }
        else
        {
            if(bempty)
            {
                $parent.append(' <small class="formtips onSuccess"><font color="green">OK</font></small>');
            }
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