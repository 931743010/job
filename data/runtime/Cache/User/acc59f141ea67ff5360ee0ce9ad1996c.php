<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,Chrome=1" />
    <title>地址</title>

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

    <script src="/tpl/v1/Public/js/Utils.js"></script>

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
                <?php if($edit): ?>修改简历
                    <?php else: ?>
                    新增简历<?php endif; ?>
            </div>
        </div>
        <div class="bd">
            <div class="margin-out">
                <div class="add-address data-item">
                    <dl>
                        <dt>*简历名称：</dt>
                        <dd>
                            <input type="text" name='title' placeholder="简历名称" value="<?php echo ($resume['title']); ?>" />
                        </dd>
                    </dl>
                    <dl>
                        <dt>*姓名：</dt>
                        <dd>
                            <input type="text" name='name' placeholder="姓名" value="<?php echo ($resume['name']); ?>"/>
                        </dd>
                    </dl>
                    <dl>
                        <dt>*性别：</dt>
                        <dd>

                            <input type="radio" name="gender" value="1" id="boy"/> 男
                            <input type="radio" name="gender" value="0" id="girl"/> 女
                            <input type="hidden" value="<?php echo ($resume["gender"]); ?>" id="sex" name="sex" />
                        </dd>
                    </dl>
                    <dl>
                        <dt>*现居住地：</dt>
                        <dd>
                            <div class="adress-box">
                                <input type="text" placeholder="现居住地" name="live_place" value="<?php echo ($resume['live_place']); ?>"/>
                            </div>
                        </dd>
                    </dl>
                    <dl>
                        <dt>*年龄：</dt>
                        <dd>
                            <input name='age' type="text" placeholder="年龄" value="<?php echo ($resume['age']); ?>" />
                        </dd>
                    </dl>
                    <dl>
                        <dt>*手机号码：</dt>
                        <dd>
                            <input type="text" name='tel' placeholder="常用手机号码" value="<?php echo ($resume['tel']); ?>" />

                        </dd>
                    </dl>
                    <dl>
                        <dt>邮箱地址：</dt>
                        <dd>
                            <input name='email' type="text" placeholder="常用邮箱" value="<?php echo ($resume['email']); ?>" />
                        </dd>
                    </dl>
                    <dl>
                        <dt>身高：</dt>
                        <dd>
                            <input name='height' type="text" placeholder="身高" value="<?php echo ($resume['height']); ?>" />
                        </dd>
                    </dl>
                    <dl>
                        <dt>学历：</dt>
                        <dd>
                            <select name="degree" id="degree">
                                <option value="小学">小学</option>
                                <option value="初中">初中</option>
                                <option value="高中/专科">高中/专科</option>
                                <option value="大专">大专</option>
                                <option value="本科">本科</option>
                                <option value="硕士">硕士</option>
                                <option value="博士">博士</option>
                                <option value="其他">其他</option>

                            </select>
                        </dd>
                    </dl>
                    <dl>
                        <dt>*工作经验：</dt>
                        <dd style="height: 250px;width: 600px;" class="f">
                            <textarea name="resume_content" placeholder="请简要描述，字数不少于20，不超过300" id="resume_content" style="width: 600px;height: 250px;"><?php echo ($resume['resume_content']); ?></textarea>
                        </dd>
                    </dl>
                    <?php if($edit): ?><input type="hidden" name="rid" id="rid" value="<?php echo ($resume['id']); ?>"/><?php endif; ?>
                    <div class="c"></div>
                    <div class="" style="margin-top: 25px;margin-left: 130px">
                        <button id='aeresume' class="btn btn-lg">&nbsp;&nbsp;&nbsp;确&nbsp;&nbsp;&nbsp;定&nbsp;&nbsp;&nbsp;</button>
                    </div>
                </div>


            </div>
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

    <?php if($edit): ?>var gender = "<?php echo ($resume['gender']); ?>";
//    $("input[name=gender]").val(gender);
//     $("input[name=gender]").val(gender);
    if(gender==1){
        $("#boy").attr('checked','checked');
    }else{
        $("#girl").attr('checked','checked');

    }
    var degree = "<?php echo ($resume['degree']); ?>";
    $("select[name=degree]").val(degree);<?php endif; ?>

    $("#boy").click(function(){
        $("#sex").val(1);
    });
    $("#girl").click(function(){
        $("#sex").val(0);
    });

    $("#aeresume").click(function(){

        var resume = {
            title: $('input[name=title]').val(),
            name:$("input[name=name]").val(),
            gender:$("input[name=sex]").val(),
            live_place:$("input[name=live_place]").val(),
            age:$("input[name=age]").val(),
            tel:$("input[name=tel]").val(),
            email:$("input[name=email]").val(),
            height:$("input[name=height]").val(),
            degree:$("select[name=degree]").val(),
            resume_content:$("textarea[name=resume_content]").val()
        };

        if(resume.title=='' || resume.title.length>60){
            alert("简历名称不能为空或者超过60个字符");
            return false;
        }
        if(resume.name=='' || resume.name.length>20){
            alert("姓名不能为空或者超过20个字符");
            return false;
        }
//        alert(resume.gender);return false;
        if(resume.gender!=0 && resume.gender!=1){
            alert("请选择性别");
            return false;
        }
        if(resume.live_place==''){
            alert("居住地不能为空");
            return false;
        }
        if(resume.age =='' && isNaN(resume.age) && resume.age<=0){
            alert("年龄不能为空，并且必须是正整数");
            return false;
        }
        if(!Util.isPhoneNum(resume.tel)){
            alert("手机号格式有误");
            return false;
        }
        if(resume.email!=''){
            if(!Util.isEmail(resume.email)){
                alert("邮箱格式有误");
                return false;
            }
        }
        if(!Util.isNum(resume.height) && resume.height!=''){
            alert('身高只能是数字');
            return false;
        }
        if(resume.resume_content=='' && resume.resume_content.length<10 && resume.resume_content.length>300){
            alert("工作经历必须填写，并且字数要在10到300个之间");
            return false;
        }
        var rid = $("#rid").val();
        if(rid){
            resume.rid = rid;
        }
        $.ajax({
            type:'post',
            url:"<?php echo U('user/resume/aeresume');?>",
            dataType:'json',
            data: resume,
            success:function(data){
                alert(data.msg);
                if(data.r==0){
                    location.href="<?php echo U('user/resume/index');?>";
                }
            }
        })
    });




</script>
</body>
</html>