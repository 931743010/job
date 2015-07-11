<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,Chrome=1" />
    <title>安全认证</title>

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
    <script src="/tpl/v1/Public/js/ajaxupload.js"></script>

</head>
<body class="theme foot-white-bg">
<link href="/tpl/v1/Public/zp/css/common.css" rel="stylesheet" type="text/css" />
<link href="/tpl/v1/Public/zp/css/style.css" rel="stylesheet" type="text/css" />
<div class="header" id="header">

    <div class="top">
        <div class="top-left fl">
            <ul class="flul">
                <li><span>城市：</span><span id="city"></span> <a href="<?php echo U('Portal/index/change_city');?>">[切换城市]</a></li>
                <li><span>天气：</span> <span id="weather"> </span></li>
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
                <li><a href="" target="_self">首  页</a><span class="shu"></span></li>
                <li><a href="<?php echo U('Portal/Jobs/lists');?>">所有工作</a></li>
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
                            安全认证
                        </div>
                    </div>
                    <div class="bd">
                        <div class="identify">
                            <!--身份认证-->


                            <div class="tips">
                                <span>认证状态：</span>
                                <?php if($account['audit'] == 2): ?><strong style="color:red">您已经认证通过</strong>
                                    <?php elseif($account['audit'] == 0): ?>
                                    <strong style="color: #c32627">您还未认证</strong>
                                    <?php elseif($account['audit'] == 1): ?>
                                    <strong style="color: #c32627">认证中</strong>

                                    <?php elseif($account['audit'] == 3): ?>
                                    <strong style="color: #c32627">未认证通过，请检查</strong><?php endif; ?>
                            </div>

                            <br />
                            <?php if($user['utype'] == 1): ?><div class="verify">
                                    <div class="identify_z f">
                                        <img src="/<?php echo ($account['identify_z']); ?>" alt=""/>
                                    </div>
                                    <div class="identify_f f">
                                        <img src="/<?php echo ($account['identify_f']); ?>" alt=""/>
                                    </div>
                                    <div class="c"></div>
                                    <?php if($account['audit'] != 2): ?><div class="verify-btn">
                                        <button class="btn btn-danger" id="upload_identify_z">重新上传正面</button>
                                        <button class="btn btn-danger" id="upload_identify_f">重新上传反面</button>
                                        </div><?php endif; ?>
                                </div><?php endif; ?>
                            <?php if($user['utype'] == 2): ?><div class="license">
                                    <img src="/<?php echo ($account["license"]); ?>" alt=""/>
                                </div>
                                <br />
                                <?php if($account['audit'] != 2): ?><button class="btn btn-danger" id="upload_license">重新上传营业执照</button><?php endif; endif; ?>

                            <?php if($user['utype'] == 0): ?><div class="form-group">
                                    <label class="help-block">选择您的类型(身份认证)</label>
                                    <input type="radio" name="choose-type" id="person" value="1"/><span class="col">个人</span>
                                    <input type="radio" name="choose-type" id="company" value="2"/><span class="col">企业</span>
                                </div>
                                <div class="user-type">
                                    <div class="person-type" style="display: none">
                                        <div class="identify_z">
                                            <img src="/tpl/v1/Public/images/page/slider_img.jpg" alt=""/>
                                        </div>
                                        <div class="identify_f">
                                            <img src="/tpl/v1/Public/images/page/slider_img.jpg" alt=""/>

                                        </div>
                                        <div class="c"></div>
                                        <button class="btn btn-danger" id="upload_identify_z">上传正面</button>
                                        <button class="btn btn-danger" id="upload_identify_f">上传反面</button>
                                    </div>
                                    <div class="company-type" style="display: none">
                                        <div class="license">

                                        </div>
                                        <button class="btn btn-danger" id="upload_license">上传营业执照</button>
                                    </div>
                                </div><?php endif; ?>
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