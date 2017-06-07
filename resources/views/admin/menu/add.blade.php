<!DOCTYPE html><html><head><title>菜单添加_后台管理</title>@include('admin.common.header')
<div class="container-fluid">
<div class="row">
<!-- 左边开始 --><div class="col-sm-3 col-md-2 sidebar">@include('admin.common.leftmenu')</div><!-- 左边结束 -->

<!-- 右边开始 --><div class="col-sm-9 col-md-10 rightbox"><div id="mainbox">
<h5 class="sub-header"><a href="/fladmin/menu">菜单列表</a> > 菜单添加</h5>

<form id="addarc" method="post" action="/fladmin/menu/doadd" role="form" enctype="multipart/form-data" class="table-responsive">{{ csrf_field() }}
<table class="table table-striped table-bordered">
<tbody>
    <tr>
        <td align="right">上级：</td>
        <td>
            <select name="pid" id="pid">
                <option value="0">顶级菜单</option>
                <?php if($menu){foreach($menu as $row){ ?>
                <option value="<?php echo $row["id"]; ?>"><?php for($i=0;$i<$row["deep"];$i++){echo "—";}echo $row["name"]; ?></option>
                <?php }} ?>
            </select>
        </td>
    </tr>
    <tr>
        <td align="right">名称：</td>
        <td><input name="name" type="text" id="name" value="" class="required" style="width:30%" placeholder="在此输入菜单名称"></td>
    </tr>
    <tr>
        <td align="right">操作方法：</td>
        <td><input name="action" type="text" id="action" value="" class="required" style="width:30%"></td>
    </tr>
    <tr>
        <td align="right">参数：</td>
        <td><input name="data" type="text" id="data" value="" style="width:30%"></td>
    </tr>
    <tr>
        <td align="right">图标：</td>
        <td><input name="icon" type="text" id="icon" value="" style="width:30%"></td>
    </tr>
    <tr>
        <td align="right">备注：</td>
        <td><input name="des" type="text" id="des" value="" style="width:50%"></td>
    </tr>
    <tr>
        <td align="right">状态：</td>
        <td>
            <input type="radio" value='1' name="status" checked />&nbsp;显示&nbsp;&nbsp;
            <input type="radio" value='0' name="status" />&nbsp;隐藏
        </td>
    </tr>
    <tr>
        <td align="right">状态：</td>
        <td>
            <input type="radio" value='1' name="type" checked />&nbsp;权限认证+菜单&nbsp;&nbsp;
            <input type="radio" value='0' name="type" />&nbsp;只作为菜单<br><small style="color:#999">注意：“权限认证+菜单”表示加入后台权限管理，纯碎是菜单项请不要选择此项。</small>
        </td>
    </tr>
    <tr>
        <td colspan="2"><button type="submit" class="btn btn-success" value="Submit">保存(Submit)</button>&nbsp;&nbsp;<button type="reset" class="btn btn-default" value="Reset">重置(Reset)</button><input type="hidden"></input></td>
    </tr>
</tbody></table></form><!-- 表单结束 -->
</div></div><!-- 右边结束 --></div></div>

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
</body></html>