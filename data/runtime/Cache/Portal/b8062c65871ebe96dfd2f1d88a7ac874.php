<?php if (!defined('THINK_PATH')) exit();?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>招聘系统</title>
    <meta name="description" content="">
    <meta name="keywords" content="">
    <meta http-equiv="X-UA-Compatible" content="IE=7">
    <link rel="shortcut icon" href="http://localhost/zp/favicon.ico" />
    <meta name="author" content="XG人才招聘系统" />
    <meta name="copyright" content="XG人才招聘系统" />

    <link href="/tpl/v1/Public/zp/css/index.css" rel="stylesheet" type="text/css" />
    <script src="/statics/js/cache/region.js"></script>
    <script src="/tpl/v1/Public/js/jquery-1.11.1.min.js" type="text/javascript" language="javascript"></script>
</head>
<body>
<div class="wrap">
    <!--头部start-->
    <link href="/tpl/v1/Public/zp/css/common.css" rel="stylesheet" type="text/css" />
<link href="/tpl/v1/Public/zp/css/style.css" rel="stylesheet" type="text/css" />
<div class="header" id="header">

    <div class="top">
        <div style="width: 980px;margin: 0 auto;">
            <div class="cl816" style="width: 824px;">
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
                        <li><a href="<?php echo U('user/jobs/aejobs');?>">发布需求信息</a></li>
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
            <div class="c"></div>
        </div>
        <!--导航start-->
        <div class="nav">
            <ul class="flul">
                <li><a href="<?php echo U('Portal/Index/index');?>" target="_self">首  页</a><span class="shu"></span></li>
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
    <!--头部end-->
    <!--主体部分-->
    <div id="main" class="main">
        <div class="position">
            <span class="red">当前位置:</span>
            <a href="">首页</a>
            <span> >> </span>
            更换城市
        </div>
        <div class="change-city">
            <div class="place">
                <span class="choose">请选择：</span>
                <div class="content">
                    <div class="province">
                        <strong>广东省</strong>
                        <ul class="city flul">
                            <li><a href="">深圳</a></li>
                            <li><a href="">广州</a></li>
                            <li><a href="">儿子</a></li>
                            <li><a href="">深圳</a></li>
                            <li><a href="">深圳</a></li>
                            <li><a href="">深圳</a></li>
                            <li><a href="">深圳</a></li>
                            <li><a href="">深圳</a></li>
                        </ul>
                    </div>
                    <div class="c"></div>
                    <div class="province">
                        <strong>广东省</strong>
                        <ul class="city flul">
                            <li><a href="">深圳</a></li>
                            <li><a href="">广州</a></li>
                            <li><a href="">儿子</a></li>
                            <li><a href="">深圳</a></li>
                            <li><a href="">深圳</a></li>
                            <li><a href="">深圳</a></li>
                            <li><a href="">深圳</a></li>
                            <li><a href="">深圳</a></li>
                        </ul>
                    </div>
                    <div class="c"></div>
                </div>
            </div>
        </div>
    </div>
    <!--主体部分end-->

    <!--底部start-->
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
    <!--底部end-->
</div>
<script>
    console.log(_city);
    var html = '';
    for(var i in _province){
        var province = _province[i]['name'];
        html+='<div class="province"><strong>'+_province[i]['name']+'</strong><ul class="city flul">';
        for(var j in _city){
            if(_city[j]['pid'] == _province[i]['id']) {
                html += '<li><a href="<?php echo U('Index/change_city');?>&id=' + _city[j]['id'] + '">' + _city[j]['name'] + '</a></li>';
            }
        }
        html+='</ul></div><div class="c"></div>';
    }
    $(".content").html(html);


</script>
</body>
</html>