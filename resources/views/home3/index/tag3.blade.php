<!DOCTYPE html><html><head><meta http-equiv="Content-Type" content="text/html;charset=UTF-8" /><meta http-equiv="Cache-Control" content="no-siteapp" /><meta http-equiv="Cache-Control" content="no-transform" /><meta name="mobile-agent" content="format=xhtml;url=http://m.bnbni.com<?php echo GetCurUrl(); ?>">
<title><?php if(empty($post["title"])){echo $post["tag"];}else{echo $post["title"];}if($page!=0){echo ' '.($page+1);} ?></title><meta name="keywords" content="<?php echo $post["keywords"]; ?>" /><meta name="description" content="<?php echo $post["description"]; ?>" /><link rel="stylesheet" href="<?php echo CMS_BASEHOST; ?>/images/style.css" media="all"><script type="text/javascript" src="<?php echo CMS_BASEHOST; ?>/js/jquery.min.js"></script><script type="text/javascript" src="<?php echo CMS_BASEHOST; ?>/js/ad.js"></script><script>uaredirect("http://m.bnbni.com/cat{dede:type}[field:ID /]{/dede:type}");</script></head><body><script>site();</script>
@include('home.common.header')<div id="tad"><script>tjs();</script></div>

<div class="box mt10"><div class="fl_640"><h1 class="arct"><?php echo $post["tag"]; ?></h1>
<div class="content"><?php echo $post["content"]; ?></div><div id="lad1"><script>ljs1();</script></div></div><!-- fl_640 end -->

<div class="fr_300"><div id="rad1"><script>rjs1();</script></div>
<div class="side"><div class="stit"><h2>相关推荐</h2><a href="javascript:getmore({PageSize:5,tuijian:1,mode:1,orderby:'rand()',_token:'{{ csrf_token() }}'});" class="more">换一换</a><div class="cl"></div></div>	
<ul class="uli chs" id="xglist"><?php $posts=arclist(array("row"=>5,"tuijian"=>1));foreach($posts as $row){ ?><li><a target="_blank" href="<?php echo get_front_url(array("id"=>$row['id'],"catid"=>$row['typeid'],"type"=>'content')); ?>"><?php echo $row['title']; ?></a></li><?php } ?></ul><div class="cl"></div></div>

<div id="rad3"><script>rjs3();</script></div>
<div class="side"><div class="stit"><h2>猜你喜欢</h2><a href="javascript:getmore({PageSize:5,mode:2,orderby:'rand()',_token:'{{ csrf_token() }}'});" class="more">换一换</a><div class="cl"></div></div>
<div class="uli2" id="xglike"><?php $posts=arclist(array("row"=>5,"orderby"=>'rand()'));foreach($posts as $row){ ?><div class="suli"><?php if(!empty($row['litpic'])){ ?><a class="limg" href="<?php echo get_front_url(array("id"=>$row['id'],"catid"=>$row['typeid'],"type"=>'content')); ?>"><img alt="<?php echo $row['title']; ?>" src="<?php echo $row['litpic']; ?>"></a><?php } ?><a target="_blank" href="<?php echo get_front_url(array("id"=>$row['id'],"catid"=>$row['typeid'],"type"=>'content')); ?>"><?php echo $row['title']; ?></a><div class="sulii"><?php if(!empty($row['writer'])){echo '<span class="time">'.$row['writer'].'</span>';}elseif(!empty($row['source'])){echo '<span class="time">'.$row['source'].'</span>';} ?> 阅读(<?php echo $row['click']; ?>)</div><div class="cl"></div></div><?php } ?><div class="cl"></div></div></div>

<div id="rad2"><script>rjs2();</script></div></div><!-- fr_300 end --></div><!-- box end -->
<script>
function getmore(condition)
{
    var url = "<?php echo CMS_BASEHOST; ?>/api/listarc";
    //var typeid = "";
    $.post(url,condition,function(res){
        if(res.code==0)
        {
            var json = res.data; //数组
            var str = '';
            $.each(json, function (index) {
                //循环获取数据
                //var title = json[index].title;
                if(condition.mode==1)
                {
                    str = str + '<li><a target="_blank" href="'+json[index].url+'">'+json[index].title+'</a></li>';
                }
                else if(condition.mode==2)
                {
                    var litpic = '';if(json[index].litpic!==''){litpic = '<a class="limg" href="'+json[index].url+'"><img alt="'+json[index].title+'" src="'+json[index].litpic+'"></a>';}
                    str = str + '<div class="suli">'+litpic+'<a target="_blank" href="'+json[index].url+'">'+json[index].title+'</a><div class="sulii">阅读('+json[index].click+')</div><div class="cl"></div></div>';
                }
            });
            
            if(str!='' && str!=null && condition.mode==1)
            {
                $('#xglist').html(str);
            }
            else if(str!='' && str!=null && condition.mode==2)
            {
                $('#xglike').html(str);
            }
        }
        else
        {
            
        }
    },'json');
}
</script>
@include('home.common.footer')</body></html>