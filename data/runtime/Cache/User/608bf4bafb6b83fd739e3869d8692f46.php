<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,Chrome=1" />
	<title>首頁</title>
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
</head>
<body class="theme page-2">	
	<header>		
		<div class="head-logo">
			<div class="head-block">
				<a class="logo" href="/">
					<img src="/tpl/v1/Public/images/logo1.png"/>
				</a>
				<div class="top-txt">
					<div class="wel-txt">
						歡迎光臨hmv，<a href="<?php echo U('user/register/index');?>">免費註冊</a>
					</div>
					<ul class="fr navtop-right">					
						<li class="lang"><a>English</a><a class="on">繁</a><a href="index.html">簡</a></li>
					</ul>
				</div>
				
			</div>
		</div>
	</header>	
	<div class="wrapper wrapper-2">
		<div class="wrap">
			
			<section>
				<div class="login-box">
					<div class="login-hd">
						<h3>用戶登錄</h3>
					</div>
					<div class="login-bd">
							<div class="login_message">
								<!--您輸入的密碼錯誤-->
							</div>
							<div class="login-name input">
								<input type="text" name="username" id="" value="" placeholder="請輸入郵箱/手機號" />
							</div>
							<div class="login-pwd input">
								<input type="password" name="password" id="" value="" placeholder="請輸入密碼" />
							</div>
							<div class="login-links">
								<span class="auto-login">
									<input type="checkbox" name="auto_login" id="" value="1" />
									自動登錄
								</span>
								<a class="forget-pwd" href="<?php echo U('user/login/password_find');?>">忘記密碼？</a>
							</div>
							<div class="login-button">
								<input class="btn btn-lg btn-block" type="submit" value="登錄"/>
							</div>
					</div>
				</div>
			</section>
			
			
			
		</div>		
	</div>
	<div id="footer" class="footer">
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