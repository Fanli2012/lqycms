<!DOCTYPE html><html><head><meta http-equiv="Content-Type" content="text/html;charset=UTF-8" /><meta name="viewport" content="width=device-width, initial-scale=1">
<title>后台登录</title>
<link rel="stylesheet" href="/css/bootstrap.min.css"><link rel="stylesheet" href="/css/admin.css"><script src="/js/jquery.min.js"></script><script src="/js/ad.js"></script></head><body>
<style>
body {
    font-family: "Helvetica Neue",Helvetica,Arial,sans-serif;
    font-size: 16px;
    color: #888;
    line-height: 30px;
    text-align: center;
	background-color: #000;
}
.form-box {
	margin-top: 35px;
}
.form-top {
	overflow: hidden;
	padding: 0 25px 15px 25px;
	background: #fff;
	-moz-border-radius: 4px 4px 0 0; -webkit-border-radius: 4px 4px 0 0; border-radius: 4px 4px 0 0;
	text-align: left;
}

.form-top-left {
	float: left;
	width: 75%;
	padding-top: 25px;
}

.form-top-left h3 { margin-top: 0;
font-size: 22px;
    font-weight: 300;
    color: #555;
    line-height: 30px;}

.form-top-right {
	float: left;
	width: 25%;
	padding-top: 5px;margin-top:15px;
	font-size: 66px;
	color: #ddd;
	text-align: right;
}

.form-bottom {
	padding: 25px 25px 30px 25px;
	background: #eee;
	-moz-border-radius: 0 0 4px 4px; -webkit-border-radius: 0 0 4px 4px; border-radius: 0 0 4px 4px;
	text-align: left;
}

.form-bottom form textarea {
	height: 100px;
}

.form-bottom form button.btn {
	width: 100%;
}

.form-bottom form .input-error {
	border-color: #4aaf51;
}

.social-login {
	margin-top: 35px;
}

.social-login h3 {
	color: #fff;
}

.social-login-buttons {
	margin-top: 25px;
}
input[type="text"], input[type="password"], textarea, textarea.form-control {
    height: 50px;
    margin: 0;
    padding: 0 20px;
    vertical-align: middle;
    background: #f8f8f8;
    border: 3px solid #ddd;
    font-family: 'Roboto', sans-serif;
    font-size: 16px;
    font-weight: 300;
    line-height: 50px;
    color: #888;
    -moz-border-radius: 4px;
    -webkit-border-radius: 4px;
    border-radius: 4px;
    -moz-box-shadow: none;
    -webkit-box-shadow: none;
    box-shadow: none;
    -o-transition: all .3s;
    -moz-transition: all .3s;
    -webkit-transition: all .3s;
    -ms-transition: all .3s;
    transition: all .3s;
}
button.btn {
    height: 50px;
    margin: 0;
    padding: 0 20px;
    vertical-align: middle;
    background: #4aaf51;
    border: 0;
    font-family: 'Roboto', sans-serif;
    font-size: 16px;
    font-weight: 300;
    line-height: 50px;
    color: #fff;
    -moz-border-radius: 4px;
    -webkit-border-radius: 4px;
    border-radius: 4px;
    text-shadow: none;
    -moz-box-shadow: none;
    -webkit-box-shadow: none;
    box-shadow: none;
    -o-transition: all .3s;
    -moz-transition: all .3s;
    -webkit-transition: all .3s;
    -ms-transition: all .3s;
    transition: all .3s;
}
button.btn:hover { opacity: 0.6; color: #fff; }
</style>
<div class="container-fluid">
<div class="row">
	<div class="col-sm-6 col-sm-offset-3 form-box">
		<div class="form-top">
			<div class="form-top-left">
				<h3>后台登录</h3>
				<p>请输入您的用户名、密码:</p>
			</div>
			<div class="form-top-right">
				<i class="glyphicon glyphicon-user"></i>
			</div>
		</div>
		<div class="form-bottom">
			<form method="post" action="/dologin" class="login-form" role="form">
				<div class="form-group">
					<label class="sr-only" for="form-username">Username</label>
					<input type="text" id="username" name="username" placeholder="用户名/邮箱/手机号..." class="form-username form-control">
				</div>
				<div class="form-group">
					<label class="sr-only" for="form-password">Password</label>
					<input type="password" id="pwd" name="pwd" placeholder="输入密码..." class="form-password form-control">
				</div>
				<button type="submit" class="btn">立即登录</button>
			</form>
		</div>
	</div>
</div>
</div>
<script>
$('.login-form input[type="text"], .login-form input[type="password"], .login-form textarea').on('focus', function() {
	$(this).removeClass('input-error');
});
    
$('.login-form').on('submit', function(e) {
	$(this).find('input[type="text"], input[type="password"], textarea').each(function(){
		if( $(this).val() == "" ) {
			e.preventDefault();
			$(this).addClass('input-error');
		}
		else {
			$(this).removeClass('input-error');
		}
	});
});
</script>
<script src="/js/bootstrap.min.js"></script></body></html>