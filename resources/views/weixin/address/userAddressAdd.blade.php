<!DOCTYPE html><html><head><meta http-equiv="content-type" content="text/html;charset=utf-8"/>
<title>新增收货地址</title><meta content="width=device-width,initial-scale=1.0,minimum-scale=1.0,maximum-scale=1.0,user-scalable=0" name="viewport">
<link href="<?php echo env('APP_URL'); ?>/css/weixin/style.css" type="text/css" rel="stylesheet">
<script type="text/javascript" src="<?php echo env('APP_URL'); ?>/js/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo env('APP_URL'); ?>/js/weixin/mobile.js"></script>
<meta name="keywords" content="关键词"><meta name="description" content="描述"></head><body style="background-color:#f1f1f1;">
<div class="classreturn loginsignup ">
    <div class="ds-in-bl return"><a href="javascript:history.back(-1);"><img src="<?php echo env('APP_URL'); ?>/images/weixin/return.png" alt="返回"></a></div>
    <div class="ds-in-bl tit center"><span>新增收货地址</span></div>
    <div class="ds-in-bl nav_menu"><a href="javascript:void(0);"><img src="<?php echo env('APP_URL'); ?>/images/weixin/class1.png" alt="菜单"></a></div>
</div>

@include('weixin.common.headerNav')

<style>
.adr_add{margin:0 10px;}
.adr-form-group{margin-top:10px;}
.adr-form-group input[type=text],.adr-form-group textarea{display: block;width: 100%;font-size:16px;padding:10px;color: #777;vertical-align: middle;background-color: #fff;background-image: none;border: 1px solid #ddd;border-radius: 0;box-sizing:border-box;}
.adr-form-group select{padding:5px;margin-right:10px;}
.bottoma{display:block;font-size:18px;padding:10px;color:white;background-color:#f23030;text-align:center;}
</style>
<div class="adr_add">
<div class="adr-form-group">
  <label for="doc-ipt-email-1">收货人</label>
  <input name="name" type="text" class="" id="name" placeholder="输入姓名">
</div>
<div class="adr-form-group">
  <label for="doc-ipt-email-1">手机号码</label>
  <input type="text" name="mobile" class="" id="mobile" placeholder="输入手机号码">
</div>
<div class="adr-form-group">
地区： <select id='sheng'></select><select id='shi'></select><select id='qu'></select>
<script>
// JavaScript Document
$(document).ready(function(e) {
    //加载省的数据
    LoadSheng();
    //加载市的数据
    LoadShi();
    //加载区的数据
    LoadQu();

    //给省的下拉加点击事件
    $("#sheng").change(function(){
        //重新加载市
        LoadShi();
        //重新加载区
        LoadQu();
    });

    //给市的下拉加点击事件
    $("#shi").change(function(){
        //重新加载区
        LoadQu();
    });
});

//加载省份的方法
function LoadSheng(parent_id,select_id)
{
    //省的父级代号
    parent_id = parent_id || '86';
    select_id = select_id || 0;
    
    $.ajax({
        async:false,
        url:'<?php echo env('APP_API_URL')."/region_list"; ?>',
        data:{id:parent_id},
        type:"GET",
        dataType:"json",
        success: function(res){
            var hang = res.data;
            var str = "";
            for(var i=0;i<hang.length;i++)
            {
                if(select_id != 0 && select_id == hang[i].id)
                {
                    str = str+"<option selected='selected' value='"+hang[i].id+"'>"+hang[i].name+"</option>";
                }
                else
                {
                    str = str+"<option value='"+hang[i].id+"'>"+hang[i].name+"</option>";
                }
            }
            
            $("#sheng").html(str);
        }
    });
}

//加载市的方法
function LoadShi(parent_id,select_id)
{
    //找市的父级代号
    parent_id = parent_id || $("#sheng").val();
    select_id = select_id || 0;
    
    $.ajax({
        async:false,
        url:'<?php echo env('APP_API_URL')."/region_list"; ?>',
        data:{id:parent_id},
        type:"GET",
        dataType:"json",
        success: function(res){
            var hang = res.data;
            var str = "";
            for(var i=0;i<hang.length;i++)
            {
                if(select_id != 0 && select_id == hang[i].id)
                {
                    str = str+"<option selected='selected' value='"+hang[i].id+"'>"+hang[i].name+"</option>";
                }
                else
                {
                    str = str+"<option value='"+hang[i].id+"'>"+hang[i].name+"</option>";
                }
            }
            
            $("#shi").html(str);
        }
    });
}

//加载区的方法
function LoadQu(parent_id,select_id)
{
    //找区的父级代号
    parent_id = parent_id || $("#shi").val();
    select_id = select_id || 0;
    
    $.ajax({
        url:'<?php echo env('APP_API_URL')."/region_list"; ?>',
        data:{id:parent_id},
        type:"GET",
        dataType:"json",
        success: function(res){
            var hang = res.data;
            var str = "";
            for(var i=0;i<hang.length;i++)
            {
                if(select_id != 0 && select_id == hang[i].id)
                {
                    str = str+"<option selected='selected' value='"+hang[i].id+"'>"+hang[i].name+"</option>";
                }
                else
                {
                    str = str+"<option value='"+hang[i].id+"'>"+hang[i].name+"</option>";
                }
            }
            
            $("#qu").html(str);
        }
    });
}
</script>
</div>
<div class="adr-form-group">
  <label for="doc-ta-1">详细地址</label>
  <textarea name="address" class="" rows="3" id="address"></textarea>
</div>
<div class="adr-form-group">
  <label>
    <input type="checkbox" name="is_default" id="is_default"> 设为默认
  </label>
</div>
</div>
<a style="margin:10px;" class="bottoma" href="javascript:adr_dosubmit();">提交</a>
<script type="text/javascript" src="<?php echo env('APP_URL'); ?>/js/layer/mobile/layer.js"></script>
<script>
function adr_dosubmit()
{
    var access_token = '<?php echo $_SESSION['weixin_user_info']['access_token']; ?>';
    
	var url = '<?php echo env('APP_API_URL').'/user_address_add'; ?>';
	var name = $("#name").val();
	var mobile = $("#mobile").val();
	var address = $("#address").val();
	
    var province = $("#sheng").val();
    var city = $("#shi").val();
    var district = $("#qu").val();
    
    var is_default = 0;
    if(document.getElementById("is_default").checked){is_default = 1;}
    
    if(name == '')
    {
        //提示
        layer.open({
            content: '姓名不能为空'
            ,skin: 'msg'
            ,time: 2 //2秒后自动关闭
        });
        
        return false;
    }
    
    if(mobile == '')
    {
        //提示
        layer.open({
            content: '手机号不能为空'
            ,skin: 'msg'
            ,time: 2 //2秒后自动关闭
        });
        
        return false;
    }
    
    if(validatemobile(mobile) == false)
    {
        //提示
        layer.open({
            content: '手机号格式不正确'
            ,skin: 'msg'
            ,time: 2 //2秒后自动关闭
        });
        
        return false;
    }
    
    if(address == '')
    {
        //提示
        layer.open({
            content: '地址不能为空'
            ,skin: 'msg'
            ,time: 2 //2秒后自动关闭
        });
        
        return false;
    }
    
	$.post(url,{access_token:access_token,name:name,mobile:mobile,address:address,province:province,city:city,district:district,is_default:is_default},function(res)
	{
		if(res.code==0)
		{
            //提示
            layer.open({
                content: res.msg
                ,skin: 'msg'
                ,time: 2 //2秒后自动关闭
            });
            
            window.history.back();
		}
		else
		{
            //提示
            layer.open({
                content: res.msg
                ,skin: 'msg'
                ,time: 2 //2秒后自动关闭
            });
            
			location.href = "<?php echo route('weixin_user_address_list'); ?>";
		}
	},'json');
}
</script>
</body></html>