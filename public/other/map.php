<html><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>百度地图</title>
<script type="text/javascript" src="http://api.map.baidu.com/api?v=1.5&ak=4d555dbf90449a9845572a5c57d40a4f"></script>
</head><body>
<div style="width:<?php echo $_GET["width"]; ?>px;height:<?php echo $_GET["height"]; ?>px;border:1px solid gray" id="container"></div>
<script type="text/javascript">
/* 坐标获取到：http://api.map.baidu.com/lbsapi/getpoint/index.html
 * 案例：http://www.72p.org/other/map.php?x=118.122577&y=24.473587&width=300&height=200
 */
var map = new BMap.Map("container");
map.centerAndZoom(new BMap.Point(<?php echo $_GET["x"]; ?> ,<?php echo $_GET["y"]; ?>), 18);
map.enableScrollWheelZoom();
var marker=new BMap.Marker(new BMap.Point(<?php echo $_GET["x"]; ?> ,<?php echo $_GET["y"]; ?>));
map.addOverlay(marker);

function gotobaidu(type)
{
	if($.trim($("input[name=origin]").val())=="")
	{
		alert("请输入起点！");
		return;
	}else{
		if(type==1)
		{
			$("input[name=mode]").val("transit");
			$("#gotobaiduform")[0].submit();
		}else if(type==2)
		{
			$("input[name=mode]").val("driving");
			$("#gotobaiduform")[0].submit();
		}
	}
} 
</script>
</body></html>