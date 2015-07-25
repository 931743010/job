<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,Chrome=1" />
	<title>注册中心</title>
		<link rel="stylesheet" type="text/css" href="/tpl/v1/Public/css/bootstrap.min.css"/>
	<link rel="stylesheet" type="text/css" href="/tpl/v1/Public/css/bootstrap-theme.min.css"/>
	<link rel="stylesheet" type="text/css" href="/tpl/v1/Public/css/base.css"/>
	<link rel="stylesheet" type="text/css" href="/tpl/v1/Public/css/top.css"/>
		
	<script src="/statics/js/jquery-1.11.1.min.js" type="text/javascript"></script>
	<script src="/statics/js/bootstrap.min.js" type="text/javascript"></script>
	<script src="/tpl/v1/Public/js/lib/html5.js" type="text/javascript" charset="utf-8"></script>
	<script src="/tpl/v1/Public/js/main.js" type="text/javascript" charset="utf-8"></script>
	<script src="/tpl/v1/Public/js/placeholder.js" type="text/javascript" charset="utf-8"></script>
	<link rel="stylesheet" type="text/css" href="/tpl/v1/Public/js/skin/layer.css"/>
    <link rel="stylesheet" type="text/css" href="/tpl/v1/Public/js/skin/layer.ext.css"/>
    <script src="/tpl/v1/Public/js/layer/layer.js" type="text/javascript" charset="utf-8"></script>
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
						欢迎光临，<a href="<?php echo U('user/login/index');?>">请登录</a>
					</div>
				</div>
				
			</div>
		</div>
	</header>	
	<div class="wrapper wrapper-1">
		<div class="wrap">
			<section>
				<div class="reg-box">
					<div class="reg-hd">
						<ul class="reg-block">
							<li class="active">注册中心</li>

						</ul>
					</div>					
					<div class="reg-bd">
						<div class="reg-form reg-block">
							<ul>
                                    <input type='hidden' name='reg_type' value='1'>
								<li>
									<span class="label-name">邮　　箱</span>
									<div class="input">
										<input type="text" name="username" id="email_username" value="" placeholder="请输入邮箱地址"/>
									</div>
								</li>
                                <li>
                                    <span class="label-name">用户名</span>
                                    <div class="input">
                                        <input type="text" name="user_realname" id="user_realname" value="" placeholder="请输入用户名"/>
                                    </div>
                                </li>
								<li>									
									<span class="label-name">验&nbsp;&nbsp;证&nbsp;码</span>
									<div class="pass-ver-btn">
										<a href="javascript:void(0)"><?php echo sp_verifycode_img('code_len=4&font_size=15&width=120&height=50&charset=1234567890');?></a>
										<a onclick="$('.verify_img').attr('src' , '/index.php?g=Api&amp;m=Checkcode&amp;a=index&amp;code_len=4&amp;font_size=15&amp;width=120&amp;height=50&amp;charset=1234567890&amp;time='+Math.random())" style="cursor: pointer;">换一张</a>
									</div>
									<div class="input ver-Code">
										<input type="text" name="verify" id="" value="" />
									</div>									
								</li>
								<li>
									<span class="label-name">设置密码</span>
									<div class="input">
										<input type="password" name="password" id="email_password" value="" placeholder="6-20个大小写英文字母、符号或数字" />
									</div>
								</li>
								<li>
									<span class="label-name">确认密码</span>
									<div class="input">
										<input type="password" name="repassword" id="email_repassword" value="" placeholder="请再次输入密码" />
									</div>
								</li>
								<li>

									我已阅读并同意&nbsp;<a href="">《人工在线服务协议》</a> <input type="checkbox" name="agree" id="agree" checked="checked" value="1" />
								</li>
								<li>
									<button class="reg-btn btn btn-block btn-block">注册</button>
								</li>
							</ul>
							<ul class="hide">
								<input type='hidden' name='reg_type' value='2'>
								<li>
									<span class="label-name">手机号码</span>
									<div class="input">
										<input type="text" name="username" id="mobilePhone" value="" placeholder="请输入手机号码"/>
									</div>
								</li>
								<li>									
									<span class="label-name">验&nbsp;&nbsp;证&nbsp;码</span>
									<div class="pass-ver-btn">
										<!--<button class="ver-btn btn btn-block btn-lg">重新获取验证码</button>-->
										<button class="ver-btn get-code btn btn-block btn-lg">获取验证码</button>
									</div>
									<div class="input ver-Code">
										<input type="text" name="code" id="" value="" />
									</div>
									
								</li>
								<li>
									<span class="label-name">设置密码</span>
									<div class="input">
										<input type="password" name="password" id="phone_password" value="" placeholder="6-20个大小写英文字母、符号或数字" />
									</div>
								</li>
								<li>
									<span class="label-name">确认密码</span>
									<div class="input">
										<input type="password" name="repassword" id="phone_repassword" value="" placeholder="请再次输入密码" />
									</div>
								</li>
								<li>
									点击注册，表示您已同意&nbsp;<a href="">《hmv服务协议》</a>
								</li>
								<li>
									<button class="reg-btn btn btn-block btn-block">注册</button>
								</li>
							</ul>
						</div> 	
					</div>
				</div>
			</section>
		</div>		
	</div>
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
</body>
	<script type="text/javascript">
		$('.reg-hd ul li').click(function(){
			$(this).addClass('active').siblings().removeClass('active');
			$('.reg-form ul').eq($(this).index()).show().siblings().hide();
		});
        $(".get-code").click(function(){
            var phoneNum = $('#mobilePhone').val();
            var reg = new RegExp(/^[1][3458]{1}[0-9]{9}$/);

            if(!reg.test(phoneNum)){
                layer.alert('手机号码格式错误,请检查输入');
            }else{
                $.get('<?php echo U("user/register/sendCheckcode");?>',{'phone':phoneNum},function(data){
                    layer.alert(data.info);
                })
            }
            return false;
        });
        $("#agree").click(function () {
           var val = $(this).val();
            if(val ==1){
                $(this).val(0);
            }else{
                $(this).val(1);
            }
        });
		$("button.reg-btn").click(function(){
            var agree = $("#agree").val();
//            layer.alert(agree);return false;
            if(agree!=1){
                layer.alert("请先同意注册条款");
                return false;
            }
			var type = $(".reg-block li.active").html();
            var realname = $("input[name=user_realname]").val();
            if(realname==''){
                layer.alert('请输入用户名');
                return false;
            }
            if(realname.length<4 || realname.length>20){
                layer.alert('用户名不能低于4位或者超过20位');
                return false;
            }
			//if( type=='邮箱注册' ){
//				var reg_type = 1;
				var username = $("input[id=email_username]").val();
				var password = $("input[id=email_password]").val();
				var repassword = $("input[id=email_repassword]").val();
				var verify = $("input[name=verify]").val();
//			}else{
//				var reg_type = 2;
//				var username = $("input[id=mobilePhone]").val();
//				var password = $("input[id=phone_password]").val();
//				var repassword = $("input[id=phone_repassword]").val();
				var code = $("input[name=code]").val();
//			}
			$.ajax({
				url:"<?php echo U('user/register/doregister');?>",
				type:'post',
				data:{
					reg_type:1,
					username:username,
					password:password,
					repassword:repassword,
					verify:verify,
					code:code,
                    user_realname:realname
				},
				success:function(data){
					if(data.status==1){
						layer.alert("注册成功,3秒后跳转",function(){
							location.href="<?php echo U('user/login/index');?>";
						});
						setTimeout(function(){
							location.href="<?php echo U('user/login/index');?>";
						},3000)

						
					}else{
						layer.alert(data.info);
						$('.verify_img').attr('src' , '/index.php?g=Api&m=Checkcode&a=index&code_len=4&font_size=15&width=100&height=50&charset=1234567890&time='+Math.random());
					}
				}
			})
		})
	</script>	
</html>