@extends('admin.layouts.app')
@section('title', '品牌修改')

@section('content')
<h5 class="sub-header"><a href="/fladmin/goodsbrand">品牌列表</a> > 品牌修改</h5>

<form id="addarc" method="post" action="/fladmin/goodsbrand/doedit" role="form" enctype="multipart/form-data" class="table-responsive">{{ csrf_field() }}
<table class="table table-striped table-bordered">
<tbody>
    <tr>
        <td align="right">名称：</td>
        <td><input name="title" type="text" id="title" value="<?php echo $post["title"]; ?>" class="required" style="width:60%" placeholder="在此输入标题"> <input style="display:none;" type="text" name="id" id="id" value="<?php echo $id; ?>"></td>
    </tr>
    <tr>
        <td align="right">是否显示：</td>
        <td>
			<input type="radio" value='0' name="status" <?php if(isset($post['status']) && $post['status']==0){echo 'checked';} ?> />&nbsp;是&nbsp;&nbsp;
			<input type="radio" value='1' name="status" <?php if(isset($post['status']) && $post['status']==1){echo 'checked';} ?> />&nbsp;否
		</td>
    </tr>
    <tr>
        <td align="right">排序：</td>
        <td>
			<input name="listorder" type="text" id="listorder" value="<?php echo $post['listorder']; ?>" size="3" />
		</td>
    </tr>
    <tr>
        <td align="right" style="vertical-align:middle;">缩略图：</td>
        <td style="vertical-align:middle;"><button type="button" onclick="upImage();">选择图片</button> <input name="litpic" type="text" id="litpic" value="<?php echo $post["litpic"]; ?>" style="width:40%"> <img style="margin-left:20px;<?php if(empty($post["litpic"]) || !imgmatch($post["litpic"])){ echo "display:none;"; } ?>" src="<?php if(imgmatch($post["litpic"])){echo $post["litpic"];} ?>" width="120" height="80" id="picview" name="picview"></td>
    </tr>
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
			$('#litpic').val(arg[0].src);
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
        <td align="right" style="vertical-align:middle;">封面：</td>
        <td style="vertical-align:middle;"><button type="button" onclick="upImage2();">选择图片</button> <input name="cover_img" type="text" id="cover_img" value="<?php echo $post["cover_img"]; ?>" style="width:40%"> <img style="margin-left:20px;<?php if(empty($post["cover_img"]) || !imgmatch($post["cover_img"])){ echo "display:none;"; } ?>" src="<?php if(imgmatch($post["cover_img"])){echo $post["cover_img"];} ?>" width="120" height="80" id="picview2"></td>
    </tr>
<script type="text/javascript">
var _editor2;
$(function() {
    //重新实例化一个编辑器，防止在上面的editor编辑器中显示上传的图片或者文件
    _editor2 = UE.getEditor('ueditorimg2');
    _editor2.ready(function () {
        //设置编辑器不可用
        _editor2.setDisabled('insertimage');
        //隐藏编辑器，因为不会用到这个编辑器实例，所以要隐藏
        _editor2.hide();
        //侦听图片上传
        _editor2.addListener('beforeInsertImage', function (t, arg) {
            //将地址赋值给相应的input,只取第一张图片的路径
			$('#cover_img').val(arg[0].src);
            //图片预览
            $('#picview2').attr("src",arg[0].src).css("display","inline-block");
        })
    });
});
//弹出图片上传的对话框
function upImage2()
{
    var myImage = _editor2.getDialog("insertimage");
	myImage.render();
    myImage.open();
}
</script>
<script type="text/plain" id="ueditorimg2"></script>
    <tr>
        <td colspan="2"><strong>页面内容：</strong></td>
    </tr>
    <tr>
        <td colspan="2">
<!-- 加载编辑器的容器 --><script id="container" name="content" type="text/plain"><?php echo $post["content"]; ?></script>
<!-- 配置文件 --><script type="text/javascript" src="/other/flueditor/ueditor.config.js"></script>
<!-- 编辑器源码文件 --><script type="text/javascript" src="/other/flueditor/ueditor.all.min.js"></script>
<!-- 实例化编辑器 --><script type="text/javascript">var ue = UE.getEditor('container',{maximumWords:100000,initialFrameHeight:320,enableAutoSave:false});</script></td>
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