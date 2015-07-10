<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,Chrome=1" />
	<title>頭像照片</title>
	
		<link rel="stylesheet" type="text/css" href="/tpl/v1/Public/css/bootstrap.min.css"/>
	<link rel="stylesheet" type="text/css" href="/tpl/v1/Public/css/bootstrap-theme.min.css"/>
	<link rel="stylesheet" type="text/css" href="/tpl/v1/Public/css/base.css"/>
	<link rel="stylesheet" type="text/css" href="/tpl/v1/Public/css/top.css"/>
		
	<script src="/statics/js/jquery-1.11.1.min.js" type="text/javascript"></script>
	<script src="/statics/js/bootstrap.min.js" type="text/javascript"></script>
	<script src="/tpl/v1/Public/js/lib/html5.js" type="text/javascript" charset="utf-8"></script>
	<script src="/tpl/v1/Public/js/main.js" type="text/javascript" charset="utf-8"></script>
	<script src="/tpl/v1/Public/js/placeholder.js" type="text/javascript" charset="utf-8"></script>
	<link rel="stylesheet" type="text/css" href="/tpl/v1/Public/css/index.css"/>
	<link rel="stylesheet" type="text/css" href="/tpl/v1/Public/css/order.css"/>
	<link rel="stylesheet" type="text/css" href="/tpl/v1/Public/css/main.css"/>
	<script type="text/javascript" src="/tpl/v1/Public/js/swfobject.js"></script>
    <script type="text/javascript" src="/tpl/v1/Public/js/fullAvatarEditor.js"></script>

</head>
<body class="theme">	
	<link href="/tpl/v1/Public/zp/css/common.css" rel="stylesheet" type="text/css" />
<link href="/tpl/v1/Public/zp/css/style.css" rel="stylesheet" type="text/css" />
<div class="header" id="header">

    <div class="top">
        <div class="top-left fl">
            <ul class="flul">
                <li><span>城市：</span><span id="city">深圳</span> <a href="http://localhost/zp//jobs/change_city.php">[切换城市]</a></li>
                <li><span>天气：</span> <span id="weather"> °C ~ °C</span></li>
            </ul>
        </div>
        <div class="top-right fr">
            <ul class="flul">

                <?php if($_SESSION['user']['id']): ?><li>欢迎您：<?php echo ($_SESSION['user']['user_login']); ?><a href="<?php echo U('User/my/index');?>">  您好</a></li>
                <li><a href="<?php echo U('user/my/index');?>">会员中心</a></li>
                <?php else: ?>
                <li><a href="<?php echo U('User/Login/index');?>">登陆</a></li>
                <li><a href="<?php echo U('User/register/index');?>">注册</a></li><?php endif; ?>
                <li><a href="<?php echo U('user/jobs/aejobs');?>">发布需求信息</a></li>
            </ul>
        </div>
        <div class="c"></div>
    </div>
    <div class="h-center">
        <div class="head-banner">
            <img src="/tpl/v1/Public/zp/images/top-banner.gif" alt=""/>
        </div>
        <div class="h-center-bottom">
            <div class="logo fl"><a href="http://localhost/zp/"><img src="/tpl/v1/Public/images/logo.png" alt="XG人才招聘系统" border="0" align="absmiddle" /></a></div>
            <div class="search fl">
                <form action="">
                    <input type="text" id="top-search" class="search-control" placeholder="请输入关键字查询" value=""/>
                    <button class="btn-search" id="search-btn">搜索</button>
                </form>
            </div>
            <div class="c"></div>
        </div>
        <!--导航start-->
        <div class="nav">
            <ul class="flul">

                <!--<div class="li"><a href="http://localhost/zp/index.php" target="_self" class="select">首  页</a></div>-->
                <li><a href="http://localhost/zp/index.php" target="_self">首  页</a><span class="shu"></span></li>
                <!--<div class="li"><a href="http://localhost/zp/jobs/" target="_blank" >招聘信息</a></div>-->
                <li><a href="http://localhost/zp/jobs/" target="_blank">招聘信息</a><span class="shu"></span></li>
                <!--<div class="li"><a href="http://localhost/zp/simple/simple-list.php" target="_self" >微商圈</a></div>-->
                <li><a href="http://localhost/zp/simple/simple-list.php" target="_self">微商圈</a><span class="shu"></span></li>
                <!--<div class="li"><a href="http://localhost/zp/resume/" target="_blank" >求职信息</a></div>-->
                <li><a href="http://localhost/zp/resume/" target="_blank">求职信息</a><span class="shu"></span></li>
                <!--<div class="li"><a href="http://localhost/zp/hrtools/index.php" target="_self" >HR工具箱</a></div>-->
                <li><a href="http://localhost/zp/hrtools/index.php" target="_self">HR工具箱</a><span class="shu"></span></li>
                <!--<div class="li"><a href="http://localhost/zp/company/index.php" target="_self" >黄页</a></div>-->
                <li><a href="http://localhost/zp/company/index.php" target="_self">黄页</a><span class="shu"></span></li>
                <!--<div class="li"><a href="http://localhost/zp/news/" target="_self" >新闻资讯</a></div>-->
                <li><a href="http://localhost/zp/news/" target="_self">新闻资讯</a><span class="shu"></span></li>
                <!--<div class="li"><a href="http://localhost/zp/user/login.php" target="_self" >会员中心</a></div>-->
                <li><a href="http://localhost/zp/user/login.php" target="_self">会员中心</a><span class="shu"></span></li>
            </ul>
        </div>
        <!--导航end-->
    </div>
    <script>

        $("#search-btn").click(function (e) {
            var keyword = $("#top-search").val();
            var url = "http://localhost/zp/"+"jobs/jobs-list.php?key="+keyword+"&trade=&jobcategory=&citycategory=&wage=&education=&experience=&nature=&settr=&sort=&page=1";
            location.href = url;

            return false;
        })
    </script>
</div>
	
	<div class="wrapper order-wrap">
		<div class="wrap">
			<div class="grid portrait-page">
				<div class="grid-l order-sidebar">
					<aside class="sidebar-top">
						<div class="sidebar-hd">
							<h4><span class="icon-user"></span>会员中心</h4>
						</div>
						<div class="sidebar-bd">
							<ul class="side-nav">
                                <li class="head">用户管理</li>
								<li class="active"><a href="<?php echo U('user/my/index');?>">我的账户</a></li>
                                <li><a href="<?php echo U('user/my/profile');?>">个人资料</a></li>
                                <li><a href="<?php echo U('user/my/change_pwd');?>">密码修改</a></li>
                                <li><a href="<?php echo U('user/my/user_verify');?>">安全认证</a></li>

                                <li class="head">应聘管理</li>
                                <li><a href="<?php echo U('user/apply/apply_list');?>">应聘历史</a></li>
                                <li><a href="<?php echo U('user/resume/index');?>">个人简历</a></li>

                                <li class="head">发布管理</li>

                                <li><a href="<?php echo U('user/jobs/index');?>">发布历史</a></li>
                                <li><a href="<?php echo U('user/jobs/index?status=2');?>">正在发布</a></li>
                                <li><a href="<?php echo U('user/resume/receive');?>">收到简历</a></li>

                                <li class="head">账户管理</li>

                                <li><a href="<?php echo U('order/index/index');?>">我的余额</a></li>
                                <li><a href="<?php echo U('order/index/index');?>">充值历史</a></li>
                                <li><a href="<?php echo U('order/index/index');?>">我要充值</a></li>

                                <li class="head">推广管理</li>

                                <li><a href="<?php echo U('order/index/index');?>">推广消费</a></li>
                                <li><a href="<?php echo U('order/index/index');?>">发布消费</a></li>
							</ul>
						</div>
					</aside>

				</div>
				<div class="grid-r">
					<div class="order-main">
						<div class="hd">
							<ul class="portrait-head">
								<li><a href="<?php echo U('user/my/profile');?>">基本資料</a></li>
								<li class="active">頭像照片</li>
							</ul>
						</div>
						<div class="bd">
							<div style="width:632px;margin: 0 auto;text-align:center">
								<div>
									<p id="swfContainer">
										本组件需要安装Flash Player后才可使用，请从<a href="http://www.adobe.com/go/getflashplayer">这里</a>下载安装。
									</p>
								</div>
								<!--<button type="button" id="upload" style="display:none;margin-top:8px;">swf外定义的上传按钮，点击可执行上传保存操作</button>-->
							</div>
						</div>						
					</div>					
				</div>
			</div>			
		</div>		
	</div>
<script type="text/javascript">
            swfobject.addDomLoadEvent(function () {
				//以下两行代码正式环境下请删除
				if(location.href.indexOf('http://') == -1) 
				alert('请于WEB服务器环境中查看、测试！\n\n既 http://*/simpleDemo.html\n\n而不是本地路径 file:///*/simpleDemo.html的方式');
				var swf = new fullAvatarEditor("/statics/fullAvatarEditor.swf", "expressInstall.swf", "swfContainer", {
					    id : 'swf',
						upload_url : '/user/profile/savePortrait',	//上传接口
						method : 'post',	//传递到上传接口中的查询参数的提交方式。更改该值时，请注意更改上传接口中的查询参数的接收方式
						src_upload : 1,		//是否上传原图片的选项，有以下值：0-不上传；1-上传；2-显示复选框由用户选择
						avatar_box_border_width : 0,
						avatar_sizes : '130*130|90*90|60*60',
						avatar_sizes_desc : '130*130像素|90*90像素|60*60像素'
					}, function (msg) {
						switch(msg.code)
						{
							case 1 : //alert("页面成功加载了组件！");break;
							case 2 : 
								//alert("已成功加载图片到编辑面板。");
								document.getElementById("upload").style.display = "inline";
								break;
							case 3 :
								if(msg.type == 0)
								{
									alert("摄像头已准备就绪且用户已允许使用。");
								}
								else if(msg.type == 1)
								{
									alert("摄像头已准备就绪但用户未允许使用！");
								}
								else
								{
									alert("摄像头被占用！");
								}
							break;
							case 5 : 
								if(msg.type == 0)
								{
									if(msg.content.sourceUrl)
									{
										//alert("原图已成功保存至服务器，url为：\n" +　msg.content.sourceUrl+"\n\n" + "头像已成功保存至服务器，url为：\n" + msg.content.avatarUrls.join("\n\n")+"\n\n传递的userid="+msg.content.userid+"&username="+msg.content.username);
										alert('头像保存成功');
									}
									else
									{
										//alert("头像已成功保存至服务器，url为：\n" + msg.content.avatarUrls.join("\n\n")+"\n\n传递的userid="+msg.content.userid+"&username="+msg.content.username);
										alert('头像保存成功');
									}
								}
							break;
						}
					}
				);
				document.getElementById("upload").onclick=function(){
					swf.call("upload");
				};
            });
			var _bdhmProtocol = (("https:" == document.location.protocol) ? " https://" : " http://");
			document.write(unescape("%3Cscript src='" + _bdhmProtocol + "hm.baidu.com/h.js%3F5f036dd99455cb8adc9de73e2f052f72' type='text/javascript'%3E%3C/script%3E"));
</script>	
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
</body>
</html>