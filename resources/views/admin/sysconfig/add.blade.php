<!DOCTYPE html><html><head><title>添加参数_后台管理</title>@include('admin.common.header')
<div class="container-fluid">
<div class="row">
<!-- 左边开始 --><div class="col-sm-3 col-md-2 sidebar">@include('admin.common.leftmenu')</div><!-- 左边结束 -->

<!-- 右边开始 --><div class="col-sm-9 col-md-10 rightbox"><div id="mainbox">
<h5 class="sub-header"><a href="/fladmin/sysconfig">系统配置参数</a> > 添加参数</h5>

<form id="addarc" method="post" action="/fladmin/sysconfig/doadd" role="form" enctype="multipart/form-data" class="table-responsive">{{ csrf_field() }}
<table class="table table-striped table-bordered">
<tbody>
    <tr>
        <td align="right">参数名称：</td>
        <td><input name="varname" type="text" id="varname" value="CMS_" class="required" style="width:30%" placeholder="在此输入参数变量">(必须是字母)</td>
    </tr>
    <tr>
        <td align="right">参数说明：</td>
        <td><input name="info" type="text" id="info" value="" style="width:60%"></td>
    </tr>
    <tr>
        <td align="right">参数值：</td>
        <td><textarea name="value" rows="5" id="value" style="width:80%;height:70px;vertical-align:middle;"></textarea></td>
    </tr>
    <tr>
        <td colspan="2"><button type="submit" class="btn btn-success" value="Submit">保存(Submit)</button>&nbsp;&nbsp;<button type="reset" class="btn btn-default" value="Reset">重置(Reset)</button><input type="hidden"></input></td>
    </tr>
</tbody></table></form><!-- 表单结束 -->
</div></div><!-- 右边结束 --></div></div>

<script>
$(function(){
    var bempty = true;
    $("#varname").blur(function(){
        var reg = /^CMS_[a-z]+$/i; // 创建正则表达式模式
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
</body></html>