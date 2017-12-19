<!DOCTYPE html><html><head><meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
<title><?php echo sysconfig('CMS_WEBNAME'); ?></title><meta name="keywords" content="{dede:field.keywords/}" /><meta name="description" content="{dede:field.description function='html2text(@me)'/}" /><link rel="stylesheet" href="<?php echo sysconfig('CMS_BASEHOST'); ?>/css/style.css"></head><body>
@include('home.common.header')

<style>
.cat-menu-h {padding:8px 0;background-color: #fff;}
.cat-menu-h ul {font-size: 14px;}
.cat-menu-h ul li {float: left;}
.cat-menu-h ul a {display: block;padding: 2px 10px;text-align: center;color: #666;white-space: nowrap;}
.cat-menu-h ul a:hover,.cat-menu-h ul .hover{background-color: #e61414;color: #fff;}
.cat-menu-h ul a.forecast:hover {background-color: #26a96d;color: #fff;}
.cat-menu-h ul a.forecast {color: #26a96d;}
</style>
<div class="box">
<div class="cat-menu-h">
<ul class="clearfix">
<li><a href="<?php echo route('home_goodslist'); ?>">全部</a></li>
<?php if($goods_type_list){foreach($goods_type_list as $k=>$v){ ?>
<li><a<?php if($v['id']==$id){echo ' class="hover"';} ?> href="<?php echo route('home_goodslist',array('id'=>$v['id'])); ?>"><?php echo $v['name']; ?></a></li><?php }} ?>
<li><a class="forecast" href="<?php echo route('home_goodslist',array('tuijian'=>1)); ?>"> [推荐] </a></li>
</ul>

<form method="get" target="_blank" class="m-sch fr" name="formsearch" action="/plus/search.php"><input class="sch-txt" name="q" type="text" value="搜索 按Enter键" onfocus="if(value=='搜索 按Enter键') {value=''}" onblur="if(value=='') {value='搜索 按Enter键'}"></form>
<div class="cl"></div></div>
</div>

<div style="background-color:#f6f6f6;padding:15px 0;">
<div class="box">
<ul class="pul">
<?php if($posts){foreach($posts as $k=>$v){ ?>
<li><a href="<?php echo route('home_goods',array('id'=>$v['id'])); ?>" target="_blank"><img src="<?php echo $v['litpic']; ?>" alt="<?php echo $v['title']; ?>">
<p class="title"><?php echo $v['title']; ?></p>
<p class="desc"><span class="price-point"><i></i>库存(<?php echo $v['goods_number']; ?>)</span> <?php echo $v['description']; ?></p>
<div class="item-prices red"><div class="item-link">立即<br>抢购</div><div class="item-info"><div class="price"><i>¥</i><em class="J_actPrice"><span class="yen"><?php echo $v['price']; ?></span></em></div>
<div class="dock"><div class="dock-price"><del class="orig-price">¥<?php echo $v['market_price']; ?></del> <span class="benefit">退货赔运费</span></div><div class="prompt"><div class="sold-num"><em><?php echo $v['sale']; ?></em> 件已付款</div></div></div>
</div></div>
</a></li>
<?php }} ?>
</ul></div>

<?php if($pagenav){ ?><div class="pages"><ul><li style="width:180px;"><a href="<?php echo $pagenav; ?>">获取更多</a></li></ul><div class="cl"></div></div><?php } ?>

</div><!-- box end -->@include('home.common.footer')
<script>//图片幻灯
var glide =new function(){
	function $id(id){return document.getElementById(id);};
	this.layerGlide=function(auto,oEventCont,oTxtCont,oSlider,sSingleSize,second,fSpeed,point){
		var oSubLi = $id(oEventCont).getElementsByTagName('li');
		var oTxtLi = $id(oTxtCont).getElementsByTagName('li');
		var interval,timeout,oslideRange;
		var time=1; 
		var speed = fSpeed 
		var sum = oSubLi.length;
		var a=0;
		var delay=second * 1000; 
		var setValLeft=function(s){
			return function(){
				oslideRange = Math.abs(parseInt($id(oSlider).style[point]));	
				$id(oSlider).style[point] =-Math.floor(oslideRange+(parseInt(s*sSingleSize) - oslideRange)*speed) +'px';		
				if(oslideRange==[(sSingleSize * s)]){
					clearInterval(interval);
					a=s;
				}
			}
		};
		var setValRight=function(s){
			return function(){	 	
				oslideRange = Math.abs(parseInt($id(oSlider).style[point]));							
				$id(oSlider).style[point] =-Math.ceil(oslideRange+(parseInt(s*sSingleSize) - oslideRange)*speed) +'px';
				if(oslideRange==[(sSingleSize * s)]){
					clearInterval(interval);
					a=s;
				}
			}
		}
		
		function autoGlide(){
			for(var c=0;c<sum;c++){oSubLi[c].className='';oTxtLi[c].className='';};
			clearTimeout(interval);
			if(a==(parseInt(sum)-1)){
				for(var c=0;c<sum;c++){oSubLi[c].className='';oTxtLi[c].className='';};
				a=0;
				oSubLi[a].className="active";
				oTxtLi[a].className = "active";
				interval = setInterval(setValLeft(a),time);
				timeout = setTimeout(autoGlide,delay);
			}else{
				a++;
				oSubLi[a].className="active";
				oTxtLi[a].className = "active";
				interval = setInterval(setValRight(a),time);	
				timeout = setTimeout(autoGlide,delay);
			}
		}
	
		if(auto){timeout = setTimeout(autoGlide,delay);};
		for(var i=0;i<sum;i++){	
			oSubLi[i].onmouseover = (function(i){
				return function(){
					for(var c=0;c<sum;c++){oSubLi[c].className='';oTxtLi[c].className='';};
					clearTimeout(timeout);
					clearInterval(interval);
					oSubLi[i].className = "active";
					oTxtLi[i].className = "active";
					if(Math.abs(parseInt($id(oSlider).style[point]))>[(sSingleSize * i)]){
						interval = setInterval(setValLeft(i),time);
						this.onmouseout=function(){if(auto){timeout = setTimeout(autoGlide,delay);};};
					}else if(Math.abs(parseInt($id(oSlider).style[point]))<[(sSingleSize * i)]){
							interval = setInterval(setValRight(i),time);
						this.onmouseout=function(){if(auto){timeout = setTimeout(autoGlide,delay);};};
					}
				}
			})(i)			
		}
	}
}

//调用语句
glide.layerGlide(
	true,         //设置是否自动滚动
	'iconBall',   //对应索引按钮
	'textBall',   //标题内容文本
	'show_pic',   //焦点图片容器
	740,          //设置滚动图片位移像素
	2,			  //设置滚动时间2秒 
	0.1,          //设置过渡滚动速度
	'left'		  //设置滚动方向“向左”
);</script></body></html>