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

    <link href="/trunk/job/tpl/v1/Public/zp/css/index.css" rel="stylesheet" type="text/css" />
    <script src="/statics/js/cache/region.js"></script>
    <script src="/trunk/job/tpl/v1/Public/js/jquery-1.11.1.min.js" type="text/javascript" language="javascript"></script>
    <link href="/trunk/job/tpl/v1/Public/zp/css/common.css" rel="stylesheet" type="text/css" />
    <link href="/trunk/job/tpl/v1/Public/zp/css/style.css" rel="stylesheet" type="text/css" />
</head>
<body>
<div class="wrap">
    <!--头部start-->

    <div class="change_city_bg">

    </div>
    <!--头部end-->
    <!--主体部分-->
    <div id="main" class="main">

        <div class="change-city">
            <div class="place">
                <span class="choose">请选择城市</span>
                <div class="content">

                    <div class="c"></div>
                </div>
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