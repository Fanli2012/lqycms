//常用JS函数

// 时间戳转换普通日期格式
function add0(m){return m<10?'0'+m:m;}
function timestamp_to_date(timestamp)
{
    //timestamp是整数，否则要parseInt转换,不会出现少个0的情况
    var time = new Date(timestamp * 1000); //时间戳为10位需*1000，时间戳为13位的话不需乘1000
    var year = time.getFullYear();
    var month = time.getMonth()+1;
    var date = time.getDate();
    var hours = time.getHours();
    var minutes = time.getMinutes();
    var seconds = time.getSeconds();
    
    var res = new Array();
    
    res['Y'] = year;
    res['m'] = add0(month);
    res['d'] = add0(date);
    res['H'] = add0(hours);
    res['i'] = add0(minutes);
    res['s'] = add0(seconds);
    
    return res;
    //return year+'-'+add0(month)+'-'+add0(date)+' '+add0(hours)+':'+add0(minutes)+':'+add0(seconds);
}

// 日期转时间戳
function date_to_timestamp(stringTime)
{
    //var stringTime = "2014-07-10 10:21:12";
    var timestamp = Date.parse(new Date(stringTime));
    timestamp = timestamp / 1000;
    
    return timestamp;
}








