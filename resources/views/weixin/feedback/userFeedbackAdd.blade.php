<!DOCTYPE html><html><head><meta http-equiv="content-type" content="text/html;charset=utf-8"/>
<title>意见与反馈</title><meta content="width=device-width,initial-scale=1.0,minimum-scale=1.0,maximum-scale=1.0,user-scalable=0" name="viewport">
<link href="<?php echo env('APP_URL'); ?>/css/weixin/style.css" type="text/css" rel="stylesheet">
<script type="text/javascript" src="<?php echo env('APP_URL'); ?>/js/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo env('APP_URL'); ?>/js/weixin/mobile.js"></script>
<meta name="keywords" content="关键词"><meta name="description" content="描述"></head><body style="background-color:#f1f1f1;">
<div class="classreturn loginsignup ">
    <div class="ds-in-bl return"><a href="javascript:history.back(-1);"><img src="<?php echo env('APP_URL'); ?>/images/weixin/return.png" alt="返回"></a></div>
    <div class="ds-in-bl tit center"><span>意见与反馈</span></div>
    <div class="ds-in-bl nav_menu"><a href="javascript:void(0);"><img src="<?php echo env('APP_URL'); ?>/images/weixin/class1.png" alt="菜单"></a></div>
</div>

@include('weixin.common.headerNav')

<style>
.adr_add{margin:0 10px;}
.adr-form-group{margin-top:10px;}
.adr-form-group input[type=text],.adr-form-group textarea{display: block;width: 100%;font-size:16px;padding:10px;color: #777;vertical-align: middle;background-color: #fff;background-image: none;border: 1px solid #ddd;border-radius: 0;box-sizing:border-box;}
.adr-form-group select{padding:5px;margin-right:10px;}
.bottoma{display:block;font-size:18px;padding:10px;color:white;background-color: #f23030;text-align:center;}
</style>
<div class="adr_add">
<div class="adr-form-group">
问题类型：
<select id="type" name="type">
<option value ="购物流程">购物流程</option>
<option value ="物流问题">物流问题</option>
<option value ="售后服务">售后服务</option>
<option value ="积分/优惠券">积分/优惠券</option>
<option value ="新品建议">新品建议</option>
<option value ="其他意见">其他意见</option>
</select>
</div>
<div class="adr-form-group">
  <label for="doc-ta-1" style="border-left:2px solid #f23030;padding-left:4px;margin-bottom:2px;">反馈内容(必填)</label>
  <textarea style="margin-top:4px;" name="content" class="" rows="3" id="content" placeholder="提优质意见可得大礼哦"></textarea>
</div>

<div class="adr-form-group">
  <label for="doc-ipt-mobile-1" style="border-left:2px solid #f23030;padding-left:4px;margin-bottom:2px;">您的联系方式(选填)</label>
  <input style="margin-top:4px;" type="text" name="mobile" class="" id="mobile" placeholder="输入手机号码" value="">
</div>
</div>
<a style="margin:10px;" class="bottoma" href="javascript:dosubmit();">提交</a>
<script type="text/javascript" src="<?php echo env('APP_URL'); ?>/js/layer/mobile/layer.js"></script>
<script>
function dosubmit()
{
    var access_token = '<?php echo $_SESSION['weixin_user_info']['access_token']; ?>';
    
	var url = '<?php echo env('APP_API_URL').'/feedback_add'; ?>';
	var type = $("#type").val();
	var mobile = $("#mobile").val();
	var content = $("#content").val();
    
    if(type == '')
    {
        //提示
        layer.open({
            content: '问题类型必填'
            ,skin: 'msg'
            ,time: 2 //2秒后自动关闭
        });
        
        return false;
    }
    
    if(content == '')
    {
        //提示
        layer.open({
            content: '反馈内容不能为空'
            ,skin: 'msg'
            ,time: 2 //2秒后自动关闭
        });
        
        return false;
    }
    
    if(mobile!='' && validatemobile(mobile) == false)
    {
        //提示
        layer.open({
            content: '手机号格式不正确'
            ,skin: 'msg'
            ,time: 2 //2秒后自动关闭
        });
        
        return false;
    }
    
	$.post(url,{access_token:access_token,type:type,mobile:mobile,content:content},function(res)
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
            
			//var url = "http://www.baidu.com";
			//location.href = url;
		}
	},'json');
}
</script>
</body></html>