<!DOCTYPE html><html><head><meta http-equiv="Content-Type" content="text/html;charset=UTF-8" /><meta name="viewport" content="width=device-width,initial-scale=1.0">
<title><?php echo $post["title"]; ?>_<?php echo sysconfig('CMS_WEBNAME'); ?></title><link rel="stylesheet" href="/css/wap.css" media="all"><script type="text/javascript" src="/js/jquery.min.js"></script></head><body>

<header class="mheader-a"><h2 class="bt"><?php echo sysconfig('CMS_WEBNAME'); ?></h2><a href="javascript:;"><div class="phone-icon telphone"></div></a></header>

@include('wap.common.header')
<article class="mbanner-b mb10"><a href=""><img src="/images/banner.jpg"></a></article>

<article class="mbox cinfo"><h1 class="tith"><?php echo $post["title"]; ?></h1>
<div class="mabout-a"><p>时间：<?php echo date("Y-m-d",$post["pubdate"]); ?></p><?php echo $post["body"]; ?>
<br>下一篇：<?php if($pre){ ?><a href="<?php echo get_front_url(array("id"=>$pre['id'],"type"=>'content')); ?>"><?php echo $pre["title"]; ?></a><?php }else{echo '没有了';} ?></div></article>

<article class="mbox"><h3 class="tit"><i class="tit_icon"></i>相关推荐</h3><ul class="mnews-b" id="ajlist"><?php $posts=arclist(array("row"=>5,"typeid"=>$post["typeid"],"orderby"=>'rand()'));foreach($posts as $row){ ?>
<li><span class="group">[<?php echo date("Y-m-d",$row['pubdate']); ?>]</span><a href="<?php echo get_front_url(array("id"=>$row['id'],"type"=>'content')); ?>"><?php echo $row['title']; ?></a></li><?php } ?>
</ul><div class="about-more more mt10"><a id="listbu" href="javascript:;">查看更多<i class="phone-icon mico"></i></a></div></article>

<script>
$(function(){
var page = 2;
$('#listbu').click(function(){
	$.ajax({
		url: "<?php echo route('api_listarc'); ?>",
		dataType: "json",
		type: "POST",
		data: {
			"_token":'{{ csrf_token() }}',
			"typeid":<?php echo $post["typeid"] ?>,
			"PageIndex":page,
			"PageSize":5
		},
		success: function(data){
			if(data.code==0)
			{
				var json = data.data; //数组
				var str = '';
				$.each(json, function (index) {
					//循环获取数据
					var title = json[index].title;
					var id = json[index].id;
					var url = json[index].url;
					var pubdate = json[index].pubdate;
					
					str = str + '<li><span class="group">['+pubdate+']</span><a href="'+url+'" target="_blank">'+title+'</a></li>';
				});
				
				if(str!='')
				{
					$('#ajlist').append(str);
				}
				else
				{
					$('#listbu').text("亲，没有啦！");
				}
				
			}
			else
			{
				
			}
		}
	});
	page++;
});
});
</script>
</body></html>