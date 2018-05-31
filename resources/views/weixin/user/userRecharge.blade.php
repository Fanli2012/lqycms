<!DOCTYPE html><html><head><meta http-equiv="content-type" content="text/html;charset=utf-8"/>
<title>充值</title><meta name="keywords" content="关键词"><meta name="description" content="描述"><meta content="width=device-width,initial-scale=1.0,minimum-scale=1.0,maximum-scale=1.0,user-scalable=0" name="viewport">
<link href="<?php echo env('APP_URL'); ?>/css/weixin/style.css" type="text/css" rel="stylesheet">
<script type="text/javascript" src="<?php echo env('APP_URL'); ?>/js/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo env('APP_URL'); ?>/js/weixin/mobile.js"></script>
<link href="<?php echo env('APP_URL'); ?>/css/font-awesome.min.css" type="text/css" rel="stylesheet"></head><body>
<div class="classreturn loginsignup">
    <div class="ds-in-bl return"><a href="javascript:history.back(-1);"><img src="<?php echo env('APP_URL'); ?>/images/weixin/return.png" alt="返回"></a></div>
    <div class="ds-in-bl tit center"><span>充值</span></div>
    <div class="ds-in-bl nav_menu"><a href="<?php echo route('weixin_user_recharge_order'); ?>">充值明细</a></div>
</div>

<style>
.account{text-align:center;margin-top:30px;}
.account .icon{color:#FFCC00;font-size:100px;}
.account .money{color:#353535;font-size:36px;}
.account .tit{color:#000;font-size:18px;}
.bottoma{display:block;font-size:18px;padding:10px;border-radius:2px;}
</style>
<div class="floor account">
    <div class="icon"><i class="fa fa-google-wallet"></i></div><br>
    <div class="tit"><b style="color:#f23030;">1、填写金额</b> > 2、确认并支付 > 3、完成</div>
    <input type="hidden" name="pay_type" id="pay_type" value="1">
    <br>
    <div style="margin:10px;"><input name="money" min="10" max="10000" type="text" id="money" placeholder="充值金额(元)、整数"  style="width:100%;text-align:center;border:1px solid #bfbfbf;color:#999;box-sizing:border-box;" class="bottoma"></div>
    <a style="margin:0 10px 10px 10px;background-color:#1aad19;text-align:center;color:#fff;border:1px solid #179e16;" class="bottoma" href="javascript:chongzhi();">开始充值</a>
    <!-- <p style="margin:0 10px 10px 10px;">支付金额：<span style="color:#f23030;">¥ 99.80</span>
    实际到账：¥ 100.00</p> -->
</div>

<script type="text/javascript" src="<?php echo env('APP_URL'); ?>/js/layer/mobile/layer.js"></script>
<script>
function chongzhi()
{
    var money = $('#money').val();
    var re = /^[0-9]+$/; //判断字符串是否为数字
    
    if(money == '')
    {
        //提示
        layer.open({
            content: '请输入充值金额'
            ,skin: 'msg'
            ,time: 2 //2秒后自动关闭
        });
        
        return false;
    }
    
    if(!re.test(money))
    {
        //提示
        layer.open({
            content: '金额格式不正确'
            ,skin: 'msg'
            ,time: 2 //2秒后自动关闭
        });
        
        return false;
    }
    
    //询问框
    layer.open({
        content: '确定要充值吗？'
        ,btn: ['确定', '取消']
        ,yes: function(){
            var url = '<?php echo env('APP_API_URL')."/user_recharge_add"; ?>';
            var pay_type = $('#pay_type').val();
            
            $.post(url,{access_token:'<?php echo $_SESSION['weixin_user_info']['access_token']; ?>',money:money,pay_type:pay_type},function(res)
            {
                //提示
                layer.open({
                    content: '充值订单创建成功，请支付'
                    ,skin: 'msg'
                    ,time: 2 //2秒后自动关闭
                });
                
                if(res.code==0)
                {
                    location.href = '<?php echo route('weixin_user_recharge_order_detail'); ?>?id=' + res.data;
                }
                else
                {
                    
                }
            },'json');
        }
    });
}
</script>
@include('weixin.common.footer')
</body></html>