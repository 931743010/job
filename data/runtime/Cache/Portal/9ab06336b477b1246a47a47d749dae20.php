<?php if (!defined('THINK_PATH')) exit();?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>招聘页列表</title>
    <meta name="description" content="">
    <meta name="keywords" content="">
    <meta http-equiv="X-UA-Compatible" content="IE=7">
    <link rel="shortcut icon" href="http://localhost/zp/favicon.ico" />
    <meta name="author" content="XG人才招聘系统" />
    <meta name="copyright" content="XG人才招聘系统" />

    <link href="/tpl/v1/Public/zp/css/index.css" rel="stylesheet" type="text/css" />
    <link href="/tpl/v1/Public/zp/css/jobs.css" rel="stylesheet" type="text/css" />

    <script src="/statics/js/Util.js"></script>

    <!-- Set render engine for 360 browser -->
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- HTML5 shim for IE8 support of HTML5 elements -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <![endif]-->


    <link href="/statics/simpleboot/font-awesome/4.2.0/css/font-awesome.min.css"  rel="stylesheet" type="text/css">
    <style>
        .length_3{width: 180px;}
        form .input-order{margin-bottom: 0px;padding:3px;width:40px;}
    </style>
    <!--[if IE 7]>
    <link rel="stylesheet" href="/statics/simpleboot/font-awesome/4.2.0/css/font-awesome-ie7.min.css">

    <![endif]-->

    <script type="text/javascript">
        //全局变量
        var GV = {
            DIMAUB: "/",
            JS_ROOT: "statics/js/",
            TOKEN: ""
        };
    </script>
    <!-- Le javascript
        ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="/statics/js/jquery.js"></script>
    <script src="/statics/js/wind.js"></script>
    <script src="/statics/simpleboot/bootstrap/js/bootstrap.min.js"></script>


</head>
<body>

<div class="wrap">
    <!--头部start-->
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
    <!--头部end-->
    <!--主体部分-->
    <div id="main" class="main">
        <div class="position">
            <span class="red">当前位置:</span>
            <a href="">首页</a>
            <span> >> </span>
            家政招聘
        </div>
        <div id="job">
            <div class="lists">
                <form action="" method="post" id="search-form">
                <div class="search">
                    <div class="search-item search-area">
                        <span class="title">区域：</span>
                        <ul class="flul">
                            <li data-id="0">不限</li>
                            <?php if(is_array($region)): $i = 0; $__LIST__ = $region;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><li data-id="<?php echo ($vo["id"]); ?>"><?php echo ($vo["name"]); ?></li><?php endforeach; endif; else: echo "" ;endif; ?>
                            <input type="hidden" name="area_id" id="area_id" />
                        </ul>
                        <div class="c"></div>
                    </div>
                    <div class="search-item search-date">
                        <span class="title">日期：</span>
                        <ul class="flul">
                            <li data-id="0">不限</li>
                            <li data-id="1">今天</li>
                            <li data-id="2">明天</li>
                            <li class="noactive">
                                <span>自定义：</span>
                                <input type="text" name="start-date" id="start-date" class="input length_2 J_date"/><span> 至 </span>
                                <input type="text" name="end-date" id="end-date" class="input length_2 J_date"/>
                            </li>
                            <input type="hidden" id="date_id" name="date_id" />
                            <input type="hidden" id="work_start_date" name="start_date" />
                            <input type="hidden" id="work_end_date" name="end_date"/>
                        </ul>
                    </div>
                    <div class="c"></div>
                    <div class="search-item search-cate">
                        <span class="title">兼职类型：</span>
                        <ul class="flul">
                            <li class="noactive">
                                <select name="cate-1" id="cate-1">
                                    <option value="0">不限</option>
                                    <?php if(is_array($cate)): $i = 0; $__LIST__ = $cate;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><option value="<?php echo ($vo["id"]); ?>"><?php echo ($vo["name"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                                </select>
                            </li>
                            <input type="hidden" id="cate_url" value="<?php echo U('jobs/get_son_cate');?>"/>
                            <li class="noactive">
                                <span class="title">兼职行业：</span>
                                <select name="cate-2" id="cate-2">
                                    <option value="0">不限</option>
                                </select>
                            </li>
                            <li class="noactive">
                                <span class="title">岗位名称：</span>
                                <select name="cate-3" id="cate-3">
                                    <option value="0">不限</option>
                                </select>
                            </li>
                            <input type="hidden" id="catid" name="catid"/>

                        </ul>
                    </div>
                    <div class="c"></div>
                    <div class="search-item search-pay">
                        <span class="title">兼职待遇：</span>
                        <ul class="flul">
                            <li data-id="0">
                                不限
                            </li>
                            <li data-id="1">15元以下/小时</li>
                            <li data-id="2">15-20元/小时</li>
                            <li data-id="3">20元以上/小时</li>
                            <input type="hidden" id="pay_id" name="pay_id"/>
                        </ul>
                    </div>
                    <div class="c"></div>
                    <div class="search-item search-time">
                        <span class="title">工作时长：</span>
                        <ul class="flul">
                            <li data-id="0">
                                不限
                            </li>
                            <li data-id="1">1小时以下</li>
                            <li data-id="2">1-2小时</li>
                            <li data-id="3">2-3小时</li>
                            <li data-id="4">3-4小时</li>
                            <li data-id="5">4小时以上</li>
                            <input type="hidden" name="time_id" id="time_id"/>
                        </ul>
                    </div>
                    <div class="c"></div>
                    <div class="search-btn">
                        <button id="search">搜索</button>
                    </div>
                </div>
                </form>
            </div>
        </div>



        <div class="job-list">
            <?php if(is_array($jobs)): $i = 0; $__LIST__ = $jobs;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?><a href="<?php echo U('Jobs/detail');?>&id=<?php echo ($v["id"]); ?>">
                <div class="item fl">
                    <div class="item-body">
                        <ul>
                            <li>岗位名称：<?php echo ($v["job_name"]); ?></li>
                            <li>工作内容：<?php echo ($v["job_desc"]); ?></li>
                            <li>工作时间：<?php echo (substr($v["work_start_date"],5,5)); ?></li>
                            <li>岗位类别：<?php echo ($v["catname"]); ?></li>
                        </ul>
                    </div>
                    <div class="item-bottom">
                        <ul class="flul">
                            <li>地点：<?php echo ($v["cityName"]); ?></li>
                            <li><?php echo ($v["work_pay"]); ?>元/小时</li>
                            <li>联系</li>
                            <div class="c"></div>
                        </ul>

                    </div>
                    <div class="c"></div>
                </div>
                </a><?php endforeach; endif; else: echo "" ;endif; ?>

            <div class="c"></div>
        </div>
    <div class="page">
        <?php echo ($show); ?>
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


</script>
<script src="/statics/js/common.js"></script>
<script src="/tpl/v1/Public/zp/js/job.js" type="text/javascript" language="javascript"></script>
</body>
</html>