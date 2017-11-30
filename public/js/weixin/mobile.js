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
    
    //设置图片长等于宽
    $(".imgzsy").height(function(){return $(this).width();});
});

//删除确认框
function delconfirm(url,des)
{
	if(!des){des='确定要删除吗？';}
    
    //询问框
    layer.open({
        content: des
        ,btn: ['确定', '取消']
        ,yes: function(index){
            location.href= url;
            layer.close(index);
        }
    });
}

//手机号验证
function validatemobile(mobile)
{
    if(mobile.length == 0 || mobile.length != 11) 
    {
        return false; 
    }
    
    var reg = /^(((13[0-9]{1})|(15[0-9]{1})|(18[0-9]{1}))+\d{8})$/;
    if(!reg.test(mobile))
    {
        return false;
    }
    
    return true;
}

//提示层
function messageNotice(message,time)
{
    time = time*1000 || 3000;
    // 创建一个 Mask 层，追加到body中
    $('body').append('<div id="mask_msg"></div>');
	$('#mask_msg').html(message);
	$('#mask_msg').show();
	setInterval(function(){$('#mask_msg').remove();},time);
}
