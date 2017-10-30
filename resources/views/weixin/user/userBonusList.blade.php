<!DOCTYPE html><html><head><meta http-equiv="content-type" content="text/html;charset=utf-8"/>
<title>我的优惠券</title><meta name="keywords" content=""><meta name="description" content=""><meta content="width=device-width,initial-scale=1.0,minimum-scale=1.0,maximum-scale=1.0,user-scalable=0" name="viewport">
<link href="<?php echo env('APP_URL'); ?>/css/weixin/style.css" type="text/css" rel="stylesheet">
<script type="text/javascript" src="<?php echo env('APP_URL'); ?>/js/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo env('APP_URL'); ?>/js/weixin/mobile.js"></script></head><body style="background-color:#f1f1f1;">
<div class="classreturn loginsignup">
    <div class="ds-in-bl return"><a href="javascript:history.back(-1);"><img src="<?php echo env('APP_URL'); ?>/images/weixin/return.png" alt="返回"></a></div>
    <div class="ds-in-bl tit center"><span>我的优惠券</span></div>
</div>

<script type="text/javascript" src="<?php echo env('APP_URL'); ?>/js/layer/mobile/layer.js"></script>
<style>
.bonus_list .flow-have-adr{padding:10px;margin:10px;background-color:#fff;}
.bonus_list .f-h-adr-title .ect-colory{color:#f45239;font-size:32px;}
.bonus_list .f-h-adr-title label{font-size:18px;color:#2e2e2e;margin-right:5px;}
.bonus_list .f-h-adr-con{color:#616161;margin-top:5px;margin-bottom:5px;font-size:14px;}
.bonus_list .adr-edit-del{margin-top:10px;padding-top:8px;border-top:1px dashed #ddd;line-height:22px;color:#a0a0a0;font-size:14px;}
</style>

<div class="bonus_list">
<?php if($list){foreach($list as $k=>$v){ ?>
<div class="flow-have-adr">
	<p class="f-h-adr-title"><label><?php echo $v['bonus']['name']; ?></label><span class="ect-colory fr"><small>￥</small><?php echo $v['bonus']['money']; ?></span><div class="cl"></div></p>
	<p class="f-h-adr-con">有效期至<?php echo $v['bonus']['end_time']; ?> <span class="fr">满<?php echo $v['bonus']['min_amount']; ?>可用</span></p>
    <!-- <div class="adr-edit-del">说明</div> -->
</div>
<?php }} ?>
</div>
<script>
$(function(){
    var ajaxload  = false;
    var maxpage   = false;
    var startpage = 1;
    var totalpage = <?php echo $totalpage; ?>;
    
    var tmp_url   = window.location.href;
    msg = tmp_url.split("#");
    tmp_url = msg[0];
    
    $(window).scroll(function ()
    {
        var listheight = $(".bonus_list").outerHeight(); 
        
        if ($(document).scrollTop() + $(window).height() >= listheight)
        {
            if(startpage >= totalpage)
            {
                //$("#submit_bt_one").html("已是最后一页，没有更多数据！");
                return false;
            }
            
            if(!ajaxload && !maxpage)
            {
                ajaxload = true;
                //$("#submit_bt_one").html("努力加载中...");
                var url = tmp_url;
                var nextpage = startpage+1;
                
                $.get(url,{page_ajax:1,page:nextpage},function(res)
                {
                    if(res)
                    {
                        $(".bonus_list").append(res);
                        startpage++;
                        
                        if(startpage >= totalpage)
                        {
                            maxpage = true;
                            //$("#submit_bt_one").html("已是最后一页，没有更多数据！");
                        }
                        else
                        {
                            //$("#submit_bt_one").html("点击加载更多");
                        }
                        
                        ajaxload = false;
                    }
                    else
                    {
                        //$("#submit_bt_one").html("请求失败，请稍候再试！");
                        ajaxload = false;
                    }
                },'json');
            }
        }
    });
});
</script>

@include('weixin.common.footer')
</body></html>