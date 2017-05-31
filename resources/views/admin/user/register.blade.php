<!DOCTYPE html><html><head><meta http-equiv="Content-Type" content="text/html;charset=UTF-8" /><meta name="viewport" content="width=device-width, initial-scale=1">
<title>注册</title>
<link rel="stylesheet" href="/css/bootstrap.min.css"><link rel="stylesheet" href="/css/admin.css"><script src="/js/jquery.min.js"></script><script src="/js/ad.js"></script></head><body>

<div style="margin:100px auto;width:300px;">
<h1 style="text-align:center;">注册</h1>
<form id="reg">
<div class="form-group"><input type="text" class="form-control required" name="username" id="username" placeholder="用户名"></div>
<div class="form-group"><input type="password" class="form-control required" name="pwd" id="pwd" placeholder="密码"></div>
<button type="submit" class="btn btn-success" value="Submit">注册</button>
</form>
</div>
<script>
$(function(){
    $(".required").blur(function(){
        var $parent = $(this).parent();
        $parent.find(".formtips").remove();
        if(this.value=="")
        {
            $parent.append(' <small class="formtips onError"><font color="red">不能为空！</font></small>');
        }
        else
        {
            $parent.append(' <small class="formtips onSuccess"><font color="green">OK</font></small>');
        }
    });
    
    $("#reg").submit(function(){
        $(".required").trigger('blur');
        var numError = $('#reg .onError').length;
        
        if(numError){return false;}
        
        $.ajax({
            url: "/Fladmin/User/doregister",
            type: "POST",
            dataType: "json",
            cache: false,
            data: {
                "username":$("#username").val(),
                "pwd":$("#pwd").val()
            },
            success: function(data){
                if(data.code==200)
                {
                    //alert(data.info);
                    window.location.replace("/Fladmin/User");
                }
            }
        });
    });
});
</script>
<script src="/js/bootstrap.min.js"></script></body></html>