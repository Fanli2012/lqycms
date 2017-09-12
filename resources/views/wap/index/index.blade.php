<!DOCTYPE html><html><head><meta http-equiv="Content-Type" content="text/html;charset=UTF-8" /><meta name="viewport" content="width=device-width,initial-scale=1.0">
<title><?php echo sysconfig('CMS_WEBNAME'); ?></title><link href="/favicon.ico" type="image/x-icon" rel="shortcut icon">
<link rel="stylesheet" href="/css/wap.css" media="all"><script type="text/javascript" src="/js/jquery.min.js"></script></head><body>

<header class="mheader-a"><h2 class="bt"><?php echo sysconfig('CMS_WEBNAME'); ?></h2><a href="javascript:;"><div class="phone-icon telphone"></div></a></header>

@include('wap.common.header')
<article class="mbanner-b mb10"><a href=""><img src="/images/banner.jpg"></a></article>

<article class="mbox"><h3 class="tit"><i class="tit_icon"></i>产品中心</h3><div class="mpicshow-b">
<ul class="mnewpic2"><?php $posts=arclist(array("table"=>"goods","row"=>4,"typeid"=>1,"expression"=>[["litpic","<>","''"]]));if($posts){foreach($posts as $row){ ?>
<li><a href="<?php echo get_wap_front_url(array("id"=>$row['id'],"catid"=>$row['typeid'],"type"=>'content')); ?>"><img src="<?php echo sysconfig('CMS_BASEHOST'); echo $row['litpic']; ?>" alt="<?php echo $row['title']; ?>"></a></li><?php }} ?>
</ul><div class="more"><a href="<?php echo get_wap_front_url(array('catid'=>1,'type'=>'productlist')); ?>">查看更多<i class="mico"></i></a></div>
</div></article>

<article class="mbox cinfo">
<h3 class="tit"><i class="tit_icon"></i>企业简介</h3><div class="mabout-a">百度，全球最大的中文搜索引擎、最大的中文网站。2000年1月创立于北京中关村。</div>
<div class="about-more more"><a href="<?php echo get_wap_front_url(array('pagename'=>'about','type'=>'page')); ?>">查看更多<i class="phone-icon mico"></i></a></div>
</article>

<article class="mbox"><h3 class="tit"><i class="tit_icon"></i>新闻中心</h3><ul class="mnews-b" id="ajlist"><?php $posts=arclist(array("row"=>8));if($posts){foreach($posts as $row){ ?>
<li><span class="group">[<?php echo date("Y-m-d",$row['pubdate']); ?>]</span><a href="<?php echo get_wap_front_url(array("id"=>$row['id'],"catid"=>$row['typeid'],"type"=>'content')); ?>"><?php echo $row['title']; ?></a></li><?php }} ?>
</ul><div class="about-more more mt10"><a id="listbu" href="javascript:;">查看更多<i class="phone-icon mico"></i></a></div></article>

<article class="mbox"><h3 class="tit"><i class="tit_icon"></i>联系我们</h3><ul class="mcontact-a">
<li>联系人：<span name="moduleCate">王经理</span></li>
<li>电子邮箱：<span name="moduleCate">790238877@qq.com</span></li>
<li>联系方式：<span class="num">15280795142</span><a href="tel://10086" class="telbg"><i class="phone-icon tel"></i><span class="num_in">10086</span></a></li>
<li>联系方式：<span class="num">0374-59928888</span><a href="tel://15280795142" class="telbg"><i class="phone-icon tel"></i><span class="num_in">0374-7333112</span></a></li>
<li>联系地址：<span name="moduleCate">北京市海淀区上地十街10号百度大厦</span><a href="javascript:;" class="addressbg"><em class="phone-icon pint"></em></a></li>
<li>邮编：<span name="moduleCate">100085</span></li>
</ul></article>

<script>
$(function(){
var page = 1;
$('#listbu').click(function(){
	$.ajax({
		url: "<?php echo route('api_listarc'); ?>",
		dataType: "json",
		type: "POST",
		data: {
			"_token":'{{ csrf_token() }}',
			"typeid":4,
			"PageIndex":page,
			"PageSize":10
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