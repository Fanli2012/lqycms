<!DOCTYPE html><html><head><meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
<title><?php if($post){echo $post["name"].'_'.sysconfig('CMS_WEBNAME');}else{echo '动态';} ?></title><meta name="keywords" content="{dede:field.keywords/}" /><meta name="description" content="{dede:field.description function='html2text(@me)'/}" /><link rel="stylesheet" href="<?php echo sysconfig('CMS_BASEHOST'); ?>/css/style.css"><script type="text/javascript" src="<?php echo sysconfig('CMS_BASEHOST'); ?>/js/ad.js"></script></head><body>
@include('home.common.header')

<div class="box" style="padding-top:20px;">
<?php if(!empty($posts)){foreach($posts as $row){ ?><div class="list"><?php if(!empty($row['litpic'])){ ?><a class="limg" href="<?php echo get_front_url(array("id"=>$row['id'],"catid"=>$row['typeid'],"type"=>'content')); ?>"><img alt="<?php echo $row['title']; ?>" src="<?php echo $row['litpic']; ?>"></a><?php } ?>
<strong class="tit"><a href="<?php echo get_front_url(array("id"=>$row['id'],"catid"=>$row['typeid'],"type"=>'content')); ?>"><?php echo $row['title']; ?></a></strong><p><?php echo mb_strcut($row['description'],0,150,'UTF-8'); ?>..</p>
<div class="info"><span class="fl"><?php $taglist=taglist($row['id']);if($taglist){foreach($taglist as $row){ ?><a href="<?php echo get_front_url(array("tagid"=>$row['id'],"type"=>'tags')); ?>"><?php echo $row['tag']; ?></a><?php }} ?><em><?php echo date("m-d H:i",$row['pubdate']); ?></em></span><span class="fr"><em><?php echo $row['click']; ?></em>人阅读</span></div><div class="cl"></div></div><?php }} ?>
</div>

<?php if($pagenav){ ?><div class="pages"><ul><li style="width:180px;"><a href="<?php echo $pagenav; ?>">获取更多</a></li></ul><div class="cl"></div></div><?php } ?>

@include('home.common.footer')</body></html>