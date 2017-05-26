$(function(){
	$.ajaxSetup({
		cache: false //关闭AJAX相应的缓存 
	});
	
	$("#btn-login").click(function(event){
		$('body').append('<div class="mask" id="login-box"><div class="login-outer"><div class="login-title">社交账号登录<a href="javascript:closediv(\'#login-box\');" class="btn-close" id="btn-close">关闭</a></div><div class="login-method"><a href="javascript:;" class="btn-login btn-qq"><span></span>用 QQ 登录</a></div></div></div>');
	});
});

//打印对象
function alertObj(obj)
{
	var output = "";
	for(var i in obj){  
		var property=obj[i];  
		output+=i+" = "+property+"\n"; 
	}  
	alert(output);
}

//根据id删除div
function closediv(divid)
{
	$(divid).remove();
}

//删除确认框
function delconfirm(url)
{
	if(confirm("确定删除吗"))
	{
		location.href= url;
	}
	else
	{
		
	}
}

//复选框反选
function selAll(arcID)
{
	var checkboxs=document.getElementsByName(arcID);
	
	for (var i=0;i<checkboxs.length;i++)
	{
		var e=checkboxs[i];
		e.checked=!e.checked;
	}
}

//获取选中的复选框的值
function getItems(arcID)
{
	if(!arcID){arcID='arcID';}
	var checkboxs=document.getElementsByName(arcID);
	
	var value = new Array();
	
	for(var i = 0; i < checkboxs.length; i++)
	{
		if(checkboxs[i].checked) value.push(checkboxs[i].value);
	}
	
	return value;
}












