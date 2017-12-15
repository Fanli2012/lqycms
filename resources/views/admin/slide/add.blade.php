@extends('admin.layouts.app')
@section('title', '轮播图添加')

@section('content')
<h5 class="sub-header"><a href="/fladmin/slide">轮播图列表</a> > 添加轮播图</h5>

<form id="addarc" method="post" action="/fladmin/slide/doadd" role="form" enctype="multipart/form-data" class="table-responsive">{{ csrf_field() }}
<table class="table table-striped table-bordered">
<tbody>
    <tr>
        <td align="right">标题：</td>
        <td><input name="title" type="text" id="title" value="" class="required" style="width:30%" placeholder="在此输入关键词"></td>
    </tr>
    <tr>
        <td align="right">链接网址：</td>
        <td><input name="url" type="text" id="url" value="http://" style="width:60%" class="required"> (请用绝对地址)</td>
    </tr>
    <tr>
        <td align="right">跳转方式：</td>
        <td>
			<input type="radio" value='0' name="target" checked />&nbsp;_blank&nbsp;&nbsp;
			<input type="radio" value='1' name="target" />&nbsp;_self
		</td>
    </tr>
    <tr>
        <td align="right">显示平台：</td>
        <td>
			<input type="radio" value='0' name="type" checked />&nbsp;pc&nbsp;&nbsp;
			<input type="radio" value='1' name="type" />&nbsp;weixin&nbsp;&nbsp;
			<input type="radio" value='2' name="type" />&nbsp;app&nbsp;&nbsp;
			<input type="radio" value='3' name="type" />&nbsp;wap
		</td>
    </tr>
    <tr>
        <td align="right">是否显示：</td>
        <td>
			<input type="radio" value='0' name="is_show" checked />&nbsp;是&nbsp;&nbsp;
			<input type="radio" value='1' name="is_show" />&nbsp;否
		</td>
    </tr>
    <tr>
        <td align="right">排序：</td>
        <td>
			<input name="listorder" type="text" id="listorder" value="50" size="3" />
		</td>
    </tr>
    <tr>
        <td align="right">所属的组：</td>
        <td>
			<input name="group_id" type="text" id="group_id" value="0" size="3" />
		</td>
    </tr>
    <tr>
        <td style="vertical-align:middle;" align="right">图片：</td>
        <td style="vertical-align:middle;"><button type="button" onclick="upImage();">选择图片</button> <input class="required" name="pic" type="text" id="pic" value="" style="width:40%"> <img style="margin-left:20px;display:none;" src="" width="120" height="80" id="picview"></td>
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