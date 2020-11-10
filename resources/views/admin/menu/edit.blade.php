@extends('admin.layouts.app')
@section('title', '菜单修改')

@section('content')
<h5 class="sub-header"><a href="/fladmin/menu">菜单列表</a> > 菜单修改</h5>

<form id="addarc" method="post" action="/fladmin/menu/doedit" role="form" enctype="multipart/form-data" class="table-responsive">{{ csrf_field() }}
<table class="table table-striped table-bordered">
<tbody>
    <tr>
        <td align="right">上级：</td>
        <td>
            <select name="pid" id="pid">
                <option value="0">顶级菜单</option>
                <?php if($menu){foreach($menu as $row){ ?>
                <?php if($row["id"]==$post["pid"]){ ?>
                <option selected value="<?php echo $row["id"]; ?>"><?php for($i=0;$i<$row["deep"];$i++){echo "—";}echo $row["name"]; ?></option>
                <?php }else{ ?>
                <option value="<?php echo $row["id"]; ?>"><?php for($i=0;$i<$row["deep"];$i++){echo "—";}echo $row["name"]; ?></option>
                <?php }}} ?>
            </select>
        </td>
    </tr>
    <tr>
        <td align="right">名称：</td>
        <td><input name="name" type="text" id="name" value="<?php echo $post["name"]; ?>" class="required" style="width:30%" placeholder="在此输入菜单名称"><input style="display:none;" name="id" type="text" id="id" value="<?php echo $id; ?>"></td>
    </tr>
    <tr>
        <td align="right">操作方法：</td>
        <td><input name="action" type="text" id="action" value="<?php echo $post["action"]; ?>" class="required" style="width:30%"></td>
    </tr>
    <tr>
        <td align="right">参数：</td>
        <td><input name="data" type="text" id="data" value="<?php echo $post["data"]; ?>" style="width:30%"></td>
    </tr>
    <tr>
        <td align="right">图标：</td>
        <td><input name="icon" type="text" id="icon" value="<?php echo $post["icon"]; ?>" style="width:30%"> <small style="color:#999">(Glyphicons字体图标，如glyphicon glyphicon-home)</small></td>
    </tr>
    <tr>
        <td align="right">备注：</td>
        <td><input name="des" type="text" id="des" value="<?php echo $post["des"]; ?>" style="width:50%"></td>
    </tr>
    <tr>
        <td align="right">排序：</td>
        <td><input name="listorder" type="text" id="listorder" value="<?php echo $post["listorder"]; ?>" style="width:30%"></td>
    </tr>
    <tr>
        <td align="right">状态：</td>
        <td>
            <input type="radio" value='1' name="status" <?php if($post['status']==1){echo 'checked';} ?> />&nbsp;显示&nbsp;&nbsp;
            <input type="radio" value='0' name="status" <?php if($post['status']==0){echo 'checked';} ?> />&nbsp;隐藏
        </td>
    </tr>
    <tr>
        <td align="right">类型：</td>
        <td>
            <input type="radio" value='1' name="type" <?php if($post['type']==1){echo 'checked';} ?> />&nbsp;权限认证+菜单&nbsp;&nbsp;
            <input type="radio" value='0' name="type" <?php if($post['type']==0){echo 'checked';} ?> />&nbsp;只作为菜单
            <br><small style="color:#999">注意：“权限认证+菜单”表示加入后台权限管理，纯碎是菜单项请不要选择此项。</small>
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