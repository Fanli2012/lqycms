@extends('admin.layouts.app')
@section('title', '关键词添加')

@section('content')
<h5 class="sub-header"><a href="/fladmin/keyword">关键词列表</a> > 添加关键词</h5>

<form id="addarc" method="post" action="/fladmin/keyword/doadd" role="form" enctype="multipart/form-data" class="table-responsive">{{ csrf_field() }}
<table class="table table-striped table-bordered">
<tbody>
    <tr>
        <td>关键词：</td>
        <td><input name="keyword" type="text" id="keyword" value="" class="required" style="width:30%" placeholder="在此输入关键词"></td>
    </tr>
    <tr>
        <td>链接网址：</td>
        <td><input name="rpurl" type="text" id="rpurl" value="http://" style="width:60%" class="required"> (请用绝对地址)</td>
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