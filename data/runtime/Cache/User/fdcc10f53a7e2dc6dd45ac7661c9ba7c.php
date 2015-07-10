<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,Chrome=1" />
    <title>密码修改</title>

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

</head>
<body class="theme foot-white-bg">
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
<div class="grid address-page">
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
        <div class="tips">
            修改密码
        </div>
    </div>
    <div class="bd">
        <div class="margin-out">
            <div class="add-address data-item">
                <dl>
                    <dt>*原&nbsp;密&nbsp;&nbsp;码：</dt>
                    <dd>
                        <input type="password" name='oldpwd' placeholder="原密码" />
                    </dd>
                </dl>
                <dl>
                    <dt>*新&nbsp;密&nbsp;&nbsp;码：</dt>
                    <dd>
                        <input type="password" name='newpwd' placeholder="原密码" />
                    </dd>
                </dl>
                <dl>
                    <dt>*确&nbsp;认&nbsp;密&nbsp;&nbsp;码：</dt>
                    <dd>
                        <input type="password" name='renewpwd' placeholder="原密码" />
                    </dd>
                </dl>
                    <br />
                <div class="">
                    <button id='change_pwd' class="btn btn-lg">&nbsp;&nbsp;&nbsp;确&nbsp;&nbsp;&nbsp;定&nbsp;&nbsp;&nbsp;</button>
                </div>
            </div>

        </div>
    </div>
    <div class="bd">
    </div>
</div>
</div>
</div>
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
    $("#change_pwd").click(function(){

        var pwd_data = {
            oldpwd:$('input[name=oldpwd]').val(),
            newpwd:$('input[name=newpwd]').val(),
            renewpwd:$('input[name=renewpwd]').val()
        }
        //console.log(pwd_data);
        if(pwd_data.oldpwd=='' || pwd_data.oldpwd.length<6 || pwd_data.oldpwd.length>16){
            alert("旧密码长度应该在6到16之间11");
            return false;
        }
        if(pwd_data.newpwd.length<6 || pwd_data.newpwd.length>16){
            alert("新密码长度应该在6到16之间");
            return false;
        }
        if(pwd_data.newpwd != pwd_data.renewpwd){
            alert("两次密码不一致");
            return false;
        }


        $.ajax({
            type:'post',
            url:"<?php echo U('user/my/change_pwd');?>",
            dataType:"json",
            data: pwd_data,
            success:function(data){
                if(data.r==-1){
                    alert(data.msg);
                }else{
                    alert(data.msg);
                    window.location.href="<?php echo U('user/my/index');?>"
                }
            }
        });
    });


</script>
</body>
</html>