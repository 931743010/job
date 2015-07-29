<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,Chrome=1" />
    <title>发布历史</title>

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
    <link rel="stylesheet" type="text/css" href="/tpl/v1/Public/css/index.css"/>
    <link rel="stylesheet" type="text/css" href="/tpl/v1/Public/css/order.css"/>
    <link rel="stylesheet" type="text/css" href="/tpl/v1/Public/css/main.css"/>

    <link rel="stylesheet" type="text/css" href="/tpl/v1/Public/js/layer/skin/layer.css"/>
    <link rel="stylesheet" type="text/css" href="/tpl/v1/Public/js/layer/skin/layer.ext.css"/>

    <script src="/tpl/v1/Public/js/layer/layer.js" type="text/javascript" charset="utf-8"></script>
    <style>
        #jobPos {padding: 20px;}
        #jobPos .desc{}
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
            <div class="logo fl"><a href="<?php echo U('Portal/Index/index');?>"><img src="/tpl/v1/Public/images/logo.png" alt="XG人才招聘系统" border="0" align="absmiddle" /></a></div>
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

                                <li><a href="<?php echo U('user/account/index');?>">我的余额</a></li>
                                <li><a href="<?php echo U('user/account/pay_log');?>">充值历史</a></li>
                                <li><a href="<?php echo U('user/account/pay');?>">我要充值</a></li>

                                <li class="head">推广管理</li>

                                <li><a href="<?php echo U('user/my/cost_log');?>&type=0">推广消费</a></li>
                                <li><a href="<?php echo U('user/my/cost_log');?>&type=1">发布消费</a></li>

							</ul>

						</div>
                        <div class="rollbg"></div>
					</aside>

				</div>
            <div class="grid-r">
                <div class="order-main">
                    <div class="hd">
                        <div class="tips">
                            发布历史-- <a href="<?php echo U('user/jobs/aejobs');?>" onclick="check_auth();return false" style="color: mediumvioletred">发布职位</a>
                        </div>
                    </div>
                    <div class="bd">
                        <div class="margin-out">

                            <table class="f-table">
                                <thead>
                                <tr>
                                    <td width="14%">发布日期</td>
                                    <td width="10%">岗位名称</td>
                                    <td>收到的简历数</td>
                                    <td>刷新时间</td>
                                    <td width="16%">状态</td>
                                    <td width="16%">操作</td>

                                </tr>
                                </thead>
                                <tbody class="dot-line">
                                <tr>
                                    <td colspan="6"></td>
                                </tr>
                                <tr>
                                    <td colspan="6"></td>
                                </tr>
                                </tbody>
                                <?php if(is_array($jobs)): $i = 0; $__LIST__ = $jobs;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tbody>
                                    <tr>
                                        <td><?php echo (date("Y-m-d H:i:s",$vo["addtime"])); ?></td>
                                        <td>
                                            <p><?php echo ($vo["job_name"]); ?></p>
                                        </td>
                                        <td class="text-center">
                                            <a href="<?php echo U('resume/receive_group');?>&job_id=<?php echo ($vo["id"]); ?>" title="点击查看"><?php echo ($vo["rcount"]); ?></a>
                                        </td>
                                        <td>
                                            <?php echo (date("Y-m-d H:i:s",$vo["refreshtime"])); ?>
                                        </td>
                                        <td>
                                        <?php if($vo['status'] == 0 ): ?>待审核

                                            <?php elseif($vo['status'] == 2): ?>
                                            显示中
                                            <?php elseif($vo['status'] == 3): ?>
                                            审核不通过
                                            <?php elseif($vo['status'] == 4): ?>
                                            已下架<?php endif; ?>
                                        </td>
                                        <td>
                                            <a data-id='<?php echo ($vo["id"]); ?>'  href="javascript:void(0)" class="viewJob">查看</a>
                                            |
                                            <a data-id='<?php echo ($vo["id"]); ?>'  href="javascript:void(0)" class="editJob">编辑</a>
                                            |
                                            <?php if($vo['status'] == 2 ): ?><a data-id='<?php echo ($vo["id"]); ?>' class='offline_job' href="javascript:void(0)">下架</a>
                                            |
                                            <a class='refreshJob' data-id='<?php echo ($vo["id"]); ?>' href="javascript:void(0)">刷新</a>
                                            |

                                            <a class='recommendJob' data-id='<?php echo ($vo["id"]); ?>' href="<?php echo U('jobs/job_pos');?>&id=<?php echo ($vo["id"]); ?>&type=recommend">置顶</a>
                                            |
                                            <a class='highlightJob' data-id='<?php echo ($vo["id"]); ?>' href="<?php echo U('jobs/job_pos');?>&id=<?php echo ($vo["id"]); ?>&type=highlight">高亮</a>
                                            |
                                            <a class='emergencyJob' data-id='<?php echo ($vo["id"]); ?>' href="<?php echo U('jobs/job_pos');?>&id=<?php echo ($vo["id"]); ?>&type=emergency">加急</a><?php endif; ?>
                                        </td>

                                    </tr>
                                    </tbody>
                                    <tbody class="dot-line">
                                    <tr>
                                        <td colspan="6"></td>
                                    </tr>
                                    <tr>
                                        <td colspan="6"></td>
                                    </tr>
                                    </tbody><?php endforeach; endif; else: echo "" ;endif; ?>
                            </table>
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
                <p>版权所有: <a href=""><?php echo ($site_copyright); ?>    </a></p>
                <p><a href="http://www.miitbeian.gov.cn/" target="_blank"><?php echo ($site_icp); ?></a></p>
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
                layer.alert(data.msg,function(){
                    location.reload();
                });
                
            }

        });
    });

    $(".refreshJob").click(function(){
        $.ajax({
            type:"POST",
            url:"<?php echo U('user/jobs/refresh_job');?>",
            dataType:'json',
            data:{id:$(this).attr('data-id')},
            success:function(data){

                layer.alert(data.msg,function(){
                    location.reload();
                });
            }

        });
    });
    function check_auth(){
        var html =
                '<div class="no-verify" style="padding: 20px"><p class="title1">对不起您的身份还未认证，请先认证</p><p class="verifyss"><a href="<?php echo U('User/my/user_verify');?>" class="red">现在去认证</a></p></div>';

        $.ajax({
            url:"<?php echo U('jobs/publish_auth');?>",
            dataType:'text',
            type:"POST",
            data:{},
            success: function (data) {
                if(data==1){
                    location.href="<?php echo U('Jobs/aejobs');?>"
                }else{
                    layer.open({
                        type: 1,
                        title: '认证身份',
                        maxmin: true,
                        shadeClose: true, //点击遮罩关闭层
                        area : ['330px' , '140px'],
                        content: html
                });
                }
            }

        });
        return false;
    }

    $(".recommendJob").click(function(){
        layer.alert('暂不提供此项服务，具体时间请留言网站公告');
        return false;
    });
    $(".highlightJob").click(function(){
        layer.alert('暂不提供此项服务，具体时间请留言网站公告');
        return false;
    });
    $(".emergencyJob").click(function(){
        layer.alert('暂不提供此项服务，具体时间请留言网站公告');
        return false;
    });



</script>
</body>
</html>