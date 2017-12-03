<!DOCTYPE html><html><head><meta http-equiv="content-type" content="text/html;charset=utf-8"/>
<title>搜索</title><meta content="width=device-width,initial-scale=1.0,minimum-scale=1.0,maximum-scale=1.0,user-scalable=0" name="viewport">
<link href="<?php echo env('APP_URL'); ?>/css/weixin/style.css" type="text/css" rel="stylesheet">
<script type="text/javascript" src="<?php echo env('APP_URL'); ?>/js/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo env('APP_URL'); ?>/js/weixin/mobile.js"></script>
<meta name="keywords" content="关键词"><meta name="description" content="描述"></head><body>
<div class="classreturn loginsignup">
    <div class="ds-in-bl return"><a href="javascript:history.back(-1);"><img src="<?php echo env('APP_URL'); ?>/images/weixin/return.png" alt="返回"></a></div>
    <div class="ds-in-bl tit center"><span>搜索</span></div>
    <div class="ds-in-bl nav_menu"><a href="javascript:void(0);"><img src="<?php echo env('APP_URL'); ?>/images/weixin/class1.png" alt="菜单"></a></div>
</div>

@include('weixin.common.headerNav')

<div class="cl search_pl">
    <form method="get" action="<?php echo route('weixin_goods_list'); ?>" id="sourch_form">
        <input type="text" name="keyword" id="keyword" value="" placeholder="搜索商品">
        <a href="javascript:;" onclick="ajaxsecrch()"><img src="<?php echo env('APP_URL'); ?>/images/weixin/sea.png"></a>
    </form>
    <div class="cl"></div>
</div>
<script type="text/javascript" src="<?php echo env('APP_URL'); ?>/js/layer/layer.js"></script>
<script>
function ajaxsecrch()
{
    if($.trim($('#keyword').val()) != '')
    {
        $("#sourch_form").submit();
    }
    else
    {
        layer.msg('请输入搜索关键字', {
            time: 3000, //3s后自动关闭
        });
    }
}
</script>

<div class="hot_keyword_box">
    <div class="tit_18 mt10 mb10">
        <span>热门搜索</span>
    </div>
    <div class="hot_keyword"><?php if($goods_searchword_list){foreach($goods_searchword_list as $v){ ?>
        <a href="<?php echo route('weixin_goods_list',array('keyword'=>$v['name'])); ?>" class="ht"><?php echo $v['name'] ?></a><?php }} ?>
    </div>
</div>

@include('weixin.common.footer')
</body></html>