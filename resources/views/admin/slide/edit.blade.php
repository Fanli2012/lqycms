<!DOCTYPE html><html><head><title>轮播图修改_后台管理</title>@include('admin.common.header')
<div class="container-fluid">
<div class="row">
<!-- 左边开始 --><div class="col-sm-3 col-md-2 sidebar">@include('admin.common.leftmenu')</div><!-- 左边结束 -->

<!-- 右边开始 --><div class="col-sm-9 col-md-10 rightbox"><div id="mainbox">
<h5 class="sub-header"><a href="/fladmin/slide">轮播图列表</a> > 轮播图修改</h5>

<form id="addarc" method="post" action="/fladmin/slide/doedit" role="form" enctype="multipart/form-data" class="table-responsive">{{ csrf_field() }}
<table class="table table-striped table-bordered">
<tbody>
    <tr>
        <td align="right">标题：</td>
        <td><input name="title" type="text" id="title" value="<?php echo $post['title']; ?>" class="required" style="width:30%" placeholder="在此输入关键词"><input style="display:none;" name="id" type="text" id="id" value="<?php echo $id; ?>"></td>
    </tr>
    <tr>
        <td align="right">链接网址：</td>
        <td><input name="url" type="text" id="url" value="<?php echo $post['url']; ?>" style="width:60%" class="required"> (请用绝对地址)</td>
    </tr>
    <tr>
        <td align="right">跳转方式：</td>
        <td>
			<input type="radio" value='0' name="target" <?php if(isset($post['target']) && $post['target']==0){echo 'checked';} ?> />&nbsp;_blank&nbsp;&nbsp;
			<input type="radio" value='1' name="target" <?php if(isset($post['target']) && $post['target']==1){echo 'checked';} ?> />&nbsp;_self
		</td>
    </tr>
    <tr>
        <td align="right">是否显示：</td>
        <td>
			<input type="radio" value='0' name="is_show" <?php if(isset($post['is_show']) && $post['is_show']==0){echo 'checked';} ?> />&nbsp;是&nbsp;&nbsp;
			<input type="radio" value='1' name="is_show" <?php if(isset($post['is_show']) && $post['is_show']==1){echo 'checked';} ?> />&nbsp;否
		</td>
    </tr>
    <tr>
        <td align="right">排序：</td>
        <td>
			<input name="rank" type="text" id="rank" value="<?php echo $post['rank']; ?>" size="3" />
		</td>
    </tr>
    <tr>
        <td align="right">所属的组：</td>
        <td>
			<input name="group_id" type="text" id="group_id" value="<?php echo $post['group_id']; ?>" size="3" />
		</td>
    </tr>
    <tr>
        <td style="vertical-align:middle;" align="right">图片：</td>
        <td style="vertical-align:middle;"><button type="button" onclick="upImage();">选择图片</button> <input name="pic" type="text" id="pic" value="<?php echo $post['pic']; ?>" style="width:40%"> <img style="margin-left:20px;<?php if(empty($post["pic"]) || !imgmatch($post["pic"])){ echo "display:none;"; } ?>" src="<?php if(imgmatch($post["pic"])){echo $post["pic"];} ?>" width="120" height="80" id="picview"></td>
    </tr>
<!-- 配置文件 --><script type="text/javascript" src="/other/flueditor/ueditor.config.js"></script>
<!-- 编辑器源码文件 --><script type="text/javascript" src="/other/flueditor/ueditor.all.js"></script>
<script type="text/javascript">
var _editor;
$(function() {
    //重新实例化一个编辑器，防止在上面的editor编辑器中显示上传的图片或者文件
    _editor = UE.getEditor('ueditorimg');
    _editor.ready(function () {
        //设置编辑器不可用
        _editor.setDisabled('insertimage');
        //隐藏编辑器，因为不会用到这个编辑器实例，所以要隐藏
        _editor.hide();
        //侦听图片上传
        _editor.addListener('beforeInsertImage', function (t, arg) {
            //将地址赋值给相应的input,只取第一张图片的路径
			$('#pic').val(arg[0].src);
            //图片预览
            $('#picview').attr("src",arg[0].src).css("display","inline-block");
        })
    });
});
//弹出图片上传的对话框
function upImage()
{
    var myImage = _editor.getDialog("insertimage");
	myImage.render();
    myImage.open();
}
</script>
<script type="text/plain" id="ueditorimg"></script>
    <tr>
        <td colspan="2"><button type="submit" class="btn btn-success" value="Submit">保存(Submit)</button>&nbsp;&nbsp;<button type="reset" class="btn btn-default" value="Reset">重置(Reset)</button></td>
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