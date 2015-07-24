<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,Chrome=1" />
    <title>发布职位</title>

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
    <link rel="stylesheet" type="text/css" href="/tpl/v1/Public/css/datepicker.css"/>

    <script src="/statics/js/cache/region.js"></script>
    <script src="/statics/js/Util.js"></script>
    <script src="/tpl/v1/Public/js/bootstrap-datepicker.js"></script>
    <script type="text/javascript" src="http://api.map.baidu.com/api?v=2.0&ak=pOjKwgwxn0nlutaU2ppwIk8p"></script>
    <style type="text/css">
        #province,#city,#area{width:75px;}
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
                            <?php if($edit): ?>修改职位
                                <?php else: ?>
                                发布职位<?php endif; ?>
                        </div>
                    </div>
                    <div class="bd">
                        <div class="margin-out">
                            <div class="add-address data-item">
                                <dl>
                                    <dt>标题：</dt>
                                    <dd>
                                        <input type="text" name='job_name' placeholder="" value="<?php echo ($jobs['job_name']); ?>" />
                                        <label>
                                            （输入少于15个字符！）
                                        </label>
                                    </dd>
                                </dl>
                                <dl>

                                    <dd>
                                        <label>兼职类型：</label>
                                        <select name="cate-1" id="cate-1">
                                        <option value="0">请选择</option>
                                            <?php if(is_array($cate)): $i = 0; $__LIST__ = $cate;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><option value="<?php echo ($vo["id"]); ?>"><?php echo ($vo["name"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                                        </select>
                                        <label>兼职行业：</label>
                                        <select name="cate-2" id="cate-2">
                                            <option value="0">请选择</option>
                                        </select>
                                        <label>岗位名称：</label>
                                        <select name="cate-3" id="cate-3">
                                            <option value="0">请选择</option>
                                        </select>
                                    </dd>
                                </dl>
                                <dl style="display: none">
                                    <dt>*招聘人数：</dt>
                                    <dd>
                                        <input type="text" name='person_num' placeholder="招聘人数" value="<?php echo ($jobs['person_num']); ?>"/>

                                    </dd>
                                </dl>
                                <dl>
                                    <dt>工作内容：</dt>
                                    <dd>
                                        <input type="text" name='job_desc' placeholder="简要说明，如清理房间" value="<?php echo ($jobs['job_desc']); ?>"/>
                                        <label>（输入少于15个字符！） </label>
                                    </dd>
                                </dl>
                                <dl>
                                    <dt>详细工作内容（要求）：</dt>
                                    <dd style="height: 190px;width: 600px;" class="f">
                                        <textarea name="job_content" placeholder="字数限制在200字以内！" id="job_content" style="width: 600px;height: 190px;"><?php echo ($jobs['job_content']); ?></textarea>
                                    </dd>
                                </dl>
                                <div class="c"></div>
                                <dl>
                                    <dt>工作日期：</dt>
                                    <dd style="float: left;">
                                        <input type="text" id="work_start_date" name='work_start_date' placeholder="请选择日期" value="<?php echo ($jobs['work_start_date']); ?>" style="width: 130px" />
                                        <span> 至 </span>
                                        <input type="text" id="work_end_date" name='work_end_date' placeholder="请选择日期" value="<?php echo ($jobs['work_end_date']); ?>" style="width: 130px" />

                                    </dd>
                                    <dt style="margin-left: 10px;">工作时间：</dt>
                                    <dd>
                                        <input type="text" placeholder="手动输入" name="work_start_time" id="work_start_time" value="<?php echo ($job["work_start_time"]); ?>" style="width: 70px"/>
                                        <span> 至</span>
                                        <input type="text" placeholder="手动输入" name="work_end_time" id="work_end_time" value="<?php echo ($job["work_end_time"]); ?>" style="width: 70px;"/>

                                    </dd>
                                </dl>
                                <dl>

                                </dl>

                                <dl>
                                    <dt>工作时长：</dt>
                                    <dd class='fl' style='margin-right:20px'>
                                        <input name='work_total_date' type="text" value="<?php echo ($jobs['work_total_date']); ?>" style="width:70px" /> 小时
                                    </dd>
                                    <dt>兼职待遇：</dt>
                                    <dd>
                                        <input name='work_pay' type="text" value="<?php echo ($jobs['work_pay']); ?>"  style="width:70px" />元/小时
                                    </dd>
                                </dl>

                                <dl>
                                    <dt>结算方式：</dt>
                                    <dd class='fl' style='margin-right:20px'>
                                        <select name="pay_method" id="pay_method">
                                            <option value="0">现金</option>
                                            <option value="1">打卡</option>
                                        </select>
                                    </dd>
                                    <dt>结算时间：</dt>
                                    <dd class='fl' style='margin-right:20px'>
                                        <select name="pay_date" id="pay_date">
                                            <option value="0">日结</option>
                                            <option value="1">现金结算</option>
                                        </select>
                                    </dd>
                                    <dt>岗位性质：</dt>
                                    <dd>
                                        <select name="work_nature" id="work_nature">
                                           <?php if(is_array($nature)): $i = 0; $__LIST__ = $nature;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><option value="<?php echo ($vo["id"]); ?>"><?php echo ($vo["nature_name"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                                        </select>
                                    </dd>
                                </dl>
                                
                                <dl>
                                    <dt style='float:none;display:block'>详细地址：</dt>
                                    <dd class="work_place_obj" style='margin-left:27px;'>
                                    <label>省：</label>
                                        <select name="province" id="province">
                                            <option value="0">请选择</option>
                                        </select>
                                    <label>市：</label>
                                        <select name="city" id="city">
                                            <option value="0">请选择</option>
                                        </select>
                                    <label>区（县）：</label>
                                        <select name="area" id="area">
                                            <option value="0">请选择</option>
                                        </select>
                                         <input name='work_address' id="suggestId" type="text" placeholder="请输入路或巷、门牌号" value="<?php echo ($jobs['work_address']); ?>" />
                                        <div id="searchResultPanel" style="border:1px solid #C0C0C0;width:150px;height:auto; display:none;"></div>
                                    </dd>
                                </dl>
                                
                                <dl>
                                    <dt>请在下面地图标注具体所在的地点：</dt>
                                    <dd style="height: 360px;width: 700px;overflow:hidden;position:relative;border:1px solid #ccc;padding:10px" class="f">
                                        <input type="hidden" id="work_map_x" name="work_map_x" value="<?php echo ($jobs["work_map_x"]); ?>"/>
                                        <input type="hidden" id="work_map_y" name="work_map_y" value="<?php echo ($jobs["work_map_y"]); ?>" />
                                        <div id="allmap" style="height:300px"></div>
                                        <p class="red" style="margin-top:15px;">温馨提示：鼠标点击地图上所在地点就可以实现定位！</p>
                                    </dd>
                                </dl>

                                <?php if($edit == 1): ?><input type="hidden" id="jid" name="jid" value="<?php echo ($jobs['id']); ?>"/><?php endif; ?>
                                <input type="hidden" id="cate_url" value="<?php echo U('portal/jobs/get_son_cate');?>"/>
                                <div class="c"></div>
                                <div class="" style="margin-top: 25px;text-align:center">
                                    <button id='aejobs'>&nbsp;&nbsp;&nbsp;确&nbsp;&nbsp;&nbsp;定&nbsp;&nbsp;&nbsp;</button>
                                </div>
                            </div>


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


    <?php if($edit): ?>var gender = "<?php echo ($resume['gender']); ?>";
    $("select[name=gender]").val(gender);
    var degree = "<?php echo ($resume['degree']); ?>";
    $("select[name=degree]").val(degree);<?php endif; ?>
    $(function(){
        $('#work_start_date').datepicker({
            format: 'yyyy-mm-dd'
        });
        $('#work_end_date').datepicker({
            format: 'yyyy-mm-dd'
        });
    });

    var proins = '<option value="0">请选择</option>';
    for(var i in _province){
        proins+="<option value='"+_province[i].id+"'>"+_province[i].name+"</option>";
    }

    $("#province").html(proins);

    $("#province").change(function () {
        $obj = $(".work_place_obj");
        Util.regionChange(2,$(this).val(),$obj);
    });
    $("select[name=city]").change(function () {

        $obj = $(".work_place_obj");
        Util.regionChange(3,$(this).val(),$obj);
    });


    $("#aejobs").click(function(){

        var job = {
            job_name: $('input[name=job_name]').val(),
            job_desc:$("input[name=job_desc]").val(),
            catname :$("input[name=catname]").val(),
            person_num:$("input[name=person_num]").val(),
            job_content:$("textarea[name=job_content]").val(),
            catid:$("select[name=catid]").val(),
            work_start_time:$("input[name=work_start_time]").val(),
            work_end_time:$("input[name=work_end_time]").val(),
            work_start_date:$("input[name=work_start_date]").val(),
            work_end_date:$("input[name=work_end_date]").val(),
            work_total_date:$("input[name=work_total_date]").val(),
            work_pay:$("input[name=work_pay]").val(),
            pay_method:$("select[name=pay_method]").val(),
            pay_date:$("select[name=pay_date]").val(),
            work_nature:$("select[name=work_nature]").val(),
            province:$("select[name=province]").val(),
            city:$("select[name=city]").val(),
            area:$("select[name=area]").val(),
            work_address:$("input[name=work_address]").val(),
            work_map_x:$("input[name=work_map_x]").val(),
            work_map_y:$("input[name=work_map_y]").val(),
            jid:$("#jid").val()
        };
        var catid = '';
        var cate3 = $("#cate-3").val();
        if(cate3==0){
            var cate2 = $("#cate-2").val();
            if(cate2==0){
                cateid = $("#cate-1").val();
            }else{
                catid = cate2;
            }
        }else{
            catid = cate3;
        }
        job.catid = catid;
        if(job.job_name=='' || job.job_name.length>15){
            alert("招聘标题不能为空或者超过15个字符");
            return false;
        }
        if(job.job_desc=='' || job.job_desc.length>10){
            alert("工作简介不能为空或者超过10个字符");
            return false;
        }
        
        if(job.job_content=='' && job.job_content.length>200){
            alert("工作内容字数必须在小于200个字,并且不能为空");
            return false;
        }
        if(job.work_start_date=='' || job.work_end_date==''){
            alert("工作日期必须填写");
            return false;
        }
        if(job.work_start_date>job.work_end_date){
            alert("工作开始时间不能大于结束时间");
            return false;
        }

        if(!Util.isNum(job.work_total_date) || job.work_total_date<=0){
            alert("工作时长必须是大于0的数字");
            return false;
        }
        if(!Util.isNum(job.work_pay) || job.work_pay<=0){
            alert("价钱必须为大于0的数字");
            return false;
        }
        if(!job.province || !job.city || !job.area){

            alert("工作地区必须选择");
            return false;

        }
        if(job.work_address==''){
            alert('详细地址不能为空');
            return false;
        }
        if(!Util.isNum(job.work_map_x) ||!Util.isNum(job.work_map_y)){
            alert("请先标注地图");
            return false;
        }
    

        $.ajax({
            type:'post',
            url:"<?php echo U('user/jobs/aejobs');?>",
            dataType:'json',
            data: job,
            success:function(data){
                if(data.r==0){
                    alert('操作成功');
                    location.href="<?php echo U('user/jobs/index');?>";
                }else{
                    alert(data.msg);
                }
            }
        })
    });
    //如果是编辑
    var edit = "<?php echo ($edit); ?>";
    if(edit){
        var proid = '<?php echo ($jobs["work_province"]); ?>';
        var cityid = '<?php echo ($jobs["work_city"]); ?>';
        $("#province").val(proid);
        var obj = $(".work_place_obj");
        Util.regionChange(2,proid,obj);
        $("#city").val(cityid);
        Util.regionChange(3,cityid,obj);
        $("#area").val("<?php echo ($jobs["work_area"]); ?>");
    }
    //兼职类型
    $("#cate-1").change(function(){
        var id = $(this).val();
        if(id > 0){
            $.ajax({
                url:$("#cate_url").val(),
                type:'POST',
                dataType:'json',
                data:{id:id},
                success: function (data) {
                    var html = '<option value="0">不限</option>';
                    if(data.r==0) {
                        var msg = data.msg;
                        for(var i in msg){
                            var item = msg[i];
                            html+='<option value="'+item.id+'">'+item.name+'</option>';
                        }
                        $("#cate-2").html(html);
                    }
                }
            })
        }
    });

    $("#cate-2").change(function(){
        var id = $(this).val();
        if(id > 0){
            $.ajax({
                url:$("#cate_url").val(),
                type:'POST',
                dataType:'json',
                data:{id:id},
                success: function (data) {
                    var html = '<option value="0">不限</option>';
                    if(data.r==0) {
                        var msg = data.msg;
                        for(var i in msg){
                            var item = msg[i];
                            html+='<option value="'+item.id+'">'+item.name+'</option>';
                        }
                        $("#cate-3").html(html);
                    }
                }
            })
        }
    })



// 百度地图API功能
    // var map = new BMap.Map("allmap");
    // map.centerAndZoom(new BMap.Point(116.404, 39.915), 11);
    // function showInfo(e){
    //     alert(e.point.lng + ", " + e.point.lat);
    // }
    // map.addEventListener("click", showInfo);

// 百度地图API功能
//    function theLocation(){
//        var city = document.getElementById("cityName").value;
//        if(city != ""){
//            map.centerAndZoom(city,11);      // 用城市名设置地图中心点
//        }
//    }



    var map = new BMap.Map("allmap");
    map.enableScrollWheelZoom(true);     //开启鼠标滚轮缩放
//    var map = new BMap.Map("allmap");
    if(edit){
        var work_map_x = "<?php echo ($jobs["work_map_x"]); ?>";
        var work_map_y = "<?php echo ($jobs["work_map_y"]); ?>";
        work_map_x = parseFloat(work_map_x);
        work_map_y = parseFloat(work_map_y);
        map.centerAndZoom(new BMap.Point(work_map_x,work_map_y), 11);
    }else{
        var c = "<?php echo ($_SESSION['wiki']['city']); ?>";
        map.centerAndZoom(c,11);
    }

    //map.centerAndZoom(new BMap.Point(116.404, 39.915), 11);
    function showInfo(e){
        $("#work_map_x").val(e.point.lng);
        $("#work_map_y").val(e.point.lat);
        //alert(e.point.lng + ", " + e.point.lat);
        map.clearOverlays();  //删除已有的覆盖物
        var point = new BMap.Point(e.point.lng,e.point.lat);
        map.centerAndZoom(point, 15);
        var marker = new BMap.Marker(point);  // 创建标注
        map.addOverlay(marker);               // 将标注添加到地图中
        marker.setAnimation(BMAP_ANIMATION_BOUNCE); //跳动的动画
    }
    map.addEventListener("click", showInfo);



    // 百度地图API功能
    function G(id) {
        return document.getElementById(id);
    }

    //var map = new BMap.Map("l-map");
    map.centerAndZoom("深圳",12);                   // 初始化地图,设置城市和地图级别。

    var ac = new BMap.Autocomplete(    //建立一个自动完成的对象
        {"input" : "suggestId"
        ,"location" : map
    });

    ac.addEventListener("onhighlight", function(e) {  //鼠标放在下拉列表上的事件
    var str = "";
        var _value = e.fromitem.value;
        var value = "";
        if (e.fromitem.index > -1) {
            value = _value.province +  _value.city +  _value.district +  _value.street +  _value.business;
        }
        str = "FromItem<br />index = " + e.fromitem.index + "<br />value = " + value;

        value = "";
        if (e.toitem.index > -1) {
            _value = e.toitem.value;
            value = _value.province +  _value.city +  _value.district +  _value.street +  _value.business;
        }
        str += "<br />ToItem<br />index = " + e.toitem.index + "<br />value = " + value;
        G("searchResultPanel").innerHTML = str;
    });

    var myValue;
    ac.addEventListener("onconfirm", function(e) {    //鼠标点击下拉列表后的事件
    var _value = e.item.value;
        myValue = _value.province +  _value.city +  _value.district +  _value.street +  _value.business;
        G("searchResultPanel").innerHTML ="onconfirm<br />index = " + e.item.index + "<br />myValue = " + myValue;

        setPlace();
    });

    function setPlace(){
        map.clearOverlays();    //清除地图上所有覆盖物
        function myFun(){
            var pp = local.getResults().getPoi(0).point;    //获取第一个智能搜索的结果
            map.centerAndZoom(pp, 18);
            map.addOverlay(new BMap.Marker(pp));    //添加标注
        }
        var local = new BMap.LocalSearch(map, { //智能搜索
          onSearchComplete: myFun
        });
        local.search(myValue);
    }

</script>
</body>
</html>