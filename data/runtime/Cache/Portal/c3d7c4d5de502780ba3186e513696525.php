<?php if (!defined('THINK_PATH')) exit();?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>招聘页详情</title>
    <meta name="description" content="">
    <meta name="keywords" content="">
    <meta http-equiv="X-UA-Compatible" content="IE=7">
    <link rel="shortcut icon" href="http://localhost/zp/favicon.ico" />
    <meta name="author" content="XG人才招聘系统" />
    <meta name="copyright" content="XG人才招聘系统" />

    <link href="/tpl/v1/Public/zp/css/index.css" rel="stylesheet" type="text/css" />
    <link href="/tpl/v1/Public/zp/css/jobs.css" rel="stylesheet" type="text/css" />
    <script src="/tpl/v1/Public/js/jquery-1.11.1.min.js" type="text/javascript" language="javascript"></script>
    <script src="/tpl/v1/Public/js/layer/layer.js" type="text/javascript" language="javascript"></script>
    <script type="text/javascript" src="http://api.map.baidu.com/api?v=2.0&ak=pOjKwgwxn0nlutaU2ppwIk8p"></script>
</head>
<body>
<div class="wrap">
    <!--头部start-->
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
    <!--头部end-->
    <!--主体部分-->
    <div id="main" class="main">
        <div class="position">
            <span class="red">当前位置:</span>
            <?php $id = intval($_GET['id']); $catid = $job['catid']; if($catid==0){ echo '<a href="/">首页</a><span> &gt;&gt; </span>'.$job['catname'].'<span> &gt;&gt; </span>'.$job['job_name']; }else{ echo your_location($catid,$id); } ?>
        </div>
        <div id="job" style="padding: 10px;margin-top: 20px;border:1px solid #ccc">
            <div class="detail">
                <div class="job-head">
                    <div class="user fl">
                        <div class="user-avatar fl">
                            <div class="user-avatar-title">用户头像</div>
                            <div class="avatar-img">
                                <?php if($user["avatar_small"] != ''): ?><img src="<?php echo ($user["avatar_small"]); ?>" alt="" style="border-radius:50%"/>
                                    <?php else: ?>
                                    <div class="cccbg" style="width: 115px;height: 115px;background: #ccc;border-radius:50%">

                                    </div><?php endif; ?>

                            </div>
                        </div>
                        <div class="user-info fl">
                            <div class="user-item">
                                <span class="u-title">用户名：</span><span class="u-val red">
                                <?php if($user["user_realname"] != ''): echo ($user["user_realname"]); ?>
                                    <?php else: ?>
                                    <?php echo ($user["user_nicename"]); endif; ?>
                                </span>
                            </div>
                            <div class="user-item">
                                <span class="u-title">注册日期：</span><span class="u-val red"><?php echo (substr($user["create_time"],0,10)); ?></span>
                             </div>
                            <div class="user-item">
                                <span class="u-title">安全认证：</span><span class="u-val red">已认证</span>
                            </div>
                            <div class="user-item">
                                <span class="u-title">信息诚信协议签订状态：</span><span class="u-val red">已签</span>
                            </div>
                        </div>
                        
                        <div class="c"></div>
                    </div>
                    <div class="job-desc fl">
                        <div class="blank">

                        </div>
                        <div class="apply">
                            <button id="apply" class="apply-btn">立即应聘</button>
                        </div>
                        <div class="publish-info">
                            <span class="publish-item red">
                                发布时间：<?php echo (date("Y-m-d",$job["addtime"])); ?>
                            </span>
                           <span class="publish-item red">
                                浏览量：<?php echo ($job["click"]); ?> 次
                            </span>
                            <span class="publish-item red">
                                当前应聘人数：<?php echo ($applyNum); ?> 人
                            </span>
                        </div>
                    </div>
                    <div class="c"></div>
                </div>

                <!--工作内容start-->
                <div class="job-content">
                    <div class="job_name">
                        <h2><?php echo ($job["job_name"]); ?></h2>
                    </div>
                    <div class="cate">
                         <div class="cate-item">
                             <span>岗位类别：
                             <?php if($job.catid): echo ($catname); ?>
                                 <?php else: ?>
                                 <?php echo ($job["catname"]); endif; ?>
                             </span>
                         </div>
                        <div class="cate-item">
                            <span>岗位性质：<?php echo ($nature_name); ?></span>
                        </div>
                        <div class="cate-item">
                            <span>工作内容：<?php echo ($job["job_desc"]); ?></span>
                        </div>
                        <div class="cate-item">
                            <span>招聘人数：<?php echo ($job["person_num"]); ?>人</span>
                        </div>
                    </div>
                    <div class="c"></div>
                    <div class="work-need">
                        <div class="work-need-title">
                            详细工作要求:
                        </div>
                        <div class="work-need-info">
                           <?php echo ($job["job_content"]); ?>
                        </div>
                    </div>

                    <div class="cate">
                        <div class="cate-item">
                            <span>工作日期：<?php echo (substr($job["work_start_date"],0,10)); ?> 至 <?php echo (substr($job["work_end_date"],0,10)); ?> </span>
                        </div>
                        <div class="cate-item">
                            <span>具体工作时间：<?php echo ($job["work_start_time"]); ?> 点 - <?php echo ($job["work_end_time"]); ?> 点</span>
                        </div>
                        <div class="cate-item">
                            <span>工作时长：<?php echo ($job["work_total_date"]); ?>小时</span>
                        </div>
                        <div class="cate-item">
                            <span>工作待遇：<?php echo ($job["work_pay"]); ?>元/小时</span>
                        </div>

                        <div class="cate-item">
                            <span>结算方式：
                            <?php if($job.pay_method): ?>打卡
                                <?php else: ?>
                                现金<?php endif; ?>
                            </span>
                        </div>
                        <div class="cate-item">
                            <span>结算日期：
                            <?php if($job.pay_date): ?>日结
                                <?php else: ?>
                                定期结<?php endif; ?>
                            </span>
                        </div>
                    </div>
                    <div class="c"></div>
                </div>
                <!--工作内容end-->
                <!--地图开始-->
                <div class="map" id='job-map'>
                    <div class="baiduMap" id="allmap">

                    </div>
                    <div id="r-result"></div>
                    <div class="c"></div>
                     <div class="mylocation route-search-box" id="route_search_box">

                        <div id="route_header">        
                            <ul class="route-ntab walk cf" id="route_tab">   <span class="arrow-wrap"></span>
                                <li class="tab-item bus-tab tab-active" data-index="0"><a class="border-line"><i></i><span>公交</span></a></li>
                                <li class="tab-item drive-tab" data-index="1"><a class="border-line"><i></i><span>驾车</span></a></li>            
                                <li class="tab-item walk-tab" data-index="2"><a><i></i><span>步行</span></a></li>
                            </ul>
                        </div>
                        <div id="walk_search_box" style="display: block;">

                            <form class="route-search-form" name="walk_form" data-index="3" onsubmit="return false">
                            <div class="route-switch" title="切换步行起终点"><a></a></div>
                            <div class="route-input-box">              
                                <p class="route-input start">             
                                    <i></i>
                                    <input type="text" name="walk_start_wd" id="mylocation" value="" placeholder="请输入起点" autocomplete="off" maxlength="256" data-from="start">              
                                </p>              
                                <p class="route-input end">                
                                    <i></i>
                                    <input type="text" name="walk_end_wd" id="walk_end_input" value="<?php echo ($job["work_address"]); ?>" placeholder="请输入终点" autocomplete="off" maxlength="256" data-from="end">              
                                </p>
                            </div>
                        
                                <input type="hidden" id='search-type' value="0">
                                <input value="搜索" class="route-submit" id="walkSearchBtn" title="" type="submit">
                            </form>
                        </div>

                        <!-- <label>
                        <select name='type' id='search-type'>
                            <option value="0">公交</option>
                            <option value="1">驾车</option>
                            <option value="2">步行</option>
                        </select>
                        </label>
                        <label>您的位置: </label>
                        <input type="text" name="mylocation" id="mylocation"/>
                        <label> 至 </label>
                        <input type="text" value="<?php echo ($job["work_address"]); ?>"/>
                        <button id="search_way"> 搜索 </button> -->
                            
                        </div>
                </div>
                <div class="apply" style="text-align:center">
                                <button id="apply" class="apply-btn">立即应聘</button>
                            </div>
                <!--地图end-->
            </div>
        </div>
    </div>
    <!--主体部分end-->
    <!--底部start-->
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
    <!--底部end-->
    <div id="shadow">

    </div>
</div>

<script>
    var uid = "<?php echo ($_SESSION['user']['id']); ?>";
    $(".apply-btn").click(function () {
        if(!uid){
            window.location.href = "<?php echo U('User/Login/index');?>";
        }else{
            //判断简历个数
            var resumeCount = "<?php echo ($resumeCount); ?>";
            if(resumeCount>0){
                layer.open({
                    type: 2,
                    title: '申请职位',
                    maxmin: true,
                    shadeClose: true, //点击遮罩关闭层
                    area : ['470px' , '300px'],
                    content: "<?php echo U('Portal/jobs/apply');?>&"+"id=<?php echo ($_GET['id']); ?>"
                });
            }else{
                //去新增简历
                alert("您还没有简历，请先新建简历");
                window.location.href = "<?php echo U('User/Resume/aeresume');?>";
            }
        }
    });
    $("#route_header li").click(function(){
        var type = $(this).data('index');
        $("#route_header li").removeClass("tab-active");
        $("#route_header li").eq(type).addClass("tab-active");
        if(type==0){
            $("#route_header li").find('i').removeClass('tab-active').removeClass('walk-tab-active').removeClass('drive-tab-active');
            $(this).find('i').addClass('bus-tab-active').addClass('tab-active');
        }else if(type==1){
            $("#route_header li").find('i').removeClass('walk-tab-active').removeClass('bus-tab-active');
            $(this).find('i').addClass('drive-tab-active').addClass('tab-active');
        }else if(type==2){
            $("#route_header li").find('i').removeClass('tab-active').removeClass('dirve-tab-active').removeClass('bus-tab-active');
            $(this).find('i').addClass('walk-tab-active').addClass('tab-active');
        }
        $("#search-type").val(type);
    })



    // 百度地图API功能
    var map = new BMap.Map("allmap");
    var work_map_x = "<?php echo ($job["work_map_x"]); ?>";
    var work_map_y = "<?php echo ($job["work_map_y"]); ?>";
    work_map_x = parseFloat(work_map_x);
    work_map_y = parseFloat(work_map_y);
    map.centerAndZoom(new BMap.Point(work_map_x,work_map_y), 12);
//    map.enableScrollWheelZoom();
//    var start = "腾讯大厦" ,end = "百度大厦";
//    var transit = new BMap.TransitRoute(map, {
//        renderOptions: {map: map}
//    });
//    transit.search(start,end);
//    var myIcon = new BMap.Icon("http://developer.baidu.com/map/jsdemo/img/location.gif", new BMap.Size(14,23));
//    //设置起终点图标
//    transit.setMarkersSetCallback(function(result){
//        result[0].marker.setIcon(myIcon);
//        result[1].marker.setIcon(myIcon);
//    });
    $("#walkSearchBtn").click(function () {
        var start = $("#mylocation").val() ;
        if(start==''){
            alert("请输入您的位置");
            return false;
        }

        var end = "<?php echo ($job["work_address"]); ?>";
        end ='西乡地铁站';
        var type = $("#search-type").val();
        if(type==0){
            var transit = new BMap.TransitRoute(map, {
                renderOptions: {map: map, panel: "r-result"}
            });
            transit.search(start, end);
        }else if(type==1){
            var driving = new BMap.DrivingRoute(map, {renderOptions: {map: map, panel: "r-result", autoViewport: true}});
    driving.search(start, end);
        }else if(type==2){
    //         var walking = new BMap.WalkingRoute(map, {renderOptions:{map: map, autoViewport: true}});
    // walking.search(start, end);

    var walking = new BMap.WalkingRoute(map, {renderOptions: {map: map, panel: "r-result", autoViewport: true}});
    walking.search(start, end);
        }
        return false;
    });
</script>

</body>
</html>