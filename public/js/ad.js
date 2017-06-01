function count_js(){document.writeln("              <div class=\"tm\"><img src=\"http://www.lqycms.com/images/2weima.gif\" width=\"115px\" height=\"150px\"><\/div>                  ");}
function itopjs(){document.writeln("<img width=960px height=90px src=\"http://www.lqycms.com/images/banner.gif\">");}
function tjs(){document.writeln("<img width=960px height=90px src=\"http://www.lqycms.com/images/banner.gif\">");}
function navjs(){document.writeln("");}
function site(){document.writeln("");}

function djs1(){document.writeln("");}
function djs2(){document.writeln("");}
function djs3(aid){document.writeln('');}
function djs4(){document.writeln("");}
function djs5(){document.writeln("");}
function djs6(){document.writeln("");}

function m_djs3(){document.writeln("");}

function rjs1(){document.writeln("");}
function rjs2(){document.writeln("");}
function rjs3(){document.writeln("");}

function ljs1(){document.writeln('');}
function ljs2(){document.writeln("");}

function ijs1(){document.writeln('<img src="/images/irad.gif">');}
function ijs2(){document.writeln("");}
function ijs3(){document.writeln("");}

function r1(){document.writeln("");}
function r2(){document.writeln("<a rel=\"nofollow\" href=\"http://www.lqycms.com/cat1/\" class=\"more\">换一换<\/a>");}

function IsPC(){
	var userAgentInfo = navigator.userAgent;
	var Agents = new Array("Android", "iPhone", "SymbianOS", "Windows Phone" ,"ios","webOS","WindowsPhone","BlackBerry","NOKIA","SAMSUNG","LG","LENOVO");
	var flag = true;
	for (var v = 0; v < Agents.length; v++) {
	   if (userAgentInfo.indexOf(Agents[v]) > 0) {flag = false; break;}
	}
	return flag;
}

function uaredirect(murl){
	if ((navigator.userAgent.match(/(iPhone|iPod|Android|ios|WindowsPhone|Windows Phone)/i))) {
		location.replace(murl);
	}
}

function reBlank(){
	if(IsPC()){}else{
		var a=document.getElementsByTagName("a");
		for(var i=0;i<a.length;i++){
			if (a[i].getAttribute("target")) {
				a[i].setAttribute("target","_self");
			}
		}
	}
}

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











