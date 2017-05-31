<!DOCTYPE html><html><head><title>添加Tag_后台管理</title>@include('admin.common.header')
<div class="container-fluid">
<div class="row">
<!-- 左边开始 --><div class="col-sm-3 col-md-2 sidebar">@include('admin.common.leftmenu')</div><!-- 左边结束 -->

<!-- 右边开始 --><div class="col-sm-9 col-md-10 rightbox"><div id="mainbox">
<h5 class="sub-header"><a href="/fladmin/tag">Tag列表</a> > 添加Tag</h5>

<form id="addarc" method="post" action="/fladmin/tag/doadd" role="form" enctype="multipart/form-data" class="table-responsive">{{ csrf_field() }}
<table class="table table-striped table-bordered">
<tbody>
    <tr>
        <td align="right">Tag名称：</td>
        <td><input name="tag" type="text" id="tag" value="" class="required" style="width:30%" placeholder="在此输入名称"></td>
    </tr>
	<tr>
        <td align="right">是否审核：</td>
        <td>
			<input type="radio" value='1' name="ischeck" checked />&nbsp;是&nbsp;&nbsp;
			<input type="radio" value='0' name="ischeck" />&nbsp;否
		</td>
    </tr>
    <tr>
        <td align="right">别名：</td>
        <td><input name="filename" type="text" id="filename" class="required" value="" size="20"> </td>
    </tr>
    <tr>
        <td align="right">Tag标题：</td>
        <td><input name="title" type="text" id="title" value="" style="width:60%"></td>
    </tr>
    <tr>
        <td align="right">模板名称：</td>
        <td><input name="template" type="text" id="template" value="tag" size="20"></td>
    </tr>
    <tr>
        <td align="right" style="vertical-align:middle;">缩略图：</td>
        <td style="vertical-align:middle;"><button type="button" onclick="upImage();">选择图片</button> <input name="litpic" type="text" id="litpic" value="" style="width:40%"> <img style="margin-left:20px;display:none;" src="" width="120" height="80" id="picview"></td>
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
        <td align="right">Tag关键字：</td>
        <td><input type="text" name="keywords" id="keywords" style="width:50%" value=""> (用,分开)</td>
    </tr>
    <tr>
        <td align="right" style="vertical-align:middle;">Tag摘要信息：</td>
        <td><textarea name="description" rows="5" id="description" style="width:80%;height:70px;vertical-align:middle;"></textarea></td>
    </tr>
    <tr>
        <td align="right" style="vertical-align:middle;">Tag文章列表：</td>
        <td><textarea name="tagarc" rows="5" id="tagarc" style="width:80%;height:70px;vertical-align:middle;"></textarea> (用,分开)</td>
    </tr>
    <tr>
        <td colspan="2"><strong>Tag内容：</strong></td>
    </tr>
    <tr>
        <td colspan="2">
<!-- 加载编辑器的容器 --><script id="container" name="content" type="text/plain"></script>
<!-- 配置文件 --><script type="text/javascript" src="/other/flueditor/ueditor.config.js"></script>
<!-- 编辑器源码文件 --><script type="text/javascript" src="/other/flueditor/ueditor.all.js"></script>
<!-- 实例化编辑器 --><script type="text/javascript">var ue = UE.getEditor('container',{maximumWords:100000,initialFrameHeight:320,enableAutoSave:false});</script></td>
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
            if( $(this).is('#filename') ){
                var reg = /^[a-zA-Z]+[0-9]*[a-zA-Z0-9]*$/;//验证是否为字母、数字
                if(!reg.test($("#filename").val()))
                {
                    $parent.append(' <small class="formtips onError"><font color="red">格式不正确！</font></small>');
                }
                else
                {
                    $parent.append(' <small class="formtips onSuccess"><font color="green">OK</font></small>');
                }
            }
            else
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