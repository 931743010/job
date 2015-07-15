<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,Chrome=1" />
	<title>个人中心</title>
	
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
<body class="theme">	
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
			<div class="grid myhmv-grid  portrait-page">
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
						<ul class="user-info">
							<li class="info-line-1 cate-icon"></li>
							<li class="base-info">
								<a href="<?php echo ($user["avatar_origin"]); ?>" target='_blank'>
									<div class="user-pic">
										<div class="cate-icon msk">										
										</div>
										<img src="<?php echo ($user["avatar_large"]); ?>"/>										
									</div>
								</a>
								<div class="u-info">
									<div class="u-name">
										<?php echo ($user["user_login"]); ?>
									</div>
									<div class="u-safe">
										<p>
											账户安全
										</p>
										<div class="rank-box">
											<span class="safe-rank">
												<i class="rank-1"></i>
												<!--<i class="rank-2"></i>-->
												<!--<i class="rank-3"></i>-->
											</span>
											<span class="rank-txt">低</span>
										</div>
									</div>
								</div>
							</li>
							<li class="info-line-2 cate-icon"></li>
							<li class="user-couts">
								<ul>
									<li>
										<div class="counts-item">
											<i class="cate-icon count-01"></i>
											<p>余额<em><?php echo ((isset($account['money']) && ($account['money'] !== ""))?($account['money']):0); ?></em></p>
										</div>										
									</li>

									<li>
										<div class="counts-item">
											<i class="cate-icon count-04"></i>
											<p>职位<em><?php echo ((isset($jobCount) && ($jobCount !== ""))?($jobCount):0); ?></em></p>
										</div>										
									</li>
									<li>
										<div class="counts-item">
											<i class="cate-icon count-05"></i>
											<p>申请<em><?php echo ((isset($applyCount) && ($applyCount !== ""))?($applyCount):0); ?></em></p>
										</div>										
									</li>
									<li>
										<div class="counts-item">
											<i class="cate-icon count-06"></i>
											<p>简历<em><?php echo ((isset($resumeCount) && ($resumeCount !== ""))?($resumeCount):0); ?></em></p>
										</div>										
									</li>									
								</ul>
							</li>
							<li class="info-line-3 cate-icon"></li>
						</ul>
					</div>
                    <div class="order-main" id="user-index" style="display: none">
                        <hr/>
                        <div class="myaccount">
                            <p>注册日期：<span class="red"><?php echo ($_SESSION['user']['create_time']); ?></span></p>
                            <p>用户类型：<span class="red">
                                <?php if($_SESSION['user']['utype'] == 2): ?>企业
                                    <?php else: ?>
                                    个人<?php endif; ?>
                            </span></p>
                            <p>认证状态：<span class="red">
                                <?php if($account['audit'] == 0): ?>未验证
                                    <?php elseif($account['audit'] == 1): ?>
                                    验证中
                                    <?php elseif($account['audit'] == 2): ?>
                                    已验证
                                    <?php else: ?>
                                    验证不通过<?php endif; ?>

                            </span></p>
                            <p>发布权限：<span class="red">
                                <?php if($account['audit'] == 2): ?>有
                                    <?php else: ?>
                                    无<?php endif; ?>
                            </span></p>

                            <!--<p>我的余额：<span class="red"><?php echo ($account["money"]); ?></span></p>-->
                            <!--<p><a href="" class="btn btn-primary">现在充值</a></p>-->
                        </div>
                    </div>
				</div>
                <div class="grid-r">
                    <div class="order-main">
                        <div class="hd">
                            <ul class="portrait-head">
                                <li class="active">基本资料</li>
                                <li><a href="<?php echo U('user/my/portrait');?>">头像照片</a></li>
                            </ul>
                        </div>
                        <div class="bd">
                            <form action="">
                                <div class="grid">
                                    <!--<p class="title">&nbsp;&nbsp;用户名：<?php echo ($_SESSION['user']['user_realname']); ?></p>-->
                                </div>
                                <div class="portrait-gd dl-hori">
                                    <dl style="display: none">
                                        <dt>
                                            当前头像：
                                        </dt>
                                        <dd>
                                            <a class="pot-pic" target='_blank' href="<?php echo ($user["avatar_origin"]); ?>">
                                                <img src="<?php echo ($user["avatar"]); ?>"/>
                                            </a>
                                        </dd>
                                    </dl>

                                    <dl>
                                        <dt>
                                            *昵   称：
                                        </dt>
                                        <dd>
                                            <input type="text" name="user_nicename" id="" value="<?php echo ($user["user_nicename"]); ?>" />
                                        </dd>
                                    </dl>
                                    <dl>
                                        <dt>
                                            *用&nbsp;户&nbsp;&nbsp;名：
                                        </dt>
                                        <dd>
                                            <input type="text" name="user_realname" id="" value="<?php echo ($user["user_realname"]); ?>" />
                                        </dd>
                                    </dl>
                                    <dl>
                                        <dt>
                                            *性　　別：
                                        </dt>
                                        <dd>
                                            <div class="checkbox">
                                                <input type="radio" name='sex' <?php if($user['sex'] == 0): ?>checked<?php endif; ?> name="gender" id="" value="0" />&nbsp;男
                                            </div>
                                            <div class="checkbox">
                                                <input type="radio" name='sex' <?php if($user['sex'] == 1): ?>checked<?php endif; ?> name="gender" id="" value="1" />&nbsp;女
                                            </div>
                                        </dd>
                                    </dl>
                                    <dl style="display: none">
                                        <dt>
                                            *生　　日：
                                        </dt>
                                        <dd class="date">
                                            <select name="year">
                                                <option value="">年</option>
                                                <?php for( $i=1970;$i<2016;$i++ ){ if( $user['birth'][0] == $i ){ echo "<option selected value='".$i."'>$i</option>"; }else{ echo "<option value='".$i."'>$i</option>"; } } ?>
                                            </select>
                                            <select name="month">
                                                <option value="">月</option>
                                                <?php for( $i=0;$i<13;$i++ ){ if( $user['birth'][1] == $i ){ echo "<option selected value='".$i."'>$i</option>"; }else{ echo "<option value='".$i."'>$i</option>"; } } ?>
                                            </select>
                                            <select name="day">
                                                <option value="">日</option>
                                                <?php for( $i=0;$i<32;$i++ ){ if( $user['birth'][2] == $i ){ echo "<option selected value='".$i."'>$i</option>"; }else{ echo "<option value='".$i."'>$i</option>"; } } ?>
                                            </select>
                                            <span class="tips">（出生年月為保密）</span>
                                        </dd>
                                    </dl>
                                    <dl>
                                        <dt>
                                            *居&nbsp;住&nbsp;&nbsp;地：
                                        </dt>
                                        <dd>
                                            <input type="text" class="l-text" name="address" id="" value="<?php echo ($user["address"]); ?>" />
                                        </dd>
                                    </dl>
                                </div>
                                <div class="grid text-center">
                                    <button class="btn btn-lg submit">保　存</button>
                                </div>
                            </form>
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
        $("button.submit").click(function(data){
            $.ajax({
                url:"<?php echo U('user/profile/edit_post');?>",
                type:'post',
                data:{
                    user_nicename:$("input[name=user_nicename]").val(),
                    sex:$("input[name=sex]:checked").val(),
                    birthday:$("select[name=year] option:selected").val()+'-'+$("select[name=month] option:selected").val()+'-'+$("select[name=day] option:selected").val(),
                    address:$("input[name=address]").val(),
                    user_realname:$("input[name=user_realname]").val(),
                },
                success:function(data){
                    alert(data.info);
                }
            });
            return false;
        })
    </script>
</body>
</html>