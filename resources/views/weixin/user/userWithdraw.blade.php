<!DOCTYPE html><html><head><meta http-equiv="content-type" content="text/html;charset=utf-8"/>
<title>提现</title><meta content="width=device-width,initial-scale=1.0,minimum-scale=1.0,maximum-scale=1.0,user-scalable=0" name="viewport">
<link href="<?php echo env('APP_URL'); ?>/css/weixin/style.css" type="text/css" rel="stylesheet">
<script type="text/javascript" src="<?php echo env('APP_URL'); ?>/js/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo env('APP_URL'); ?>/js/weixin/mobile.js"></script>
<meta name="keywords" content="关键词"><meta name="description" content="描述"></head><body style="background-color:#f1f1f1;">
<div class="classreturn loginsignup ">
    <div class="ds-in-bl return"><a href="javascript:history.back(-1);"><img src="<?php echo env('APP_URL'); ?>/images/weixin/return.png" alt="返回"></a></div>
    <div class="ds-in-bl tit center"><span>提现</span></div>
    <div class="ds-in-bl nav_menu"><a href="<?php echo route('weixin_user_withdraw_list'); ?>" style="color:#999;">提现明细</a></div>
</div>

<style>
.adr_add{margin:0 10px;}
.adr-form-group{margin-top:10px;}
.adr-form-group input[type=text],.adr-form-group input[type=password],.adr-form-group textarea{display: block;width: 100%;font-size:16px;padding:10px;color: #777;vertical-align: middle;background-color: #fff;background-image: none;border: 1px solid #ddd;border-radius: 0;box-sizing:border-box;}
.bottoma{display:block;font-size:18px;padding:10px;color:white;background-color:#f23030;text-align:center;}
.yongjin_tip{padding:10px;background-color:#FFC;color:#666;border-bottom:1px solid #DDD;font-size:14px;}.yongjin_tip b{color:red;}
</style>
<div class="yongjin_tip">余额：<b>￥<?php echo $user_info['money']; ?></b>，最少金额：<b>￥<?php echo $min_withdraw_money; ?></b></div>
<div class="adr_add">
<div class="adr-form-group">
  <label><font color="red">*</font>收款人姓名</label>
  <input name="name" type="text" class="" id="name" placeholder="输入姓名">
</div>
<div class="adr-form-group" class="text" style="background-color:#FFF; line-height:38px;">
    &nbsp;&nbsp;<label for="tx_alipay"><input type="radio" checked="checked" name="method" value="alipay" id="tx_alipay">支付宝</label>&nbsp;
    <label for="tx_bank"><input type="radio" name="method" value="bank" id="tx_bank">银行卡</label>
</div>
<div class="adr-form-group">
  <label><font color="red">*</font>提现金额</label>
  <input name="money" type="text" class="" id="money" placeholder="可提现金额：<?php if($is_withdraw==1){echo $user_info['money'];}else{echo '0';} ?>">
</div>
<div class="adr-form-group">
  <label><font color="red">*</font>收款账号</label>
  <input name="account" type="text" class="" id="account" placeholder="">
</div>
<div id='bank' style="display:none;">
<div class="adr-form-group">
  <label><font color="red">*</font>收款银行</label>
  <input name="bank_name" type="text" class="" id="bank_name" placeholder="">
</div>
<div class="adr-form-group">
  <label><font color="red">*</font>开户行</label>
  <input name="bank_place" type="text" class="" id="bank_place" placeholder="">
</div>
</div>
<div class="adr-form-group">
  <label><font color="red">*</font>支付密码(<a style="color:green;" href="<?php echo route('weixin_userinfo'); ?>">设置</a>)</label>
  <input name="pay_password" type="password" class="" id="pay_password" placeholder="输入支付密码">
</div>
</div>
<a style="margin:10px;" class="bottoma" href="javascript:submit();">提交</a>
<script type="text/javascript" src="<?php echo env('APP_URL'); ?>/js/md5.min.js"></script>
<script type="text/javascript" src="<?php echo env('APP_URL'); ?>/js/layer/mobile/layer.js"></script>
<script>
var access_token = '<?php echo $_SESSION['weixin_user_info']['access_token']; ?>';
$(function(){
    $('#tx_alipay').click(function(){
        $('#bank').hide();
    });
    $('#tx_bank').click(function(){
        $('#bank').show();
    });
});

function submit()
{
	var url = '<?php echo env('APP_API_URL').'/user_withdraw_add'; ?>';
	var name = $("#name").val();
	var method = $('input[name="method"]:checked').val();
    var money = $("#money").val();
    var account = $("#account").val();
    var bank_name = $("#bank_name").val();
    var bank_place = $("#bank_place").val();
    var pay_password = $("#pay_password").val();
    
    if(name == '' || method == '' || money == '' || account == '' || pay_password == '')
    {
        //提示
        layer.open({
            content: '请填写必填项'
            ,skin: 'msg'
            ,time: 2 //2秒后自动关闭
        });
        
        return false;
    }
    
    if(method == 'bank')
    {
        if(bank_name == '' || bank_place == '')
        {
            //提示
            layer.open({
                content: '请填写必填项'
                ,skin: 'msg'
                ,time: 2 //2秒后自动关闭
            });
            
            return false;
        }
    }
    
	$.post(url,{access_token:access_token,name:name,method:method,money:money,account:account,bank_name:bank_name,bank_place:bank_place,pay_password:md5(pay_password)},function(res)
	{
        //提示
        layer.open({
            content: res.msg
            ,skin: 'msg'
            ,time: 2 //2秒后自动关闭
        });
        
		if(res.code==0)
		{
            location.href = "<?php echo route('weixin_user_withdraw_list'); ?>";
		}
		else
		{
            
		}
	},'json');
}
</script>
</body></html>