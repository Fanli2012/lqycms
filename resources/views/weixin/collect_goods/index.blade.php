<!DOCTYPE html><html><head><meta http-equiv="content-type" content="text/html;charset=utf-8"/>
<title>我的收藏</title><meta name="keywords" content="关键词"><meta name="description" content="描述"><meta content="width=device-width,initial-scale=1.0,minimum-scale=1.0,maximum-scale=1.0,user-scalable=0" name="viewport">
<link href="<?php echo env('APP_URL'); ?>/css/weixin/style.css" type="text/css" rel="stylesheet">
<script type="text/javascript" src="<?php echo env('APP_URL'); ?>/js/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo env('APP_URL'); ?>/js/weixin/mobile.js"></script></head><body>
<div class="classreturn loginsignup">
    <div class="ds-in-bl return"><a href="javascript:history.back(-1);"><img src="<?php echo env('APP_URL'); ?>/images/weixin/return.png" alt="返回"></a></div>
    <div class="ds-in-bl tit center"><span>我的收藏</span></div>
</div>

<script type="text/javascript" src="<?php echo env('APP_URL'); ?>/js/layer/mobile/layer.js"></script>
<div class="floor">
    <ul class="goods_list_s cl">
        <?php if($list){foreach($list as $k=>$v){ ?>
        <li><a href="<?php echo route('weixin_goods_detail',array('id'=>$v['goods']['id'])); ?>"><span class="goods_thumb"><img alt="<?php echo $v['goods']['title']; ?>" src="<?php echo env('APP_URL'); ?><?php echo $v['goods']['litpic']; ?>"></span></a>
        <div class="goods_info"><p class="goods_tit"><a href="<?php echo route('weixin_goods_detail',array('id'=>$v['goods']['id'])); ?>"><?php echo $v['goods']['title']; ?></a></p>
        <p class="goods_price">￥<b><?php echo $v['goods']['price']; ?></b></p>
        <p class="goods_des fr"><span class="btn" id="del_history" onclick="del('<?php echo $v['goods_id']; ?>')">删除</span></p>
        </div></li>
        <?php }} ?>
    </ul>
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
        var listheight = $(".goods_list_s").outerHeight(); 
        
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
                        $(".goods_list_s").append(res);
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

function del(goods_id)
{
    //询问框
    layer.open({
        content: '确定要删除吗？'
        ,btn: ['确定', '取消']
        ,yes: function(){
            var url = '<?php echo env('APP_API_URL')."/collect_goods_delete"; ?>';
            $.post(url,{goods_id:goods_id,access_token:'<?php echo $_SESSION['weixin_user_info']['access_token']; ?>'},function(res)
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
            },'json');
        }
    });
}
</script>

@include('weixin.common.footer')
</body></html>