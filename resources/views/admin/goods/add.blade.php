@extends('admin.layouts.app')
@section('title', '商品添加')

@section('content')
<script language="javascript" type="text/javascript" src="http://<?php echo env('APP_DOMAIN'); ?>/js/My97DatePicker/WdatePicker.js"></script>
<h5 class="sub-header"><a href="/fladmin/goods">商品列表</a> > 添加商品</h5>

<form id="addarc" method="post" action="/fladmin/goods/doadd" role="form" enctype="multipart/form-data" class="table-responsive">{{ csrf_field() }}
<table class="table table-striped table-bordered">
<tbody>
    <tr>
        <td align="right">商品标题：</td>
        <td><input name="title" type="text" id="title" value="" class="required" style="width:60%" placeholder="在此输入标题"></td>
    </tr>
	<tr>
        <td align="right">货号：</td>
        <td colspan="2"><input name="sn" type="text" id="sn" style="width:180px" value="">&nbsp;&nbsp; 运费：<input name="shipping_fee" type="text" id="shipping_fee" style="width:100px" value="">&nbsp;&nbsp; 销量：<input name="sale" type="text" id="sale" style="width:60px" value=""></td>
    </tr>
    <tr>
        <td align="right">商品价格：</td>
        <td colspan="2"><input name="price" type="text" id="price" style="width:100px" value="">&nbsp;&nbsp; 原价：<input name="market_price" type="text" id="market_price" style="width:100px" value="">&nbsp;&nbsp; 库存：<input name="goods_number" type="text" id="goods_number" style="width:60px" value="">&nbsp;&nbsp; 浏览次数：<input type="text" name="click" id="click" value="" style="width:60px;"></td>
    </tr>
	<tr>
        <td align="right">上架：</td>
        <td>
			<input type="radio" value='0' name="status" checked />&nbsp;是&nbsp;&nbsp;
			<input type="radio" value='2' name="status" />&nbsp;否
		</td>
    </tr>
    <tr>
        <td align="right">活动价：</td>
        <td colspan="2"><input name="promote_price" type="text" id="promote_price" style="width:80px" value="">&nbsp;&nbsp; 活动开始日期：<input name="promote_start_date" onClick="WdatePicker({el:this,dateFmt:'yyyy-MM-dd HH:mm:ss'})" type="text" id="promote_start_date" style="width:185px" value="">&nbsp;&nbsp; 活动结束日期：<input name="promote_end_date" onClick="WdatePicker({el:this,dateFmt:'yyyy-MM-dd HH:mm:ss'})" type="text" id="promote_end_date" style="width:185px" value=""></td>
    </tr>
    <tr>
        <td align="right">推荐：</td>
        <td>
            <select name="tuijian" id="tuijian">
                <?php $tuijian = config('custom.tuijian');
                for($i=0;$i<count($tuijian);$i++){ ?><option value="<?php echo $i; ?>"><?php echo $tuijian[$i]; ?></option><?php } ?>
            </select>
        </td>
    </tr>
    <tr>
        <td align="right">规格：</td>
        <td id="spec"><button type="button" id="add_spec_button">+添加规格</button>
        <script>
        var spec = '<div class="spec_li" style="margin-top:5px;"><input required="required" name="spec_name[]" type="text" value="" style="width:120px" placeholder="颜色"> <input placeholder="黑，白" name="spec_data[]" type="text" value="" style="width:200px" required="required"> <button type="button" onClick="remove_specli(\'spec_li\');">删除</button></div>';
        $("#add_spec_button").click(function(){var length=$(".spec_li").length+1;var reg=/spec_li/g;spec=spec.replace(reg,'spec_li'+length);$('#spec').append(spec);});
        function remove_specli(a){$("."+a).remove();}
        </script>
        </td>
    </tr>
    <tr>
        <td align="right">seoTitle：</td>
        <td><input name="seotitle" type="text" id="seotitle" value="" style="width:60%"></td>
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
        <td align="right">商品类目：</td>
        <td>
            <select name="typeid" id="typeid">
                <?php $catlist = category_tree(get_category('goods_type',0));if($catlist){foreach($catlist as $row){
                    if($row["id"]==$catid){ ?>
                <option selected="selected" value="<?php echo $row["id"]; ?>"><?php for($i=0;$i<$row["deep"];$i++){echo "—";}echo $row["name"]; ?></option>
                    <?php }else{ ?>
                <option value="<?php echo $row["id"]; ?>"><?php for($i=0;$i<$row["deep"];$i++){echo "—";}echo $row["name"]; ?></option>
                <?php }}} ?>
            </select>
        </td>
    </tr>
    <tr>
        <td align="right">商品品牌：</td>
        <td>
            <select name="brand_id" id="brand_id">
                <option value="0">请选择品牌</option>
                <?php foreach($goodsbrand_list as $row){ ?>
                <option value="<?php echo $row["id"]; ?>"><?php echo $row["title"]; ?></option>
                <?php } ?>
            </select>
        </td>
    </tr>
    <tr>
        <td align="right">关键词：</td>
        <td><input type="text" name="keywords" id="keywords" style="width:50%" value=""> (多个用","分开)</td>
    </tr>
    <tr>
        <td align="right" style="vertical-align:middle;">内容摘要：</td>
        <td><textarea name="description" rows="5" id="description" style="width:60%;height:70px;vertical-align:middle;"></textarea></td>
    </tr>
    <tr>
        <td colspan="2"><strong>图文描述：</strong></td>
    </tr>
    <tr>
        <td colspan="2">
<!-- 加载编辑器的容器 --><script id="container" name="body" type="text/plain"></script>
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