<!DOCTYPE html><html><head><meta http-equiv="content-type" content="text/html;charset=utf-8"/>
<title>收货地址管理</title><meta content="width=device-width,initial-scale=1.0,minimum-scale=1.0,maximum-scale=1.0,user-scalable=0" name="viewport">
<link href="<?php echo env('APP_URL'); ?>/css/weixin/style.css" type="text/css" rel="stylesheet">
<script type="text/javascript" src="<?php echo env('APP_URL'); ?>/js/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo env('APP_URL'); ?>/js/weixin/mobile.js"></script>
<meta name="keywords" content="关键词"><meta name="description" content="描述"></head><body style="background-color:#f1f1f1;">
<div class="classreturn loginsignup">
    <div class="ds-in-bl return"><a href="javascript:history.back(-1);"><img src="<?php echo env('APP_URL'); ?>/images/weixin/return.png" alt="返回"></a></div>
    <div class="ds-in-bl tit center"><span>收货地址管理</span></div>
    <div class="ds-in-bl nav_menu"><a href="javascript:void(0);"><img src="<?php echo env('APP_URL'); ?>/images/weixin/class1.png" alt="菜单"></a></div>
</div>

@include('weixin.common.headerNav')

<style>
.address_list .flow-have-adr{padding:15px;margin-bottom:10px;background-color:#fff;}
.address_list .f-h-adr-title .ect-colory{color:#e23435;}
.address_list .f-h-adr-title label{font-size:18px;color:#000;margin-right:5px;}
.address_list .f-h-adr-con{color:#777;margin-top:5px;margin-bottom:5px;}
.address_list .adr-edit-del{text-align:right;}
.address_list .adr-edit-del a{color:#777;margin-right:8px;}
.address_list .f-h-adr-title span.fr{background-color: #f23030;color: white;padding:0 5px;}
.bottoma{display:block;font-size:18px;padding:10px;color:white;background-color: #f23030;text-align:center;}
</style>

<a style="margin:10px;" class="bottoma" href="<?php echo route('weixin_user_address_add'); ?>">新增地址</a>

<div class="address_list">
<?php if($list){foreach($list as $k=>$v){ ?>
<div class="flow-have-adr">
	<p class="f-h-adr-title"><label><?php echo $v['name']; ?></label><span class="ect-colory"><?php echo $v['mobile']; ?></span><?php if($v['is_default']==1){ ?><span class="fr">默认</span><?php } ?></p>
	<p class="f-h-adr-con"><?php echo $v['province_name'].$v['city_name'].$v['district_name'].' '.$v['address']; ?></p>
    <div class="adr-edit-del"><a href="<?php echo route('weixin_user_address_update',array('id'=>$v['id'])); ?>"><i class="iconfont icon-bianji"></i>编辑</a><a href="javascript:del(<?php echo $v['id']; ?>);"><i class="iconfont icon-xiao10"></i>删除</a></div>
</div>
<?php }} ?>
</div>

<script type="text/javascript" src="<?php echo env('APP_URL'); ?>/js/layer/mobile/layer.js"></script>
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
        var listheight = $(".address_list").outerHeight(); 
        
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
                        $(".address_list").append(res);
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

function del(id)
{
    //询问框
    layer.open({
        content: '确定要删除吗？'
        ,btn: ['确定', '取消']
        ,yes: function(){
            var url = '<?php echo env('APP_API_URL')."/user_address_delete"; ?>';
            $.post(url,{access_token:'<?php echo $_SESSION['weixin_user_info']['access_token']; ?>',id:id},function(res)
            {
                //提示
                layer.open({
                    content: res.msg
                    ,skin: 'msg'
                    ,time: 2 //2秒后自动关闭
                });
                
                if(res.code==0)
                {
                    location.reload();
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