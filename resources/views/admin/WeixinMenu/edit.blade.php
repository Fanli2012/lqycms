@extends('admin.layouts.app')
@section('title', '菜单修改')

@section('content')
<h5 class="sub-header"><a href="/fladmin/weixinmenu">菜单管理</a> > 菜单修改</h5>

<form method="post" action="/fladmin/weixinmenu/doedit" role="form" id="addcat" class="table-responsive">{{ csrf_field() }}
<table class="table table-striped table-bordered">
  <tbody>
    <tr>
      <td align="right">名称：</td>
      <td><input name="name" type="text" value="<?php echo $post["name"]; ?>" id="name" size="30" class="required"><input style="display:none;" type="text" name="id" id="id" value="<?php echo $id; ?>"></td>
    </tr>
    <tr>
        <td align="right">菜单的响应动作类型：</td>
        <td><input name="type" type="text" value="<?php echo $post["type"]; ?>" id="type" style="width:30%"> <small>(view表示网页，click表示点击，miniprogram表示小程序)</small></td>
    </tr>
    <tr>
      <td align="right">菜单KEY值：</td>
      <td><input name="key" id="key" type="text" value="<?php echo $post["key"]; ?>" size="30"> <small>(click等点击类型必须)</small></td>
    </tr>
    <tr>
      <td align="right">网页链接：</td>
      <td><input name="url" id="url" type="text" value="<?php echo $post["url"]; ?>" size="50"> <small>(view、miniprogram类型必须)</small></td>
    </tr>
    <tr>
      <td align="right">media_id：</td>
      <td><input name="media_id" type="text" style="width:70%" id="media_id" class="alltxt" value="<?php echo $post["media_id"]; ?>"></td>
    </tr>
    <tr>
      <td align="right">appid：</td>
      <td><input name="appid" type="text" style="width:50%" id="appid" class="alltxt" value="<?php echo $post["appid"]; ?>"></td>
    </tr>
    <tr>
      <td align="right">pagepath：</td>
      <td><input name="pagepath" type="text" style="width:50%" id="pagepath" class="alltxt" value="<?php echo $post["pagepath"]; ?>"></td>
    </tr>
    <tr>
        <td align="right">是否显示：</td>
        <td>
			<input type="radio" value='0' name="is_show" <?php if(isset($post['is_show']) && $post['is_show']==0){echo 'checked';} ?> />&nbsp;是&nbsp;&nbsp;
			<input type="radio" value='1' name="is_show" <?php if(isset($post['is_show']) && $post['is_show']==1){echo 'checked';} ?> />&nbsp;否
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