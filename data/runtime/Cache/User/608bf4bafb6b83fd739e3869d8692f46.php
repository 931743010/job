<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,Chrome=1" />
	<title>登录</title>
	<link rel="stylesheet" type="text/css" href="/tpl/v1/Public/css/bootstrap.min.css"/>
	<link rel="stylesheet" type="text/css" href="/tpl/v1/Public/css/bootstrap-theme.min.css"/>
	<link rel="stylesheet" type="text/css" href="/tpl/v1/Public/css/base.css"/>
	<link rel="stylesheet" type="text/css" href="/tpl/v1/Public/css/top.css"/>
		
	<script src="/statics/js/jquery-1.11.1.min.js" type="text/javascript"></script>
	<script src="/statics/js/bootstrap.min.js" type="text/javascript"></script>
	<script src="/tpl/v1/Public/js/lib/html5.js" type="text/javascript" charset="utf-8"></script>
	<script src="/tpl/v1/Public/js/main.js" type="text/javascript" charset="utf-8"></script>
	<script src="/tpl/v1/Public/js/placeholder.js" type="text/javascript" charset="utf-8"></script>
	<link rel="stylesheet" type="text/css" href="/tpl/v1/Public/css/login.css"/>
    <link href="/tpl/v1/Public/zp/css/common.css" rel="stylesheet" type="text/css" />
    <link href="/tpl/v1/Public/zp/css/style.css" rel="stylesheet" type="text/css" />
</head>
<body class="theme page-2">
<header style="width: 980px;margin: 0 auto">

        <div class="head-logo">
			<div class="head-block">
				<a class="logo" href="/">
					<img src="/tpl/v1/Public/images/logo.png"/>
				</a>
				<div class="top-txt">
					<div class="wel-txt">
                        用户登录中心
					</div>

				</div>
				
			</div>
		</div>
	</header>	
	<div class="wrapper wrapper-2">
		<div class="wrap">
			
			<section>
				<div class="login-box">
					<div class="login-hd">
						<h3>用户登录</h3>
					</div>
					<div class="login-bd">
							<div class="login_message">
								<!--您輸入的密碼錯誤-->
							</div>
							<div class="login-name input">
								<input type="text" name="username"  value="" placeholder="请输入邮箱/用户名" />
							</div>
							<div class="login-pwd input">
								<input type="password" name="password"  value="" placeholder="请输入密码" />
							</div>
							<div class="login-links">
								<span class="auto-login">
									<input type="checkbox" name="auto_login" id="" value="1" />
									自动登录
								</span>
								<a class="forget-pwd" href="<?php echo U('user/login/password_find');?>">忘记密码？</a>
							</div>
							<div class="login-button">
								<input class="btn btn-lg btn-block" type="submit" value="登录"/>
                                <br />
                                <a href="<?php echo U('user/register/index');?>">无账号，免费注册</a>
							</div>
					</div>
				</div>
			</section>
			
			
			
		</div>		
	</div>
	<!--<div id="footer" class="footer">
    <div class="fmain autow">
        <div class="f-nav">
            <ul class="flul">
                <li><a href="">关于我们</a></li>
                <li><a href="">帮助中心</a></li>
                <li><a href="">联系我们</a></li>
                <li><a href="">加入我们</a></li>
            </ul>
        </div>
        <div class="c"></div>
        <div class="copy-right">
            <p>版权所有 2015-2018 公司名称 粤icp备：icp000000000</p>
            <p>深圳市公安网络备案编号：10000000</p>
        </div>
    </div>
</div>-->
<div id="footer" class="footer">
    <div class="fmain autow">
        <div class="c"></div>
        <div class="copy-right">
            <!--<p>版权所有 2015-2018 公司名称 粤icp备：icp000000000</p>-->
            <p>版权所有: <a href="">© 人工在线</a></p>
            <p>深圳市公安网络备案编号：10000000</p>
        </div>
    </div>
</div>

    <script>
		$(document).ready(function(){
			$("input[type=submit]").click(function(){
			var auto_login = $("input[name=auto_login]").prop('checked')?1:0;
				$.ajax({
					url:"<?php echo U('user/login/dologin');?>",
					type:'post',
					data:{username:$('input[name=username]').val(),
						  password:$('input[name=password]').val(),
						  auto_login:auto_login,
						},
					success:function(data){
						if(data.status==1){
							location.href=data.url;
						}else{
							alert(data.info);
						}
					}
				})
			})
		})
	</script>
</body>
</html>