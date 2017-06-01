<!DOCTYPE html><html><head><meta http-equiv="Content-Type" content="text/html;charset=UTF-8" /><meta http-equiv="Cache-Control" content="no-siteapp" /><meta http-equiv="Cache-Control" content="no-transform" /><meta name="mobile-agent" content="format=xhtml;url=http://m.bnbni.com<?php echo GetCurUrl(); ?>">
<title><?php if(!empty($post['seotitle'])){echo $post['seotitle'];}elseif(!empty($post['writer'])){echo $post['writertitle'].'_'.sysconfig('CMS_WEBNAME');}else{echo $post['title'].'_'.sysconfig('CMS_WEBNAME');} ?></title><meta name="keywords" content="<?php echo $post["keywords"]; ?>" /><meta name="description" content="<?php echo $post["description"]; ?>" /><link rel="stylesheet" href="<?php echo sysconfig('CMS_BASEHOST'); ?>/css/style.css" media="all"><script type="text/javascript" src="<?php echo sysconfig('CMS_BASEHOST'); ?>/js/jquery.min.js"></script><script type="text/javascript" src="<?php echo sysconfig('CMS_BASEHOST'); ?>/js/ad.js"></script><script>uaredirect("http://m.bnbni.com/cat{dede:type}[field:id/]{/dede:type}/id{dede:field name='aid' /}");</script></head><body><script>site();</script>
@include('home.common.header')<div id="tad"><script>tjs();</script></div>

<div class="box mt10"><div class="fl_640">
<h1 class="arct"><?php echo $post["title"]; ?></h1><div class="timely"><?php if(!empty($post['writer'])){ echo '<span id="awriter">'.$post['writer'].'</span> '; } ?><span id="atime"><?php echo date("Y-m-d H:i",$post['pubdate']); ?></span> <?php if(!empty($post['source'])){ ?><?php echo '<span id="asource">'.$post['source'].'</span> '; ?><?php } ?><span id="aclick">阅读:<?php echo $post["click"]; ?>次</span> <span id="akeyword">关键词:<?php echo $post["keywords"]; ?></span></div><div class="dad1"><script>djs1();</script></div>
<div class="content"><?php echo $post["body"]; ?><div class="dad2"><script>djs2();</script></div>
<div class="dinfo"><span class="fr">下一篇：<?php if($pre){ ?><a href="<?php echo get_front_url(array("id"=>$pre['id'],"catid"=>$pre["typeid"],"type"=>'content')); ?>"><?php echo $pre["title"]; ?></a><?php }else{echo '没有了';} ?></span><div class="cl"></div></div>
</div><div class="dad3"><script>djs3(<?php echo $post["id"]; ?>);</script></div></div><!-- fl_640 end -->

<div class="fr_300"><div id="rad1"><script>rjs1();</script></div>
<div class="side"><div class="stit"><h3>近期文章</h3><a href="javascript:getmore({PageSize:5,typeid:<?php echo $post['typeid']; ?>,mode:1,orderby:'rand()'});" class="more">换一换</a><div class="cl"></div></div>	
<ul class="uli chs" id="xglist"><?php $posts=arclist(array("row"=>5,"typeid"=>$post['typeid'],"expression"=>[['id', '<', $pre?$pre['id']:$post["id"]]]));if($posts){foreach($posts as $row){ ?><li><a target="_blank" href="<?php echo get_front_url(array("id"=>$row['id'],"catid"=>$row['typeid'],"type"=>'content')); ?>"><?php echo $row['title']; ?></a></li><?php }} ?></ul><div class="cl"></div></div>

<div id="rad3"><script>rjs3();</script></div>
<div class="side"><div class="stit"><h3>猜你喜欢</h3><a href="javascript:getmore({PageSize:5,typeid:<?php echo $post['typeid']; ?>,mode:2,orderby:'rand()'});" class="more">换一换</a><div class="cl"></div></div>
<div class="uli2" id="xglike"><?php $posts=arclist(array("row"=>5,"typeid"=>$post['typeid'],"orderby"=>'rand()'));foreach($posts as $row){ ?><div class="suli"><?php if(!empty($row['litpic'])){ ?><a class="limg" href="<?php echo get_front_url(array("id"=>$row['id'],"catid"=>$row['typeid'],"type"=>'content')); ?>"><img alt="<?php echo $row['title']; ?>" src="<?php echo $row['litpic']; ?>"></a><?php } ?><a target="_blank" href="<?php echo get_front_url(array("id"=>$row['id'],"catid"=>$row['typeid'],"type"=>'content')); ?>"><?php echo $row['title']; ?></a><div class="sulii"><?php if(!empty($row['writer'])){echo '<span class="time">'.$row['writer'].'</span>';}elseif(!empty($row['source'])){echo '<span class="time">'.$row['source'].'</span>';} ?> 阅读(<?php echo $row['click']; ?>)</div><div class="cl"></div></div><?php } ?><div class="cl"></div></div></div>

<div id="rad2"><script>rjs2();</script></div></div><!-- fr_300 end --></div><!-- box end -->
<script>
function getmore(condition)
{
    var url = "<?php echo sysconfig('CMS_BASEHOST'); ?>/api/listarc";
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