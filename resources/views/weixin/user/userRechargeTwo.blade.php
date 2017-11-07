<!DOCTYPE html><html><head><meta http-equiv="content-type" content="text/html;charset=utf-8"/>
<title>充值-支付</title><meta name="keywords" content="关键词"><meta name="description" content="描述"><meta content="width=device-width,initial-scale=1.0,minimum-scale=1.0,maximum-scale=1.0,user-scalable=0" name="viewport">
<link href="<?php echo env('APP_URL'); ?>/css/weixin/style.css" type="text/css" rel="stylesheet">
<script type="text/javascript" src="<?php echo env('APP_URL'); ?>/js/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo env('APP_URL'); ?>/js/weixin/mobile.js"></script>
<link href="<?php echo env('APP_URL'); ?>/css/font-awesome.min.css" type="text/css" rel="stylesheet"></head><body>
<div class="classreturn loginsignup">
    <div class="ds-in-bl return"><a href="javascript:history.back(-1);"><img src="<?php echo env('APP_URL'); ?>/images/weixin/return.png" alt="返回"></a></div>
    <div class="ds-in-bl tit center"><span>充值</span></div>
</div>

<style>
.account{text-align:center;margin-top:30px;}
.account .icon{color:#FFCC00;font-size:100px;}
.account .tit{color:#000;font-size:18px;}
.bottoma{display:block;font-size:18px;padding:10px;border-radius:2px;}
</style>
<div class="floor account">
    <div class="icon"><i class="fa fa-google-wallet"></i></div>
    <div style="margin:10px;padding:10px;text-align:left;">
        订单已于 <span style="color:#390;"><?php echo $post['created_at']; ?></span> 提交成功，请您尽快付款！<br>
        订单号：<?php echo $post['id']; ?><br>
        应付金额：<span style="color:#ff5500;font-size:18px;">￥<?php echo $post['money']; ?></span> 元<br><br>

        请您在提交订单后30分钟内完成支付，否则订单会自动取消。<br><br>
    </div>
    <a style="margin:0 10px 10px 10px;background-color:#1aad19;text-align:center;color:#fff;border:1px solid #179e16;" class="bottoma" href="javascript:chongzhi();">去支付</a>
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
                    content: res.msg
                    ,skin: 'msg'
                    ,time: 2 //2秒后自动关闭
                });
                
                if(res.code==0)
                {
                    location.href = '<?php echo substr(route('weixin_user_recharge_two',array('id'=>1)), 0, -1); ?>' + res.data;
                }
                else
                {
                    
                }
            },'json');
        }
    });
}
</script>
</body></html>