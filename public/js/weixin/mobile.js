$(function(){
	//头部菜单
	$('.classreturn .nav_menu a:last').click(function(e){
		$('.tpnavf').toggle();
		e.stopPropagation();
	});
	//左侧导航
	$('.classlist ul li').click(function(){
		$(this).addClass('red').siblings().removeClass('red');
	});
})