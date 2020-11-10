@extends('admin.layouts.app')
@section('title', '广告添加')

@section('content')
<script language="javascript" type="text/javascript" src="/js/My97DatePicker/WdatePicker.js"></script>
<h5 class="sub-header"><a href="/fladmin/ad">广告列表</a> > 添加广告</h5>

<form id="addarc" method="post" action="/fladmin/ad/add" role="form" enctype="multipart/form-data" class="table-responsive">{{ csrf_field() }}
<table class="table table-striped table-bordered">
<tbody>
    <tr>
        <td align="right"><font color="red">*</font>名称：</td>
        <td><input name="name" type="text" id="name" value="" class="required" style="width:30%" placeholder="在此输入名称"></td>
    </tr>
    <tr>
        <td align="right" style="vertical-align:middle;">描述：</td>
        <td><textarea name="description" rows="3" id="description" style="width:60%;vertical-align:middle;"></textarea></td>
    </tr>
    <tr>
        <td align="right">广告位标识：</td>
        <td><input name="flag" type="text" id="flag" value="" style="width:185px" class=""></td>
    </tr>
    <tr>
        <td align="right">时间限制：</td>
        <td>
			<input type="radio" value='0' name="is_expire" checked />&nbsp;永不过期&nbsp;&nbsp;
			<input type="radio" value='1' name="is_expire" />&nbsp;在设内时间内有效
		</td>
    </tr>
    <tr>
        <td align="right">投放开始时间：</td>
        <td colspan="2"><input autocomplete="off" name="start_time" onClick="WdatePicker({el:this,dateFmt:'yyyy-MM-dd HH:mm:ss'})" type="text" id="start_time" style="width:185px" value="<?php echo date('Y-m-d H:i:s'); ?>">&nbsp;&nbsp; 投放结束时间：<input autocomplete="off" name="end_time" onClick="WdatePicker({el:this,dateFmt:'yyyy-MM-dd HH:mm:ss'})" type="text" id="end_time" style="width:185px" value="<?php echo date('Y-m-d H:i:s'); ?>"></td>
    </tr>
    <tr>
        <td align="right" style="vertical-align:middle;"><font color="red">*</font>广告内容：</td>
        <td><textarea name="content" rows="5" id="content" style="width:60%;vertical-align:middle;"></textarea></td>
    </tr>
    <tr>
        <td align="right" style="vertical-align:middle;">广告内容-移动端：</td>
        <td><textarea name="content_wap" rows="5" id="content_wap" style="width:60%;vertical-align:middle;"></textarea></td>
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