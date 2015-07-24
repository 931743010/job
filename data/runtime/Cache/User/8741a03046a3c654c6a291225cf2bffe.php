<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,Chrome=1" />
	<title>找回密码</title>
	
		<link rel="stylesheet" type="text/css" href="/trunk/job/tpl/v1/Public/css/bootstrap.min.css"/>
	<link rel="stylesheet" type="text/css" href="/trunk/job/tpl/v1/Public/css/bootstrap-theme.min.css"/>
	<link rel="stylesheet" type="text/css" href="/trunk/job/tpl/v1/Public/css/base.css"/>
	<link rel="stylesheet" type="text/css" href="/trunk/job/tpl/v1/Public/css/top.css"/>
		
	<script src="/statics/js/jquery-1.11.1.min.js" type="text/javascript"></script>
	<script src="/statics/js/bootstrap.min.js" type="text/javascript"></script>
	<script src="/trunk/job/tpl/v1/Public/js/lib/html5.js" type="text/javascript" charset="utf-8"></script>
	<script src="/trunk/job/tpl/v1/Public/js/main.js" type="text/javascript" charset="utf-8"></script>
	<script src="/trunk/job/tpl/v1/Public/js/placeholder.js" type="text/javascript" charset="utf-8"></script>
	<link rel="stylesheet" type="text/css" href="/trunk/job/tpl/v1/Public/css/order.css"/>

</head>
<body class="theme">	
	<link href="/trunk/job/tpl/v1/Public/zp/css/common.css" rel="stylesheet" type="text/css" />
<link href="/trunk/job/tpl/v1/Public/zp/css/style.css" rel="stylesheet" type="text/css" />
<div class="header" id="header">

    <div class="top">
        <div style="width: 980px;margin: 0 auto;">
            <div class="cl816">
                <div class="top-left fl">
                    <ul class="flul">
                        <li><span>城市：</span><span id="city"></span> <a href="<?php echo U('Portal/index/change_city');?>">[切换城市]</a></li>
                        <li><span>天气：</span> <span id="weather"> </span></li>
                    </ul>
                </div>
                <div class="top-right fr">
                    <ul class="flul">

                        <?php if($_SESSION['user']['id']): ?><li><?php echo ($_SESSION['user']['user_realname']); ?><a href="<?php echo U('User/my/index');?>">  您好</a></li>
                        <li><a href="<?php echo U('user/my/index');?>">会员中心</a></li>
                        <li><a href="<?php echo U('user/index/logout');?>">退出</a></li>
                        <?php else: ?>
                        <li><a href="<?php echo U('User/Login/index');?>">登陆</a></li>
                        <li><a href="<?php echo U('User/register/index');?>">注册</a></li><?php endif; ?>
                        <!--<li><a href="<?php echo U('user/jobs/aejobs');?>">发布需求信息</a></li>-->
                    </ul>
                </div>

                <div class="c"></div>
            </div>
        </div>

    </div>
    <div class="h-center">
        <div class="head-banner">
            <img src="/trunk/job/tpl/v1/Public/zp/images/top-banner.gif" alt=""/>
        </div>
        <div class="h-center-bottom">
            <div class="logo fl"><a href="http://localhost/zp/"><img src="/trunk/job/tpl/v1/Public/images/logo.png" alt="XG人才招聘系统" border="0" align="absmiddle" /></a></div>
            <div class="search fl">
                <form action="">
                    <input type="text" id="top-search" class="search-control" placeholder="请输入关键字查询" value=""/>
                    <button class="btn-search" id="search-btn">搜索</button>

                </form>
            </div>
            <div class="publish fl">
                <a href="<?php echo U('user/jobs/aejobs');?>" class="publish">发布信息</a>
            </div>
            <div class="c"></div>
        </div>
        <!--导航start-->
        <div class="nav">
            <ul class="flul">
                <li><a href="<?php echo U('Portal/Index/index');?>" target="_self">首  页</a><span class="shu"></span></li>

                <li><a href="<?php echo U('Portal/Jobs/category');?>&catid=126">家政服务</a><span class="shu"></span></li>
                <li><a href="<?php echo U('Portal/Jobs/category');?>&catid=128">文化生活</a><span class="shu"></span></li>
                <li><a href="<?php echo U('Portal/Jobs/category');?>&catid=132">社区综合</a><span class="shu"></span></li>
            </ul>
        </div>
        <!--导航end-->
    </div>
    <script>
        <?php if($_SESSION['wiki']['cityId']> 0): ?>$(".top span#city").html("<?php echo ($_SESSION['wiki']['city']); ?>");
            $(".top span#weather").html("<?php echo ($_SESSION['wiki']['weather']); ?>");<?php endif; ?>
        <?php if($Think.session.wiki.weather): ?>$(".top span#weather").html("<?php echo ($_SESSION['wiki']['weather']); ?>");<?php endif; ?>
        if( $(".top span#weather").html()==''){
            $.ajax({
                url:"<?php echo U('Portal/Index/getWiki');?>",
                data:{},
                type:'POST',
                dataType:'json',
                success:function(data){
                    $(".top span#city").html(data.city);
                    $(".top span#weather").html(data.weather);
                }
            });
        }

        $("#search-btn").click(function (e) {
            var keyword = $("#top-search").val();
            var url = "<?php echo U('jobs/lists');?>&keyword="+keyword;
            location.href = url;
            return false;
        })
    </script>
</div>
	
	<div class="wrapper pwd-reset">
		<div class="wrap border">
			<div class="pwd-process-01">				
			</div>
			<div class="reset-main">
				<form action='<?php echo U("user/login/password_find_by_mobile");?>' method='post' onsubmit='return checkForm();'>
				<div class="grid">
					<div class="input-box">
						<label for="">账户名</label>
						<div class="input-out">
							<input type="text" name="username" id="" value="" placeholder="邮箱/手机号码"/>
						</div>
					</div>
				</div>
				<div class="grid">
					<div class="input-box ver-Code">
						<label for="">验证码</label>
						<div class="input-out">
							<input type="text" name="verify" id="" value="" />
						</div>						
					</div>
					<div class="ver-code-btn">
						<a href="javascript:void(0)"><?php echo sp_verifycode_img('code_len=4&font_size=15&width=100&height=50&charset=1234567890');?></a>
						<a <a onclick="$('.verify_img').attr('src' , '/index.php?g=Api&amp;m=Checkcode&amp;a=index&amp;code_len=4&amp;font_size=15&amp;width=100&amp;height=50&amp;charset=1234567890&amp;time='+Math.random())" style="cursor: pointer;">换一张</a>
					</div>
				</div>
				<div class="grid">
					<input type='submit' class="btn-next btn btn-lg btn-block" value='下一步'/>
				</div>
				</form>
			</div>
		</div>		
	</div>
	
	<!-- <div id="footer" class="footer">
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
</div> -->
<div id="footer" class="footer">
        <div class="fmain autow">
            <div class="c"></div>
            <div class="copy-right">
                <!--<p>版权所有 2015-2018 公司名称 粤icp备：icp000000000</p>-->
                <p>版权所有: <a href="">© 人工在线</a></p>
                <p><a href="http://www.miitbeian.gov.cn/" target="_blank">粤ICP备15056824</a></p>
            </div>
        </div>
    </div>
	<script>
	function checkForm(){
		var arg=null;
		$.ajax({
			url:'<?php echo U("user/login/password_find_by_mobile");?>',
			type:'post',
			async:false,
			data:{username:$("input[name=username]").val(),verify:$("input[name=verify]").val()},
			success:function(data){
				if(data.status==1){
					if(data.info==2){
						location.href="<?php echo U('User/login/password_find_by_mobile_show');?>";
					}else{
						location.href="<?php echo U('User/login/password_find_by_email_show');?>";
					}
					arg=false;
				}else{
					alert(data.info);
					arg=false;
					$('.verify_img').attr('src' , '/index.php?g=Api&m=Checkcode&a=index&code_len=4&font_size=15&width=100&height=50&charset=1234567890&time='+Math.random());
				}				
			}
		});
		return arg;
	}
	</script>
</body>
</html>