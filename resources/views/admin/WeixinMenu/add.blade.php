@extends('admin.layouts.app')
@section('title', '栏目添加')

@section('content')
<h5 class="sub-header"><a href="/fladmin/weixinmenu">栏目管理</a> > 栏目添加</h5>

<form method="post" action="/fladmin/weixinmenu/doadd" role="form" id="addcat" class="table-responsive">{{ csrf_field() }}
<table class="table table-striped table-bordered">
  <tbody>
    <tr>
      <td align="right">名称：</td>
      <td><input name="name" type="text" id="name" size="30" class="required"></td>
    </tr>
    <tr>
      <td align="right">上级菜单：</td>
      <td><?php if($id==0){echo "顶级栏目";}else{echo $postone["name"];} ?><input style="display:none;" type="text" name="prid" id="prid" value="<?php if($id==0){echo "top";}else{echo $id;} ?>"></td>
    </tr>
    <tr>
        <td align="right">菜单的响应动作类型：</td>
        <td><input name="type" type="text" value="" id="type" style="width:30%"> <small>(view表示网页，click表示点击，miniprogram表示小程序)</small></td>
    </tr>
    <tr>
      <td align="right">菜单KEY值：</td>
      <td><input name="key" id="key" type="text" value="" size="30"> <small>(click等点击类型必须)</small></td>
    </tr>
    <tr>
      <td align="right">网页链接：</td>
      <td><input name="url" id="url" type="text" value="" size="50"> <small>(view、miniprogram类型必须)</small></td>
    </tr>
    <tr>
      <td align="right">media_id：</td>
      <td><input name="media_id" type="text" style="width:70%" id="media_id" class="alltxt" value=""></td>
    </tr>
    <tr>
      <td align="right">appid：</td>
      <td><input name="appid" type="text" style="width:50%" id="appid" class="alltxt" value=""></td>
    </tr>
    <tr>
      <td align="right">pagepath：</td>
      <td><input name="pagepath" type="text" style="width:50%" id="pagepath" class="alltxt" value=""></td>
    </tr>
    <tr>
        <td align="right">是否显示：</td>
        <td>
			<input type="radio" value='0' name="is_show" checked />&nbsp;是&nbsp;&nbsp;
			<input type="radio" value='1' name="is_show" />&nbsp;否
		</td>
    </tr>
    <tr>
      <td colspan="2"><input type="submit" class="btn btn-success" value="保存(Submit)">&nbsp;&nbsp;<input type="reset" class="btn btn-default" value="重置(Reset)"></td>
    </tr>
  </tbody>
</table>
</form><!-- 表单结束 -->
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
    $('#addcat input[type="reset"]').click(function(){
            $(".formtips").remove(); 
    });
});

$('#addcat input[type="submit"]').click(function(){
    $(".required").trigger('blur');
    var numError = $('#addcat .onError').length;

    if(numError){
        return false;
    }
});
</script>
@endsection