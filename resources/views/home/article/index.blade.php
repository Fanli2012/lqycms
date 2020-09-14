<!DOCTYPE html><html><head><meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
<title><?php if(isset($post)){echo $post["name"].'_'.sysconfig('CMS_WEBNAME');}else{echo '动态';} ?></title><meta name="keywords" content="{dede:field.keywords/}" /><meta name="description" content="{dede:field.description function='html2text(@me)'/}" /><link rel="stylesheet" href="<?php echo sysconfig('CMS_BASEHOST'); ?>/css/style.css"><script type="text/javascript" src="<?php echo sysconfig('CMS_BASEHOST'); ?>/js/ad.js"></script></head><body>
@include('home.common.header')

<div class="box" style="padding-top:20px;" id="arclist">
<?php if($list){foreach($list as $k=>$v){ ?><div class="list"><?php if(!empty($v['litpic'])){ ?><a class="limg" href="<?php echo get_front_url(array("id"=>$v['id'],"catid"=>$v['typeid'],"type"=>'content')); ?>"><img alt="<?php echo $v['title']; ?>" src="<?php echo $v['litpic']; ?>"></a><?php } ?>
<strong class="tit"><a href="<?php echo get_front_url(array("id"=>$v['id'],"catid"=>$v['typeid'],"type"=>'content')); ?>"><?php echo $v['title']; ?></a></strong><p><?php echo mb_strcut($v['description'],0,150,'UTF-8'); ?>..</p>
<div class="info"><span class="fl"><?php $taglist=taglist($v['id']);if($taglist){foreach($taglist as $row){ ?><a href="<?php echo get_front_url(array("tagid"=>$row['id'],"type"=>'tags')); ?>"><?php echo $row['tag']; ?></a><?php }} ?><em><?php echo date("m-d H:i",$v['pubdate']); ?></em></span><span class="fr"><em><?php echo $v['click']; ?></em>人阅读</span></div><div class="cl"></div></div><?php }} ?>
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
        var listheight = $("#arclist").outerHeight(); 
        
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
                        $("#arclist").append(res);
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
@include('home.common.footer')</body></html>