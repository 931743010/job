<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,Chrome=1" />
    <title>个人认证</title>

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
    <link rel="stylesheet" type="text/css" href="/tpl/v1/Public/zp/css/user.css"/>
    <script src="/tpl/v1/Public/js/ajaxupload.js"></script>
    <script src="/statics/js/Util.js"></script>
    <script type="text/javascript" src="/tpl/v1/Public/js/swfobject.js"></script>
    <script type="text/javascript" src="/tpl/v1/Public/js/fullAvatarEditor.js"></script>

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

                                <li><a href="<?php echo U('order/index/index');?>">我的余额</a></li>
                                <li><a href="<?php echo U('order/index/index');?>">充值历史</a></li>
                                <li><a href="<?php echo U('order/index/index');?>">我要充值</a></li>

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
                            <span>安全认证</span>
                        </div>
                    </div>
                    <div class="bd verify">
                        <div class="verify_head">
                            <ul class="flul">
                                <li><a href="<?php echo U('my/company_verify');?>">企业认证</a></li>
                                <span class="fl">|</span>
                                <li><a href="<?php echo U('my/person_verify');?>">个人认证</a></li>
                            </ul>
                            <div class="c"></div>
                        </div>
                        <div class="line" style="border-bottom: 1px solid #362e2b"></div>
                        <div class="description">
                            <p class="promise">
                                <span class="danger-icon"></span>
                                <span class="danger-word">郑重承诺：</span>
                            </p>
                            <p class="desc">
                                1、上传的身份证图片自动添加合成用途说明水印，仅用于人工在线平台实名认证，无法用于其他途径。
                            </p>
                            <p class="desc">
                                2、所有信息加密传输和存储，严格保护用户隐私安全。
                            </p>
                        </div>
                        <div class="audit">
                            <p>
                                <span class="audit">
                                    认证状态：
                                </span>
                                <span>
                                    <?php if($account['audit'] == 1): ?>等待管理员审核
                                        <?php elseif($account['audit'] == 2): ?>
                                        审核通过
                                        <?php elseif($account['audit'] == 3): ?>
                                        审核不通过<?php endif; ?>
                                </span>
                            </p>
                        </div>
                        <br />
                        <div class="verify-info">
                            <form action="<?php echo U('my/person_post');?>" method="post" enctype="multipart/form-data" onsubmit="return check_person();">
                                <div class="controls">
                                    <label>身份证姓名：</label>
                                    <input type="text" name="person_name" class="input" placeholder="请输入您的真实姓名" value="<?php echo ($account["person_name"]); ?>"/>
                                </div>
                                <br/>
                                <div class="controls">
                                    <label>身份证号码：</label>
                                    <input type="text" name="person_id" class="input" placeholder="请输入您的真实身份证号码" value="<?php echo ($account["person_id"]); ?>"/>
                                </div>

                                <div class="yaoqiu">
                                    <p class="text-center" style="text-align: center">
                                        图片要求：支持jpg、bmp、gif、png格式的图片，图片清晰且小于1024kb。
                                    </p>
                                </div>
                                <div class="box">
                                    <div class="item identify-upload fl">
                                        <div class="identify-info" style="margin-top: 20px;">
                                            <label >正面</label>
                                            <input type="file" name="identify_z" id="identify_z" style="display: none"/>
                                            <div class="identify_z" onclick="$('#identify_z').click()"></div>

                                        </div>
                                        <div class="identify-info" style="margin-top: 38px;">
                                            <label >反面</label>
                                            <input type="file" name="identify_f" id="identify_f" style="display: none"/>
                                            <div class="identify_f" onclick="$('#identify_f').click()"></div>
                                        </div>
                                    </div>
                                    <div class="item jiaotou fl">
                                        <div class="jiantou-icon"></div>
                                    </div>
                                    <div class="item preview fl">
                                        <div class="identify-info">
                                            <?php if($account['identify_z'] != ''): ?><img src="<?php echo ($account["identify_z"]); ?>" id="pre_z"/>
                                                <?php else: ?>
                                                <img src="/tpl/v1/Public/zp/images/preimg_09.png" id="pre_z"/><?php endif; ?>
                                        </div>
                                        <div class="identify-info">
                                            <?php if($account['identify_f'] != ''): ?><img src="<?php echo ($account["identify_f"]); ?>" id="pre_f"/>
                                                <?php else: ?>
                                                <img src="/tpl/v1/Public/zp/images/preimg_09.png" id="pre_f"/><?php endif; ?>

                                        </div>
                                    </div>
                                    <div class="c"></div>

                                    <div class="submit" style="text-align: center">

                                        <?php if($account['audit'] == 2): ?><span class="red">您已通过验证</span>
                                            <?php else: ?>
                                        <input type="submit" class="btn btn-submit" value="上传"/><?php endif; ?>
                                    </div>
                                </div>


                            </form>
                        </div>


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
                <p>版权所有: <a href="">© 人工在线</a></p>
                <p><a href="http://www.miitbeian.gov.cn/" target="_blank">粤ICP备15056824</a></p>
            </div>
        </div>
    </div>
<script>

Util.previewImg('identify_z','pre_z',false,300,300);
Util.previewImg('identify_f','pre_f',false,300,300);

    function check_person(){

        var person_name = $("input[name=person_name]").val();
        var person_id = $("input[name=person_id]").val();
        var id_z = $("#pre_z").attr('src');
        var id_f = $("#pre_f").attr('src');
        if(person_name==''){
            alert("身份证姓名必须填写");
            return false;
        }
        if(person_id.length!=16 && person_id.length!=18){
            alert("身份证必须是16位或者18位");
            return false;
        }
        if(id_z=='/tpl/v1/Public/zp/images/preimg_09.png'){
            alert("请上传正面");
            return false;
        }
        if(id_f=='/tpl/v1/Public/zp/images/preimg_09.png'){
            alert("请上传反面");
            return false;
        }
        return true;
    }

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
    $("#person").click(function () {
        $(".user-type .company-type").hide();
        $(".user-type .person-type").show();
    });
    $("#company").click(function () {
        $(".user-type .person-type").hide();
        $(".user-type .company-type").show();
    });
    //上传图片
    var identify_z = $('#upload_identify_z'), interval;
    var identify_f = $('#upload_identify_f');
    var license = $('#upload_license');
    var confirmdiv = $('.comfirmdiv').eq(0);
    var fileType = "pic",fileNum = "one";
    new AjaxUpload(identify_z, {
        action: "<?php echo U('user/my/upload_identify?act=z');?>",
        name: 'file',
        onSubmit: function (file, ext) {
            if (fileType == "pic") {
                if (ext && /^(jpg|png|jpeg|gif|JPG)$/.test(ext)) {
                    this.setData({
                        'info': '文件类型为图片'
                    });
                } else {
                    alert('文件格式错误，请上传格式为.png .jpg .jpeg 的图片');
                    return false;
                }
            }

            confirmdiv.text('文件上传中');

            if (fileNum == 'one')
                this.disable();

            interval = window.setInterval(function () {
                var text = confirmdiv.text();
                if (text.length < 14) {
                    confirmdiv.text(text + '.');
                } else {
                    confirmdiv.text('文件上传中');
                }
            }, 200);
        },
        onComplete: function (file, response) {
            response = $.parseJSON(response);
            if(response.r == 0){
                var imgstr = "<img src='"+response.msg+"' alt='身份证正面'>";
                $(".person-type .identify_z").html("").append(imgstr);
                $('#upload_identify_z').html("上传成功");
                $('#upload_identify_z').remove();
            }else{
                alert(response.msg);
            }

        }
    });
    new AjaxUpload(identify_f, {
        action: "<?php echo U('user/my/upload_identify?act=f');?>",
        name: 'file',
        onSubmit: function (file, ext) {
            if (fileType == "pic") {
                if (ext && /^(jpg|png|jpeg|gif|JPG)$/.test(ext)) {
                    this.setData({
                        'info': '文件类型为图片'
                    });
                } else {
                    alert('文件格式错误，请上传格式为.png .jpg .jpeg 的图片');
                    return false;
                }
            }

            confirmdiv.text('文件上传中');

            if (fileNum == 'one')
                this.disable();

            interval = window.setInterval(function () {
                var text = confirmdiv.text();
                if (text.length < 14) {
                    confirmdiv.text(text + '.');
                } else {
                    confirmdiv.text('文件上传中');
                }
            }, 200);
        },
        onComplete: function (file, response) {
            response = $.parseJSON(response);
            if(response.r == 0){
                var imgstr = "<img src='"+response.msg+"' alt='身份证反面'>";
                $(".person-type .identify_f").html("").append(imgstr);
                $('#upload_identify_f').html("上传成功");
                $('#upload_identify_f').remove();
            }else{
                alert(response.msg);
            }

        }
    });
    new AjaxUpload(license, {
        action: "<?php echo U('user/my/upload_identify?act=l');?>",
        name: 'file',
        onSubmit: function (file, ext) {
            if (fileType == "pic") {
                if (ext && /^(jpg|png|jpeg|gif|JPG)$/.test(ext)) {
                    this.setData({
                        'info': '文件类型为图片'
                    });
                } else {
                    alert('文件格式错误，请上传格式为.png .jpg .jpeg 的图片');
                    return false;
                }
            }

            confirmdiv.text('文件上传中');

            if (fileNum == 'one')
                this.disable();

            interval = window.setInterval(function () {
                var text = confirmdiv.text();
                if (text.length < 14) {
                    confirmdiv.text(text + '.');
                } else {
                    confirmdiv.text('文件上传中');
                }
            }, 200);
        },
        onComplete: function (file, response) {
            if(response.r == 0){
                $(".license").eq(0).html('<img src="' + response.msg +'"');
                $('#upload_license').html("上传成功");
                $('#upload_license').remove();
            }else{
                alert(response.msg);
            }

        }
    });

</script>

</body>
</html>