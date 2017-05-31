<!DOCTYPE html><html><head><title>修改分类_后台管理</title>{include file="common/header"/}
<div class="container-fluid">
<div class="row">
<!-- 左边开始 --><div class="col-sm-3 col-md-2 sidebar">{include file="common/leftmenu"/}</div><!-- 左边结束 -->

<!-- 右边开始 --><div class="col-sm-9 col-md-10 rightbox"><div id="mainbox">
<h5 class="sub-header"><a href="/fladmin/Producttype">商品分类管理</a> > 修改分类</h5>

<form method="post" action="/fladmin/Producttype/doedit" role="form" id="addcat" class="table-responsive">
<table class="table table-striped table-bordered">
  <tbody>
    <tr>
      <td align="right">分类名称：</td>
      <td><input name="typename" type="text" value="{$post["typename"]}" id="typename" size="30" class="required"><if condition="$action_name=='edit'"><input style="display:none;" type="text" name="id" id="id" value="{$id}"></if></td>
    </tr>
	<?php if($action_name=='add'){ ?>
	<tr>
      <td align="right">上级目录：</td>
      <td><?php if($id==0){echo "顶级栏目";}else{echo $postone["typename"];} ?><input style="display:none;" type="text" name="prid" id="prid" value="<?php if($id==0){echo "top";}else{echo $id;} ?>"></td>
    </tr>
	<?php } ?>
    <tr>
    <td align="right">别名：</td>
    <td><input name="typedir" type="text" value="{$post["typedir"]}" id="typedir" class="required" style="width:30%"> <small>(包含字母或数字，字母开头)</small></td>
    </tr>
    <tr>
      <td align="right">列表模板：</td>
      <td><input name="templist" id="templist" type="text" value="{$post["templist"]}" class="required" size="20"></td>
    </tr>
    <tr>
      <td align="right">文章模板：</td>
      <td><input name="temparticle" id="temparticle" type="text" value="{$post["temparticle"]}" class="required" size="20"></td>
    </tr>
    <tr>
        <td align="right" style="vertical-align:middle;">缩略图：</td>
        <td style="vertical-align:middle;"><input id="file_upload" value="选择文件" name="file_upload" type="file" multiple="true"> <input name="litpic" type="text" id="litpic" value="{$post["litpic"]}" style="width:40%"> <img style="margin-left:20px;<?php if(empty($post["litpic"]) || !imgmatch($post["litpic"])){ echo "display:none;"; } ?>" src="<?php if(imgmatch($post["litpic"])){echo $post["litpic"];} ?>" width="120" height="80" id="picview" name="picview"></td>
    </tr>
<style>.uploadify{display:inline-block;}.uploadify-queue{display:none;}</style>
<script type="text/javascript">
    <?php $timestamp = time();?>
    bidtype="选择文件";
    $(function() {
        $('#file_upload').uploadify({
            'buttonText': bidtype,//按钮文字
            'auto':true,//选择完图片以后是否自动上传
            'multi': false,//是否开启一次性上传多个文件
            'fileTypeExts': "*.jpg;*.png;*.gif;*.jpeg;",//允许的文件类型
            'width': 60,//buttonImg的大小
            'height': 26,
            'formData'     : {
                'timestamp' : '<?php echo $timestamp;?>',
                'token'     : '<?php echo md5('unique_salt' . $timestamp);?>'
            },
            'swf'      : '/other/uploadify/uploadify.swf',//路径要正确
            'uploader' : '/uploadImage.php',//路径要正确
            'onUploadSuccess': function (file, data, response) {  //一个文件上传成功后的响应事件处理
                $('#litpic').val(data);
                $('#picview').attr("src",data).css("display","inline-block");
            }
        });
    });
</script>
    <tr>
      <td align="right">SEO标题：</td>
      <td><input name="seotitle" type="text" style="width:70%" id="seotitle" class="alltxt" value="{$post["seotitle"]}"></td>
    </tr>
    <tr>
      <td align="right">关键字：</td>
      <td><input name="keywords" type="text" style="width:50%" id="keywords" class="alltxt" value="{$post["keywords"]}"> (用","分开)</td>
    </tr>
    <tr>
      <td align="right">SEO关键字：</td>
      <td><input name="seokeyword" type="text" style="width:50%" id="seokeyword" class="alltxt" value="{$post["seokeyword"]}"> (用","分开)</td>
    </tr>
    <tr>
      <td align="right" style="vertical-align:middle;">分类描述：</td>
      <td><textarea name="description" cols="70" style="height:70px;vertical-align:middle;width:70%" rows="3" id="description" class="alltxt">{$post["description"]}</textarea></td>
    </tr>
    <tr>
      <td colspan="2"><strong>分类内容：</strong></td>
    </tr>
    <tr>
      <td colspan="2">
<!-- 加载编辑器的容器 --><script id="container" name="content" type="text/plain">{$post["content"]}</script>
<!-- 配置文件 --><script type="text/javascript" src="/other/flueditor/ueditor.config.js"></script>
<!-- 编辑器源码文件 --><script type="text/javascript" src="/other/flueditor/ueditor.all.js"></script>
<!-- 实例化编辑器 --><script type="text/javascript">var ue = UE.getEditor('container',{maximumWords:100000,initialFrameHeight:320,enableAutoSave:false});</script>
      </td>
    </tr>
    
    <tr>
      <td colspan="2"><input type="submit" class="btn btn-success" value="保存(Submit)">&nbsp;&nbsp;<input type="reset" class="btn btn-default" value="重置(Reset)"></td>
    </tr>
  </tbody>
</table>
</form><!-- 表单结束 -->
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
            if( $(this).is('#typedir') ){
                var reg = /^[a-zA-Z]+[0-9]*[a-zA-Z0-9]*$/;//验证是否为字母、数字
                if(!reg.test($("#typedir").val()))
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

    //$("#contents").val = ue.getContent();
    //var datas = $('#addcat').serialize();//#form要在form里面

    //var content = ue.getContent();
    /* $.ajax({
        url: "/fladmin/Producttype/doedit",
        type: "POST",
        dataType: "json",
        data: {
            "id":$("#id").val(),
            "typename":$("#typename").val(),
            "typedir":$("#typedir").val(),
            "templist":$("#templist").val(),
            "temparticle":$("#temparticle").val(),
            "litpic":$("#litpic").val(),
            "seotitle":$("#seotitle").val(),
            "keywords":$("#keywords").val(),
            "seokeyword":$("#seokeyword").val(),
            "description":$("#description").val(),
            "content":content
            //"seotitle":seotitle.replace("'", "&#039;"),
            //"keywords":keywords.replace("'", "&#039;"),
            //"description":description.replace("'", "&#039;"),
            //"contents":content.replace("'", "&#039;")
        },
        success: function(data){
            if(data.code==200)
            {
                //alert(data.info);
                window.location.replace("/fladmin/Producttype");
            }
        }
    }); */
});
</script>
</body></html>