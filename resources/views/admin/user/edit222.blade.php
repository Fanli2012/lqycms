<!DOCTYPE html><html><head><title>密码修改_后台管理</title>@include('admin.common.header')
<div class="container-fluid">
<div class="row">
<!-- 左边开始 --><div class="col-sm-3 col-md-2 sidebar">@include('admin.common.leftmenu')</div><!-- 左边结束 -->
<style>.input-error{background-color:#ffe7e7;}</style>
<!-- 右边开始 --><div class="col-sm-9 col-md-10 rightbox"><div id="mainbox">
<h2 class="sub-header">密码修改</h2>
<form id="addarc" method="post" action="/fladmin/user/doedit" class="table-responsive" role="form">{{ csrf_field() }}
<table class="table table-striped table-bordered">
<tbody>
    <tr>
        <td align="right">用户名：</td>
        <td><input name="username" type="text" class="" id="username" value="<?php echo $post["username"]; ?>" style="width:30%"></td>
    </tr>
    <tr>
        <td align="right">旧密码：</td>
        <td><input name="oldpwd" type="password" class="" id="oldpwd" value="" style="width:30%"></td>
    </tr>
    <tr>
        <td align="right">新密码：</td>
        <td><input name="newpwd" type="password" class="" id="newpwd" value="" style="width:30%"></td>
    </tr>
    <tr>
        <td align="right">确认密码：</td>
        <td><input name="newpwd2" type="password" class="" id="newpwd2" value="" style="width:30%"></td>
    </tr>
    <tr>
        <td colspan="2"><button type="submit" class="btn btn-success" value="Submit">保存(Submit)</button>&nbsp;&nbsp;<button type="reset" class="btn btn-default" value="Reset">重置(Reset)</button><input type="hidden"></input></td>
    </tr>
</tbody></table></form><!-- 表单结束 -->
</div></div><!-- 右边结束 --></div></div>
<script>
$('#addarc input[type="text"], #addarc input[type="password"]').on('focus', function() {
	$(this).removeClass('input-error');
});
$('#addarc').on('submit', function(e) {
    $(this).find('input[type="text"], input[type="password"]').each(function(){
		if( $(this).val() == "" ) {
			e.preventDefault();
			$(this).addClass('input-error');
		}
		else {
			$(this).removeClass('input-error');
		}
	});
    if($('#newpwd').val()!=$('#newpwd2').val() || $('#newpwd').val()=='')
    {
        e.preventDefault();
        $('#newpwd').addClass('input-error');
        $('#newpwd2').addClass('input-error');
    }
    else {
        $('#newpwd').removeClass('input-error');
        $('#newpwd2').removeClass('input-error');
    }
});
</script>
</body></html>