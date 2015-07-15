<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,Chrome=1" />
    <title>查看简历</title>

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

    <link rel="stylesheet" type="text/css" href="/tpl/v1/Public/js/skin/layer.css"/>
    <link rel="stylesheet" type="text/css" href="/tpl/v1/Public/js/skin/layer.ext.css"/>

    <script src="/tpl/v1/Public/js/layer/layer.js" type="text/javascript" charset="utf-8"></script>
    <style>
        .view-resume{padding: 20px ;}
        .view-resume p{height: 40px;border-bottom: 1px dashed #ccc;line-height: 40px;}
    </style>

</head>
<body class="theme foot-white-bg">
<link href="/tpl/v1/Public/zp/css/common.css" rel="stylesheet" type="text/css" />
<link href="/tpl/v1/Public/zp/css/style.css" rel="stylesheet" type="text/css" />
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
            <div class="publish fl">
                <a href="<?php echo U('user/jobs/aejobs');?>" class="publish">发布信息</a>
            </div>
            <div class="c"></div>
        </div>
        <!--导航start-->
        <div class="nav">
            <ul class="flul">
                <li><a href="<?php echo U('Portal/Index/index');?>" target="_self">首  页</a><span class="shu"></span></li>
                <li><a href="<?php echo U('Portal/Jobs/lists');?>">所有工作</a><span class="shu"></span></li>
                <li><a href="<?php echo U('Portal/Jobs/lists');?>">家政服务</a><span class="shu"></span></li>
                <li><a href="<?php echo U('Portal/Jobs/lists');?>">文化生活</a><span class="shu"></span></li>
                <li><a href="<?php echo U('Portal/Jobs/lists');?>">社区综合</a><span class="shu"></span></li>
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
								<li class="active"><a href="<?php echo U('user/my/index');?>">基本资料</a></li>
                                <!--<li><a href="<?php echo U('user/my/profile');?>">个人资料</a></li>-->
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

                                <li><a href="<?php echo U('user/my/cost_log');?>&type=0">推广消费</a></li>
                                <li><a href="<?php echo U('user/my/cost_log');?>&type=1">发布消费</a></li>
							</ul>
						</div>
					</aside>

				</div>
            <div class="grid-r">
                <div class="order-main">
                    <div class="hd">
                        <div class="tips">
                            <?php echo ($resume["title"]); ?>
                        </div>
                    </div>
                    <div class="bd">
                        <div class="margin-out">
                            <div class="view-resume">
                                <p class="resume-title"><span>简历名称：</span><?php echo ($resume["title"]); ?></p>
                                <p class="resume-name"><span>姓名：</span><?php echo ($resume["name"]); ?></p>
                                <p class="resume-gender"><span>性别：</span><?php if($resume.gender): ?>男
                                <?php else: ?>女<?php endif; ?></p>

                                <p class="resume-age"><span>年龄：</span><?php echo ($resume["age"]); ?></p>
                                <p class="resume-tel"><span>电话：</span><?php echo ($resume["tel"]); ?></p>
                                <p class="resume-degree"><span>学历：</span><?php echo ($resume["degree"]); ?></p>
                                <p class="resume-live_place"><span>现居住地：</span><?php echo ($resume["live_place"]); ?></p>
                                <p class="resume-email"><span>邮箱：</span><?php echo ((isset($resume["email"]) && ($resume["email"] !== ""))?($resume["email"]):'无'); ?></p>
                                <p class="resume-height"><span>身高：</span><?php echo ((isset($resume["height"]) && ($resume["height"] !== ""))?($resume["height"]):'无'); ?></p>
                                <p class="resume-refreshtime"><span>刷新时间：</span><?php echo (date("Y-m-d",$resume["refreshtime"])); ?></p>
                                <p class="resume-resume_content"><span>工作经验：</span>
                                    <br />
                                    </p>
                                <div style="margin-top: 10px;text-indent: 28px;">
                                    <?php echo ($resume["resume_content"]); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bd">
                        <?php echo ($show); ?>
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

    //编辑工作
    $(".editJob").click(function () {
        var rid = $(this).attr("data-id");
        var url = "<?php echo U('user/jobs/aejobs?jid=');?>"+rid;
        location.href = url;
    })


    //下架
    $(".offline_job").click(function(){
        $.ajax({
            type:"POST",
            url:"<?php echo U('user/jobs/offline_job');?>",
            dataType:'json',
            data:{id:$(this).attr('data-id')},
            success:function(data){
                alert(data.msg);
                if(data.r==0){
                    location.reload();
                }
            }

        });
    });

    $(".refreshJob").click(function(){
        $.ajax({
            type:"POST",
            url:"<?php echo U('user/jobs/refreshJob');?>",
            dataType:'json',
            data:{id:$(this).attr('data-id')},
            success:function(data){

                alert(data.msg);
                if(data.r==0)
                    location.reload();
            }

        });
    });

    //调用layer
    $(".recommendJob").click(function () {
        layer.open({
            type: 1,
            title:'置顶职位',
            shade:['0.1'],
            move:false,
            skin: 'layui-layer-rim',
            area: ['900px', '460px'],
            shadeClose: true, //点击遮罩关闭
            content: $('#jobPos')
        });
    });


</script>
</body>
</html>